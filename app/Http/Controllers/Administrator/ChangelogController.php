<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Changelog;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function index()
    {
        $data = Changelog::latest()->get();

        return view('administrator.changelog.index', [
            'data' => $data,
        ]);
    }

    public function add()
    {
        return view('administrator.changelog.add');
    }

    public function addPost(Request $request)
    {
        Changelog::create([
            'status'      => $request->input('status'),
            'main_text'   => array_filter($request->input('text')),
            'footer_text' => $request->input('footer_text', ''),
        ]);

        flash()->success('Changelog: Create');

        return redirect()->route('administrator.changelog.index');
    }

    public function remove(int $id)
    {
        Changelog::destroy($id);
        flash()->success('Changelog: Remove');

        return redirect()->route('administrator.changelog.index');
    }

    public function active(int $id)
    {
        Changelog::where('active', true)->where('id', '<>', $id)->update(['active' => false]);
        $changelog = Changelog::whereId($id)->first();
        $changelog->active = ! $changelog->active;
        $changelog->save();

        flash()->success('Changelog: '.($changelog->active == true ? 'Active' : 'Disable'));

        return redirect()->route('administrator.changelog.index');
    }
}
