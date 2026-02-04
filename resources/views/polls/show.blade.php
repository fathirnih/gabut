@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

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
        @foreach($poll->options as $option)
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="option_id" id="opt-{{ $option->id }}" value="{{ $option->id }}">
                <label class="form-check-label" for="opt-{{ $option->id }}">{{ $option->text }}
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <small class="ms-2">({{ $option->votes_count }} votes)</small>
                    @endif
                </label>
            </div>
        @endforeach

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Vote</button>
            <a href="{{ route('polls.index') }}" class="btn btn-link">Back to Polls</a>
        </div>
    </form>
</div>
@endsection
