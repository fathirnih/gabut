@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="mb-3">Results — {{ $poll->title }}</h1>

    @php $total = $poll->options->sum('votes_count'); @endphp

    <div class="row">
        @foreach($poll->options as $option)
            @php $percent = $total ? round($option->votes_count / $total * 100) : 0; @endphp
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><strong>{{ $option->text }}</strong></div>
                            <div class="small-muted">{{ $option->votes_count }} votes — {{ $percent }}%</div>
                        </div>
                        <div class="progress mt-2">
                            <div class="progress-bar" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('admin.polls.index') }}" class="btn btn-link">Back</a>
</div>
@endsection