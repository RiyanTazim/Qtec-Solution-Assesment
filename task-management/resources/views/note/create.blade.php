@extends('note.master')


@section('context')
    <section>
        <h1 class="text-center py-3 bg-secondary text-light">Add Task</h1>
        <h3 class="text-center text-success pt-4" id="success-msg" style="height: 40px">{{ Session()->get('notification') }}
        </h3>
        <form class="p-5" action="{{ route('note.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" class="form-control" name="content">
            </div>
            <div class="mb-3">
                <label class="form-label">Set Priority</label>
                <select class="form-control" name="priority" required>
                    <option value="" disabled selected>Select priority</option>
                    <option value="1">High</option>
                    <option value="3">Medium</option>
                    <option value="2">Low</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
    </section>
@endsection
