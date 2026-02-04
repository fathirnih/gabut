@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Admin — Polls</h1>
        <a href="{{ route('admin.polls.create') }}" class="btn btn-primary">Create Poll</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Expires</th>
                        <th>Options</th>
                        <th>Votes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($polls as $poll)
                        @php $totalVotes = $poll->options->sum('votes_count'); @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center"><div class="me-3">
                                    <span class="avatar bg-secondary text-white">{{ strtoupper(substr($poll->title,0,1)) }}</span>
                                </div>
                                <div>
                                    <div class="font-weight-medium">{{ $poll->title }}</div>
                                    <div class="small-muted">#{{ $poll->id }} • {{ $poll->created_at->diffForHumans() }}</div>
                                </div></div>
                            </td>
                            <td>{{ Str::limit($poll->description, 80) }}</td>
                            <td>{{ $poll->expires_at ? $poll->expires_at->toDateTimeString() : '-' }}</td>
                            <td>{{ $poll->options_count }}</td>
                            <td><span class="badge bg-info">{{ $totalVotes }}</span></td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.polls.edit', $poll) }}">Edit</a>
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.polls.results', $poll) }}">Results</a>
                                <form method="POST" action="{{ route('admin.polls.destroy', $poll) }}" style="display:inline" onsubmit="event.preventDefault(); openDeleteModal(this);">
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

    <div class="mt-3">{{ $polls->links() }}</div>
</div>
@endsection
