@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="hero">
    <h1>تسجيل الدخول</h1>
</div>
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                        </button>
                        {{-- <a href="{{ route('register') }}" class="btn btn-light ml-2">
                            <i class="fas fa-user-plus"></i> التسجيل
                        </a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection