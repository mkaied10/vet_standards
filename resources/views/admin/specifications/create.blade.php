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
                    @if($subcategories->isNotEmpty())
                        @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->category->name }} - {{ $subcategory->name }}</option>
                        @endforeach
                    @else
                        <option value="" disabled selected>لا توجد أقسام فرعية متاحة</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>المحتوى</label>
                <textarea name="content" id="content-editor" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>الملف (اختياري)</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> إضافة</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
$(document).ready(function() {
    // تسجيل تحميل jQuery
    console.log('jQuery version:', $.fn.jquery);

    // تحقق من تحميل CKEditor
    if (typeof CKEDITOR === 'undefined') {
        console.error('CKEditor failed to load. Check CDN or network connection.');
        alert('فشل تحميل محرر النصوص. تأكد من اتصالك بالإنترنت أو جرب لاحقاً.');
        return;
    }

    console.log('Initializing CKEditor...');

    // تهيئة CKEditor
    try {
        CKEDITOR.replace('content-editor', {
            language: 'ar',
            height: 400,
            filebrowserUploadUrl: '/admin/upload-image?_token={{ csrf_token() }}',
            filebrowserUploadMethod: 'form',
            toolbar: [
                { name: 'document', items: ['Source', '-', 'NewPage', 'Preview', 'Print'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
            ],
            contentsCss: ['https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap'],
            bodyClass: 'document-editor',
            format_tags: 'p;h1;h2;h3;pre',
            removePlugins: 'elementspath',
            extraPlugins: 'justify,font'
        });

        console.log('CKEditor initialized successfully');
    } catch (e) {
        console.error('Error initializing CKEditor:', e);
    }

    // معالجة إرسال الفورم
    $('#create-specification-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        try {
            formData.set('content', CKEDITOR.instances['content-editor'].getData());
        } catch (e) {
            console.error('Error getting CKEditor data:', e);
            showNotification('danger', 'خطأ في محرر النصوص. جرب مرة أخرى.');
            return;
        }
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
                CKEDITOR.instances['content-editor'].setData('');
            },
            error: function(xhr) {
                showNotification('danger', 'حدث خطأ أثناء الإضافة: ' + (xhr.responseJSON?.message || 'غير معروف'));
            }
        });
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