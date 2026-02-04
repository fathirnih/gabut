@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Polls</h1>
    </div>

    <div class="row">
        @foreach($polls as $poll)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title mb-1">{{ $poll->title }}</h5>
                            @if($poll->expires_at && now()->greaterThan($poll->expires_at))
                                <span class="badge bg-secondary">Expired</span>
                            @elseif($poll->expires_at)
                                <span class="small-muted">Expires: {{ $poll->expires_at->toDateString() }}</span>
                            @endif
                        </div>

                        <p class="card-text text-truncate">{{ $poll->description }}</p>

                        <div class="mt-auto">
                            @if(in_array($poll->id, $votedPollIds ?? []))
                                <div class="alert alert-info mb-0">You already voted on this poll.</div>
                                <div class="mt-2"><a href="{{ route('polls.show', $poll) }}" class="btn btn-sm btn-outline-primary">View</a></div>
                            @elseif($poll->expires_at && now()->greaterThan($poll->expires_at))
                                <div class="alert alert-secondary mb-0">Poll expired</div>
                            @else
                                <form method="POST" action="{{ route('polls.vote', $poll) }}">
                                    @csrf
                                    @foreach($poll->options as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="option_id" id="opt-{{ $option->id }}-{{ $poll->id }}" value="{{ $option->id }}">
                                            <label class="form-check-label" for="opt-{{ $option->id }}-{{ $poll->id }}">{{ $option->text }}</label>
                                        </div>
                                    @endforeach

                                    <div class="mt-3 d-flex gap-2">
                                        <button class="btn btn-sm btn-primary">Vote</button>
                                        <a href="{{ route('polls.show', $poll) }}" class="btn btn-sm btn-link">Details</a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">{{ $polls->links() }}</div>
</div>
@endsection
