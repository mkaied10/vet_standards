@extends('layouts.app')
@section('title', 'تعديل قسم رئيسي')
@section('content')
<div class="hero">
    <h1>تعديل قسم رئيسي</h1>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="card mt-4">
    <div class="card-body">
        @if($category)
            <form id="edit-category-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التعديلات</button>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                القسم الرئيسي غير موجود
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#edit-category-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.categories.update', $category->id ?? 0) }}',
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