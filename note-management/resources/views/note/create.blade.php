@extends('note.master')


@section('context')
    <section>
        <h1 class="text-center py-3 bg-secondary text-light">Add Note</h1>
        <h3 class="text-center text-success pt-4" id="success-msg" style="height: 40px">{{ Session()->get('notification') }}
        </h3>
        <form class="p-5" action="{{ route('note.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <input type="text" class="form-control" name="content">
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </section>
@endsection
