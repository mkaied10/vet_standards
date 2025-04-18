@extends('layouts.app')
@section('title', 'تعديل قسم فرعي')
@section('content')
<div class="hero">
    <h1>تعديل قسم فرعي</h1>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="card mt-4">
    <div class="card-body">
        @if($subcategory)
            <form id="edit-subcategory-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}" required>
                </div>
                <div class="form-group">
                    <label>القسم الرئيسي</label>
                    <select name="category_id" class="form-control" required>
                        @if($categories->isNotEmpty())
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        @else
                            <option value="" disabled>لا توجد أقسام رئيسية</option>
                        @endif
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التعديلات</button>
                </div>
            </form>
        @else
            <div class="alert alert-danger">
                القسم الفرعي غير موجود
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#edit-subcategory-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.subcategories.update', $subcategory->id ?? 0) }}',
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