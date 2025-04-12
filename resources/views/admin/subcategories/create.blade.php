@extends('layouts.app')
@section('title', 'إضافة قسم فرعي')
@section('content')
<div class="hero">
    <h1>إضافة قسم فرعي</h1>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="card mt-4">
    <div class="card-body">
        <form id="create-subcategory-form" method="POST">
            @csrf
            <div class="form-group">
                <label>الاسم</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>القسم الرئيسي</label>
                <select name="category_id" class="form-control" required>
                    @if($categories->isNotEmpty())
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @else
                        <option value="" disabled selected>لا توجد أقسام رئيسية</option>
                    @endif
                </select>
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
    $('#create-subcategory-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.subcategories.store') }}',
            type: 'POST',
            data: $(this).serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                showNotification('success', response.message);
                $('#create-subcategory-form')[0].reset();
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