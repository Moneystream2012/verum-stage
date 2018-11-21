<?php

namespace App\Http\Controllers\User;

use App\Deposit;
use App\Events\Users\Registered;
use App\Trading;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SponsoredController extends Controller
{
    public function binary($user_id = null)
    {
        $root_id = auth()->id();

        if ($user_id) {
            User::findOrFail($user_id);

            $user_id = (int)$user_id;
            $result = cache()->store('tarantool')->getCall('is_user_id_binary', [
                $root_id,
                $user_id,
            ])[0];

            if (!$result) {
                $user_id = null;
            }
        }

        $binary_tree = cache()->store('tarantool')->getCall('get_user_binary_tree', [$user_id ?? $root_id])[0];

        $binary_tree['users'] = array_replace_recursive([
            'children' => [
                [
                    'children' => [
                        [
                            'children' => [
                                [
                                    'children' => [

                                    ],
                                ],
                                [
                                    'children' => [

                                    ],
                                ],
                            ],
                        ],
                        [
                            'children' => [
                                [
                                    'children' => [

                                    ],
                                ],
                                [
                                    'children' => [

                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'children' => [
                        [
                            'children' => [
                                [
                                    'children' => [

                                    ],
                                ],
                                [
                                    'children' => [

                                    ],
                                ],
                            ],
                        ],
                        [
                            'children' => [
                                [
                                    'children' => [

                                    ],
                                ],
                                [
                                    'children' => [

                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $binary_tree['users']);

        if ($user_id) {
            $result = cache()->store('tarantool')->getCall('get_parent_by_user_id', [$user_id])[0];
            $binary_tree['users']['parent'] = $result;
        }
        $avatars = User::whereIn('id', $binary_tree['users_id'])->select('id', 'avatar', 'plan')->get()->map(function (
            $user
        ) {
            return [
                'id' => $user->id,
                'avatar' => $user->avatar_url,
            ];
        })->pluck('avatar', 'id');

        $data = [
            'users' => $binary_tree['users'],
            'avatars' => $avatars,
            //'count'    => $binary_tree['count'],
        ];

        return view('personal-office/sponsored.binary', $data);
    }

    public function search_user(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|alpha_dash|max:60|is_user',
            'search' => 'required|in:binary,unilevel',
        ]);

        $user = User::nameOrId($request->input('user'))->select('id', 'sponsor_id')->first();

        $search = $request->input('search');

        if ($search == 'binary') {
            $result = cache()->store('tarantool')->getCall('is_user_id_binary', [
                auth()->id(),
                (int)$user->id,
            ])[0];
            if ($result) {
                return redirect()->route('personal-office.sponsored.' . $search, ['user_id' => $user->id]);
            }
        }

        if ($search == 'unilevel' && $user->sponsor_id == auth()->id()) {
            return redirect()->route('personal-office.sponsored.unilevel', ['user_id' => $user->id]);
        }

        flash()->error(trans('validation.not_user'))->important();

        return redirect()->back();
    }

    public function unilevel($user_id = null)
    {
        $user = auth()->user();

        if ($user_id) {
            $sponsor = User::findOrFail($user_id);
            if ($sponsor->sponsor_id != $user->id) {
                $sponsor = null;
            }
        }

        $data = [
            'sponsors' => $this->getUnilevelSponsors($user),
            'level' => 1,
        ];
        if (isset($sponsor)) {
            $data['search'] = true;
            $data['sponsors'] = [$sponsor];
        }

        return view('unify.personal-office/sponsored.unilevel', $data);
    }

    private function getUnilevelSponsors(User $user)
    {
        $sponsors = $user->sponsors()->with([
            'sponsors' => function ($q) {
                return $q->with([
                    'deposits' => function ($q) {
                        return $q->where('active', 1);
                    },
                    'tradings' => function ($q) {
                        return $q->where('status', Trading::ACTIVE);
                    },
                ]);
            },
            'deposits' => function ($q) {
                return $q->where('active', 1);
            },
            'tradings' => function ($q) {
                return $q->where('status', Trading::ACTIVE);
            },
        ])->oldest()->select('id', 'first_name', 'last_name', 'username', 'leg', 'avatar', 'email', 'mobile_number', 'sponsor_id')->get();

        return $sponsors;
    }

    public function unilevel_ajax($user_id)
    {
        $level = cache()->store('tarantool')->getCall('is_user_id_unilevel', [
            auth()->id(),
            (int)$user_id,
        ])[0];
        if (!$level || $level == 8) {
            return '';
        }

        $sponsors = $this->getUnilevelSponsors(User::findOrFail($user_id));

        return view('unify.personal-office.partials.unilevel.items')->with([
            'sponsors' => $sponsors,
            'level' => $level + 1,
        ])->render();
    }

    public function full()
    {
        $user_id = auth()->id();

        $json = cache()->store('tarantool')->getCall('get_user_binary_full_json', [$user_id])[0];

        return view('personal-office/sponsored.full')->with(['json' => $json]);
    }

    public function new_member()
    {
        $countries = \Countries::getList(\App::getLocale());

        return view('personal-office/sponsored.new_member', compact('countries'));
    }

    public function create_member(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:60|min:2|alpha',
            'last_name' => 'required|max:60|min:2|alpha',
            'username' => 'required|username|max:30|min:3|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'mobile_number' => 'required|phone:mobile_code|unique:users',
            'password' => 'required|min:6|max:255|confirmed',
            'country' => 'required|string|max:2',
        ]);

        $sponsor = auth()->user();
        $data = $request->toArray();
        $data['transaction_password'] = str_random(8);
        $data['sponsor_id'] = $sponsor->id;
        $data['leg'] = $sponsor->side_leg;
        $data['side_leg'] = $sponsor->side_leg;
        $data['mobile_number'] = phone($request->input('mobile_number'), $request->input('mobile_code'), 0);

        if (!$sponsor->team_developer) {
            $sponsor->side_leg = !$sponsor->side_leg;
            $sponsor->save();
        }

        $user = User::createUser($data);
        $data['id'] = $user->id;
        event(new Registered($user, $data));
        flash(trans('personal-office/sponsored/new_member.success'), 'success')->important();

        return view('personal-office.sponsored.login-details')->with('user', (object)$data);
    }
}
