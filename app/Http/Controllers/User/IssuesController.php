<?php

namespace App\Http\Controllers\User;

use App\Issue;
use App\Notifications\Administrator\NewUserOfSupportMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IssuesController extends Controller
{
    public function new()
    {
        return view('unify.personal-office.issues.new');
    }

    public function index()
    {
        $issues = auth()->user()->issues()->orderBy('id', 'DESK')->get();

        return view('unify.personal-office.issues.index', ['issues' => $issues]);
    }

    public function show($id)
    {
        $issue = auth()->user()->issues()->findOrFail($id);
        if(!$issue->read) {
            $issue->read = 1;
            $issue->save();
        }

        return view('unify.personal-office.issues.show', ['issue' => $issue]);
    }

    public function send(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $issue = auth()->user()->issues()->findOrFail($id);

        if ($issue->is_baned_send) {
            flash()->error('Baned send!')->important();

            return redirect()->back();
        }

        $issue->update(['status' => 0]);
        $issue->dialogs()->create([
            'body' => $request->input('body'),
        ]);

        $issue->support->notify(new NewUserOfSupportMessage($issue->id));
        flash()->success('Send success')->important();

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        $issue = auth()->user()->issues()->create([
            'title'        => $request->input('title'),
            'support_type' => 'admin',
            'support_id'   => 1,
        ]);

        $issue->dialogs()->create(['body' => $request->input('body')]);
        $issue->support->notify(new NewUserOfSupportMessage($issue->id));
        flash()->success(trans('unify/personal-office/issues/new.msg_success'))->important();

        return redirect()->route('personal-office.issues.show', ['id' => $issue->id]);
    }
}
