<?php
namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NoteController extends Controller
{
    public function dashboard()
    {
        $notes = Note::where('user_id', Session::get('user_id'))
            ->orderBy('priority', 'asc')
            ->get();
        return view('note.manage', compact('notes'));

    }

    public function create()
    {
        return view('note.create');
    }

    public function store(Request $request)
    {
        $note           = new Note();
        $note->user_id  = Session::get('user_id');
        $note->title    = $request->title;
        $note->content  = $request->content;
        $note->priority = $request->priority;
        $note->save();

        return redirect()->route('dashboard')->with('notification', 'Task added successfully');
    }

    public function edit($id)
    {
        $note = Note::find($id);
        return view('note.edit', compact('note'));
    }

    public function update(Request $request, $id)
    {
        $note           = Note::find($id);
        $note->title    = $request->title;
        $note->content  = $request->content;
        $note->priority = $request->priority;
        $note->save();

        return redirect()->route('dashboard')->with('notification', 'Task updated successfully');
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
            ->orWhere('priority', 'LIKE', "%{$search}%")
            ->get();

        return view('note.manage', compact('notes'));
    }

    // public function updatePriority(Request $request)
    // {
    //     $order = $request->input('order');
    //     foreach ($order as $index => $item) {
    //         $note = Note::find($item['id']);
    //         if ($note) {
    //             $note->priority = $item['priority'];
    //             $note->save();
    //         }
    //     }

    //     return response()->json(['success' => true]);
    // }

    public function updatePriority(Request $request)
    {
        $sortedIDs = $request->input('sorted_ids');

        foreach ($sortedIDs as $index => $id) {
            $note = Note::find($id);

            if ($note) {
                $note->priority = $index + 1;
                $note->save();
            }
        }

        return response()->json(['message' => 'Priority updated successfully!']);
    }

}
