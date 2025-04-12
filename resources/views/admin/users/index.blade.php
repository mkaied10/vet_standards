@extends('layouts.app')
@section('title', 'إدارة المستخدمين')
@section('content')
<div class="hero">
    <h1>إدارة المستخدمين</h1>
</div>
<div class="mb-3 text-left">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة مستخدم</a>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="table-responsive">
    <table class="table table-hover" id="users-table">
        <thead class="thead-dark">
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @if($users->isNotEmpty())
                @foreach($users as $user)
                <tr id="user-{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                        <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}"><i class="fas fa-trash"></i> حذف</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">لا توجد مستخدمين متاحين</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // حذف المستخدم
    $(document).on('click', '.delete-user', function() {
        if (confirm('هل أنت متأكد من حذف هذا المستخدم؟')) {
            var userId = $(this).data('id');
            $.ajax({
                url: '/admin/users/' + userId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    $('#user-' + userId).remove();
                    showNotification('success', response.message);
                },
                error: function(xhr) {
                    showNotification('danger', 'حدث خطأ أثناء الحذف');
                }
            });
        }
    });

    // عرض الإشعار
    function showNotification(type, message) {
        $('#notification')
            .removeClass('alert-success alert-danger')
            .addClass('alert-' + type)
            .text(message)
            .show()
            .delay(3000)
            .fadeOut();
    }
});
</script>
@endsection