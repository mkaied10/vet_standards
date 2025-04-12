@extends('layouts.app')
@section('title', 'إدارة الأقسام الرئيسية')
@section('content')
<div class="hero">
    <h1>إدارة الأقسام الرئيسية</h1>
</div>
<div class="mb-3 text-left">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة قسم رئيسي</a>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="table-responsive">
    <table class="table table-hover" id="categories-table">
        <thead class="thead-dark">
            <tr>
                <th>الاسم</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @if($categories->isNotEmpty())
                @foreach($categories as $category)
                <tr id="category-{{ $category->id }}">
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                        <button class="btn btn-danger btn-sm delete-category" data-id="{{ $category->id }}"><i class="fas fa-trash"></i> حذف</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">لا توجد أقسام رئيسية متاحة</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // حذف القسم
    $(document).on('click', '.delete-category', function() {
        if (confirm('هل أنت متأكد من حذف هذا القسم الرئيسي؟')) {
            var categoryId = $(this).data('id');
            $.ajax({
                url: '/admin/categories/' + categoryId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    $('#category-' + categoryId).remove();
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