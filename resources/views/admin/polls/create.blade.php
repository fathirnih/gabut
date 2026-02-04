@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>Create Poll</h1>

    <form method="POST" action="{{ route('admin.polls.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Expires at</label>
            <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
        </div>
        <div id="options">
            <label class="form-label">Options</label>
            <input type="text" name="options[]" class="form-control mb-2">
            <input type="text" name="options[]" class="form-control mb-2">
        </div>
        <button type="button" class="btn btn-secondary" onclick="addOption()">Add option</button>
        <button class="btn btn-primary">Create</button>
    </form>
</div>

<script>
function addOption() {
    var div = document.getElementById('options');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.className = 'form-control mb-2';
    div.appendChild(input);
}
</script>
@endsection
