@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Admin — Polls</h1>
    <a href="{{ route('admin.polls.create') }}" class="btn btn-primary mb-3">Create Poll</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul>
        @foreach($polls as $poll)
            <li>
                <strong>{{ $poll->title }}</strong>
                <a href="{{ route('admin.polls.edit', $poll) }}">Edit</a>
                <form action="{{ route('admin.polls.destroy', $poll) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-link">Delete</button>
                </form>
                <a href="{{ route('admin.polls.results', $poll) }}">Results</a>
            </li>
        @endforeach
    </ul>

    {{ $polls->links() }}
</div>
@endsection
