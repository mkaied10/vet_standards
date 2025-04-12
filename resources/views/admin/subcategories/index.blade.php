@extends('layouts.app')
@section('title', 'إدارة الأقسام الفرعية')
@section('content')
<div class="hero">
    <h1>إدارة الأقسام الفرعية</h1>
</div>
<div class="mb-3 text-left">
    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة قسم فرعي</a>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="table-responsive">
    <table class="table table-hover" id="subcategories-table">
        <thead class="thead-dark">
            <tr>
                <th>الاسم</th>
                <th>القسم الرئيسي</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @if($subcategories->isNotEmpty())
                @foreach($subcategories as $subcategory)
                <tr id="subcategory-{{ $subcategory->id }}">
                    <td>{{ $subcategory->name }}</td>
                    <td>{{ $subcategory->category->name ?? 'غير متوفر' }}</td>
                    <td>{{ $subcategory->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                        <button class="btn btn-danger btn-sm delete-subcategory" data-id="{{ $subcategory->id }}"><i class="fas fa-trash"></i> حذف</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">لا توجد أقسام فرعية متاحة</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // حذف القسم الفرعي
    $(document).on('click', '.delete-subcategory', function() {
        if (confirm('هل أنت متأكد من حذف هذا القسم الفرعي؟')) {
            var subcategoryId = $(this).data('id');
            $.ajax({
                url: '/admin/subcategories/' + subcategoryId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    $('#subcategory-' + subcategoryId).remove();
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