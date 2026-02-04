@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h1>{{ $poll->title }}</h1>
            <p class="small-muted">{{ $poll->description }}</p>

            @if(session('success'))
                <div class="toast align-items-center show mb-3" role="alert"><div class="toast-body">{{ session('success') }}</div></div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('polls.vote', $poll) }}">
                @csrf
                @foreach($poll->options as $option)
                    <div class="form-selectgroup-boxes row mb-2">
                        <label class="form-selectgroup-item col-12">
                            <input type="radio" name="option_id" value="{{ $option->id }}" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">{{ $option->text }}
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <small class="ms-2">({{ $option->votes_count }} votes)</small>
                                @endif
                            </span>
                        </label>
                    </div>
                @endforeach

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Vote</button>
                    <a href="{{ route('polls.index') }}" class="btn btn-link">Back to Polls</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
