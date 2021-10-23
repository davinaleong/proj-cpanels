@extends('layouts.auth')

@section('content')
    <main class="d-flex align-items-center justify-content-center">
        <form method="POST" action="{{ route('login') }}" class="p-3">
            @csrf

            <h1 class="text-center">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            @include('errors')

            <button type="submit" class="btn btn-primary">Log-in <i class="fa fa-sign-in-alt fa-fw"></i></button>
        </form>
    </main>
@endsection
