@extends('layouts.app')
@section('title', 'إضافة مواصفة جديدة')
@section('content')
<div class="hero">
    <h1>إضافة مواصفة جديدة</h1>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="card mt-4">
    <div class="card-body">
        <form id="create-specification-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>العنوان</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>القسم الفرعي</label>
                <select name="subcategory_id" class="form-control" required>
                    @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->category->name }} - {{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>المحتوى</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>الملف (اختياري)</label>
                <input type="file" name="file" class="form-control">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#create-specification-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '{{ route('admin.specifications.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                showNotification('success', response.message);
                $('#create-specification-form')[0].reset();
            },
            error: function(xhr) {
                showNotification('danger', 'حدث خطأ أثناء الإضافة');
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