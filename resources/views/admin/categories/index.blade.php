@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>إدارة الأقسام</h1>
</div>
<div class="mt-5">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus"></i> إضافة قسم</a>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>الاسم</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>@if($category->image)<img src="{{ asset('storage/' . $category->image) }}" width="50" class="rounded">@endif</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash"></i> حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection