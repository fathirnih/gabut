@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Results — {{ $poll->title }}</h1>

    <ul>
        @foreach($poll->options as $option)
            <li>{{ $option->text }} — <strong>{{ $option->votes_count }}</strong> votes</li>
        @endforeach
    </ul>

    <a href="{{ route('admin.polls.index') }}">Back</a>
</div>
@endsection