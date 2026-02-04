@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Your Dashboard</h1>

    <ul>
        @foreach($polls as $poll)
            <li>
                <a href="{{ route('polls.show', $poll) }}">{{ $poll->title }}</a>
                @if($poll->expires_at)
                    <small>(expires: {{ $poll->expires_at->toDateString() }})</small>
                @endif
            </li>
        @endforeach
    </ul>

    {{ $polls->links() }}
</div>
@endsection
