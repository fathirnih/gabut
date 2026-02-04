@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $poll->title }}</h1>
    <p>{{ $poll->description }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('polls.vote', $poll) }}">
        @csrf
        <ul>
            @foreach($poll->options as $option)
                <li>
                    <label>
                        <input type="radio" name="option_id" value="{{ $option->id }}"> {{ $option->text }}
                        <small>({{ $option->votes_count }} votes)</small>
                    </label>
                </li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary">Vote</button>
    </form>
</div>
@endsection
