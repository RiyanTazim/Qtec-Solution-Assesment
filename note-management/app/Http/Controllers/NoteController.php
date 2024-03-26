<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NoteController extends Controller
{
    public function dashboard()
    {
        $notes = Note::where('user_id', Session::get('user_id'))->get();
        return view('note.manage', compact('notes'));
        // return view('note.manage');
    }

    public function create()
    {
        return view('note.create');
    }

    public function store(Request $request)
    {
        $note = new Note();
        $note->user_id = Session::get('user_id');
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        return redirect()->route('dashboard')->with('notification', 'Note added successfully');
    }

    public function edit($id)
    {
        $note = Note::find($id);
        return view('note.edit', compact('note'));
    }

    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        return redirect()->route('dashboard')->with('notification', 'Note updated successfully');
    }

    public function delete($id)
    {
        $note = Note::find($id);

        $note->delete();
        return back()->with('notification', 'Note deleted successfully');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $notes = Note::query()
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->get();

        return view('note.manage', compact('notes'));
    }

}
