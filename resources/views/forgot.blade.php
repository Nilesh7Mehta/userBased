@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Forgot Password</h2>
    @if(session('msg'))
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    <form action="{{ route('forgotPasswordProcess') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Enter your email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
    </form>
</div>
@endsection
