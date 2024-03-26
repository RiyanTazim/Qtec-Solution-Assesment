@extends('note.master')

@section('context')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center text-success pt-4" id="success-msg" style="height: 60px">
                            {{ Session()->get('notification') }}</h3>
                        <h6 class="card-title">User Note List</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        {{-- <th>User ID</th> --}}
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notes as $note)
                                        <tr>
                                            <td>{{ $note->id }}</td>
                                            <td>{{ $note->title }}</td>
                                            <td>{{ $note->content }}</td>
                                            {{-- <td>{{ $note->user_id }}</td> --}}
                                            <td>{{ $note->created_at }}</td>
                                            <td>{{ $note->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('note.edit', $note->id) }}" type="button"
                                                    class="btn btn-success m-2">Edit</a>
                                                <a href="{{ route('note.delete', $note->id) }}" type="button"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are You Sure?')">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
