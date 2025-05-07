@extends('note.master')

@section('context')
    <section>
        <h1 class="text-center py-3 bg-secondary text-light">Edit Task</h1>
        <h3 class="text-center text-success pt-4" id="success-msg" style="height: 40px">{{ Session()->get('notification') }}
        </h3>
        <form class="p-5" action="{{ route('note.update', $note->id) }}" method="POST" >
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{ $note->title }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="content" value="{{ $note->content }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Set Priority</label>
                <select class="form-control" name="priority" required>
                    <option value="1" {{ $note->priority == 1 ? 'selected' : '' }}>High</option>
                    <option value="3" {{ $note->priority == 3 ? 'selected' : '' }}>Medium</option>
                    <option value="2" {{ $note->priority == 2 ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </section>
@endsection
