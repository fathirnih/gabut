@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Results — {{ $poll->title }}</h1>

    @php $total = $poll->options->sum('votes_count'); @endphp

    <div class="list-group mb-3">
        @foreach($poll->options as $option)
            @php $percent = $total ? round($option->votes_count / $total * 100) : 0; @endphp
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div><strong>{{ $option->text }}</strong></div>
                    <div><span class="small-muted">{{ $option->votes_count }} votes — {{ $percent }}%</span></div>
                </div>
                <div class="progress mt-2" style="height:8px">
                    <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('admin.polls.index') }}">Back</a>
</div>
@endsection