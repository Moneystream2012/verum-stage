<?php

namespace App\Http\Controllers\Administrator;

use App\Notifications\Users\NewSupportMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class IssuesController extends Controller
{
    public function showNew()
    {
        $users = User::pluck('username', 'id');

        return view('administrator.issues.new', ['users' => $users]);
    }

    public function created(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        $user = User::findOrFail($request->input('user_id'));

        $issue = auth()->user()->issues()->create([
            'title'        => $request->input('title'),
            'status'       => 1,
            'support_type' => 'admin',
            'user_id'      => $user->id,
        ]);

        $issue->dialogs()->create([
            'body'       => $request->input('body'),
            'is_support' => true,
        ]);
        flash()->success('Отправлен')->important();
        $user->notify(new NewSupportMessage($issue->id));

        return redirect()->route('administrator.issues.index', ['status' => 1]);
    }

    public function index($status = 0)
    {
        $issues = auth()->user()->issues()->with(['dialogs', 'user' => function ($query) {
            $query->select('id', 'first_name', 'last_name', 'username', 'plan', 'avatar');
        }])->whereStatus($status)->orderBy('id', 'desk')->get();
        $issues = $issues->groupBy('user_id')->map(function ($items){
            $data = [
                'lasts' => []
            ];
            $i = 0;
            foreach ($items as $item){
                if($i == 0){
                    $data['first'] = $item;
                }
                if($i > 0){
                    $data['lasts'][] = $item;
                }
                $i++;
            }
           return $data;
        });

        return view('administrator.issues.index', compact('issues'));
    }

    public function dialog($id)
    {
        $issue = auth()->user()->issues()->with('dialogs')->FindOrFail($id);

        return view('administrator.issues.dialog', ['issue' => $issue]);
    }

    public function send(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $issue = auth()->user()->issues()->FindOrFail($id);

        $issue->update([
            'status' => 1,
            'read' => 0,
        ]);

        $issue->dialogs()->create([
            'body'       => $request->input('body'),
            'is_support' => true,
        ]);
        $issue->user->notify(new NewSupportMessage($issue->id));
        flash()->success('Send success')->important();

        return redirect()->back();
    }

    public function closed($id)
    {
        $issue = auth()->user()->issues()->FindOrFail($id);
        $issue->update([
            'status' => 2,
        ]);
        flash()->success('Закрыт #'.$id)->important();

        return redirect()->route('administrator.issues.index');
    }
}
