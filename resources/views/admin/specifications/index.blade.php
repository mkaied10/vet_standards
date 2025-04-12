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
<div class="card mb-3">
    <div class="card-body">
        <form id="filter-form">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>القسم الرئيسي</label>
                    <select name="category_id" class="form-control" id="category-filter">
                        <option value="">الكل</option>
                        @if($categories->isNotEmpty())
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>لا توجد أقسام رئيسية</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>القسم الفرعي</label>
                    <select name="subcategory_id" class="form-control" id="subcategory-filter">
                        <option value="">الكل</option>
                        @if($subcategories->isNotEmpty())
                            @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>لا توجد أقسام فرعية</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>العنوان</label>
                    <input type="text" name="title" class="form-control" id="title-filter">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">فلتر</button>
        </form>
    </div>
</div>
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
            @if($specifications->isNotEmpty())
                @foreach($specifications as $specification)
                <tr id="specification-{{ $specification->id }}">
                    <td>{{ $specification->title }}</td>
                    <td>{{ $specification->subcategory->category->name ?? 'غير متوفر' }}</td>
                    <td>{{ $specification->subcategory->name ?? 'غير متوفر' }}</td>
                    <td>{{ $specification->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.specifications.edit', $specification) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                        <button class="btn btn-danger btn-sm delete-specification" data-id="{{ $specification->id }}"><i class="fas fa-trash"></i> حذف</button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">لا توجد مواصفات متاحة</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // حذف المواصفة
    $(document).on('click', '.delete-specification', function() {
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

    // فلتر المواصفات
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.specifications.index') }}',
            type: 'GET',
            data: $(this).serialize(),
            success: function(response) {
                $('#specifications-table tbody').html($(response).find('#specifications-table tbody').html());
                showNotification('success', 'تم تحديث القائمة');
            },
            error: function(xhr) {
                showNotification('danger', 'حدث خطأ أثناء الفلترة');
            }
        });
    });

    // تحديث الأقسام الفرعية بناءً على القسم الرئيسي
    $('#category-filter').on('change', function() {
        var categoryId = $(this).val();
        $('#subcategory-filter option').each(function() {
            var subcategoryCategoryId = $(this).data('category');
            if (categoryId === '' || subcategoryCategoryId == categoryId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('#subcategory-filter').val('');
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