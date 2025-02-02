@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h2 class="text-center mb-4">Login</h2>

    @if (session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
@endif

    <form action="{{route('loginProcess')}}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
            @error('email')
           <div class="invalid-feedback">{{$message}}</div>
           @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
            @error('password')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success btn-block">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{route('forgotPassword')}}">Forgot Password?</a>
    </div>

    <div class="text-center mt-3">
        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>
@endsection
