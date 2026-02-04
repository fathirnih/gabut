@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-1">Welcome, {{ auth()->user()->name }}!</h2>
                    <div class="small-muted mb-3">You are logged in as <strong>{{ auth()->user()->role }}</strong>.</div>

                    <div class="btn-list">
                        @if(auth()->user()->isAdmin())
                            <a class="btn btn-primary" href="{{ route('admin.polls.index') }}">Manage Polls</a>
                            <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Manage Members</a>
                            <a class="btn btn-outline-secondary" href="{{ route('admin.votes.index') }}">View Votes</a>
                        @else
                            <a class="btn btn-primary" href="{{ route('polls.index') }}">Start Voting</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">Recent Polls</div>
                <div class="list-group list-group-flush">
                    @foreach(\App\Models\Poll::latest()->limit(5)->get() as $poll)
                        <a href="{{ route('polls.show', $poll) }}" class="list-group-item list-group-item-action">{{ $poll->title }} <span class="small-muted">• {{ $poll->created_at->diffForHumans() }}</span></a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
