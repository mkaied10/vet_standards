@extends('layouts.app')
@section('title', 'تعديل مستخدم')
@section('content')
<div class="hero">
    <h1>تعديل مستخدم</h1>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="card mt-4">
    <div class="card-body">
        @if($user)
            <form id="edit-user-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور (اتركه فارغًا لعدم التغيير)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التعديلات</button>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                المستخدم غير موجود
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#edit-user-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.users.update', $user->id ?? 0) }}',
            type: 'PUT',
            data: $(this).serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                showNotification('success', response.message);
            },
            error: function(xhr) {
                showNotification('danger', 'حدث خطأ أثناء التعديل');
            }
        });
    });

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