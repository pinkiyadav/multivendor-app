@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card p-4">
            <h3 class="text-center mb-3">Login</h3>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>

                <div class="mt-2 text-center">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection