@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Votes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap">
                <thead>
                    <tr><th>Poll</th><th>Option</th><th>User</th><th>IP</th><th>When</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @foreach($votes as $vote)
                        <tr>
                            <td>{{ $vote->poll->title }}</td>
                            <td>{{ $vote->option->text }}</td>
                            <td>{{ optional($vote->user)->email ?? 'Guest' }}</td>
                            <td>{{ $vote->ip }}</td>
                            <td>{{ $vote->created_at }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.votes.destroy', $vote) }}" onsubmit="event.preventDefault(); openDeleteModal(this);">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $votes->links() }}
</div>
@endsection