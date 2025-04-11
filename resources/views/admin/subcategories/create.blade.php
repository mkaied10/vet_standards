@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>إضافة قسم فرعي جديد</h1>
</div>
<div class="card mt-5">
    <div class="card-body">
        <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>القسم الرئيسي</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>الاسم</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
        </form>
    </div>
</div>
@endsection