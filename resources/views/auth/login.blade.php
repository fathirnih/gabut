@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Login</h1>

    <form method="POST" action="{{ url('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
