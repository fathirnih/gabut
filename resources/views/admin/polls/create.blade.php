@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2>Create Poll</h2>

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
                    <div class="option-row d-flex mb-2">
                        <input type="text" name="options[]" class="form-control me-2" placeholder="Option text">
                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Remove</button>
                    </div>
                    <div class="option-row d-flex mb-2">
                        <input type="text" name="options[]" class="form-control me-2" placeholder="Option text">
                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Remove</button>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-secondary" onclick="addOption()">Add option</button>
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addOption() {
    var div = document.getElementById('options');
    var row = document.createElement('div');
    row.className = 'option-row d-flex mb-2';
    row.innerHTML = '<input type="text" name="options[]" class="form-control me-2" placeholder="Option text"><button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">Remove</button>';
    div.appendChild(row);
}
</script>
@endsection
