<?php

namespace App\Http\Controllers\Administrator;

use App\DataTables\Administrator\VerificationsDataTable;
use App\DataTables\Scopes\QueryWhereDataTableScope;
use App\DataTables\Scopes\UserIdDataTableScope;
use App\Verification;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;


class VerificationController extends Controller
{
    public function index(VerificationsDataTable $dataTable, $user_id = null, $status = null)
    {
        return $dataTable
            ->addScope(new UserIdDataTableScope($user_id))
            ->addScope(new QueryWhereDataTableScope('status', '=', $status))
            ->render('administrator.verification');
    }

    public function verified(Request $request, int $user_id, bool $verified)
    {
        $verification = Verification::findOrFail($user_id);

        if(!$verified) {
            $verification->delete();
            return response()->json(['msg' => 'Верификация отклонена.'], 200);
        }
        $user = $verification->user;
        $user->first_name = $verification->first_name;
        $user->last_name = $verification->last_name;
        $user->mobile_number = $verification->mobile_number;
        $user->email = $verification->email;
        $user->country = $verification->country;
        try {
            File::move(Storage::disk('verifications')->path($verification->avatar), Storage::disk('avatars')->path($verification->avatar));
            if($user->avatar) {
                Storage::disk('avatars')->delete($user->avatar);
            }
            $user->avatar = $verification->avatar;
            $user->save();
            $verification->update(['status' => Verification::VERIFIED]);
        } catch (\Exception $exception) {
            return response()->json(['msg' => 'Error Save!'], 500);
        }

        return response()->json(['msg' => 'Пользователь верифицирован.'], 200);
    }
}
