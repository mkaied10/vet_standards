@extends('layouts.app')
@section('title', 'إضافة مستخدم جديد')
@section('content')
<div class="hero">
    <h1>إضافة مستخدم جديد</h1>
</div>
<div class="card mt-4">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>الاسم</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>الإيميل</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label>الدور</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="user">مستخدم عادي</option>
                    <option value="admin">أدمن</option>
                </select>
                @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection