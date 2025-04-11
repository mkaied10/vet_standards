@extends('layouts.app')
@section('title', 'إدارة المستخدمين')
@section('content')
<div class="hero">
    <h1>إدارة المستخدمين</h1>
</div>
<div class="mb-3 text-left">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة مستخدم جديد</a>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>الدور</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection