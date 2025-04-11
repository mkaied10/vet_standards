@extends('layouts.app')
@section('title', 'إدارة المواصفات')
@section('content')
<div class="hero">
    <h1>إدارة المواصفات</h1>
</div>
<div class="mb-3 text-left">
    <a href="{{ route('admin.specifications.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة مواصفة جديدة</a>
</div>
<div id="notification" class="alert" style="display: none;"></div>
<div class="table-responsive">
    <table class="table table-hover" id="specifications-table">
        <thead class="thead-dark">
            <tr>
                <th>العنوان</th>
                <th>القسم الرئيسي</th>
                <th>القسم الفرعي</th>
                <th>تاريخ الإضافة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specifications as $specification)
            <tr id="specification-{{ $specification->id }}">
                <td>{{ $specification->title }}</td>
                <td>{{ $specification->subcategory->category->name }}</td>
                <td>{{ $specification->subcategory->name }}</td>
                <td>{{ $specification->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.specifications.edit', $specification) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                    <button class="btn btn-danger btn-sm delete-specification" data-id="{{ $specification->id }}"><i class="fas fa-trash"></i> حذف</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // حذف المواصفة
    $('.delete-specification').on('click', function() {
        if (confirm('هل أنت متأكد من حذف هذه المواصفة؟')) {
            var specId = $(this).data('id');
            $.ajax({
                url: '/admin/specifications/' + specId,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    $('#specification-' + specId).remove();
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