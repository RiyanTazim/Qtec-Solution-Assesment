<?php

namespace App\Livewire;

use App\Models\Note;
use Livewire\Component;

class NoteSort extends Component
{

    public $notes = [];

    public function render()
    {
        // return view('livewire.note-sort');
        return view('note.manage');
    }

    // public function mount()
    // {
    //     $this->notes = Note::where('user_id', session('user_id'))
    //         ->orderBy('priority') // 1 = High, 2 = Low, 3 = Medium
    //         ->get()
    //         ->toArray();
    // }

    // public function updateTaskOrder($orderedIds)
    // {
    //     foreach ($orderedIds as $index => $id) {
    //         Note::where('id', $id)->update(['priority' => $index + 1]);
    //     }

    //     $this->mount(); // refresh the list
    // }




    public function updateTaskOrder($noteId, $newPriority = 1)
    {
        $note = Note::find($noteId);
        $note->priority = $newPriority;
        $note->save();
    }
    
    // public function updateOrder($list)
    // {
    //     foreach ($list as $item) {
    //         Note::find($item['id'])->update(['priority' => $item['order']]);
    //     }
    // }
}