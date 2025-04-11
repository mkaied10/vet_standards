@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>تعديل القسم الفرعي</h1>
</div>
<div class="card mt-5">
    <div class="card-body">
        <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>القسم الرئيسي</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>الاسم</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $subcategory->name }}">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>الصورة</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @if($subcategory->image) <img src="{{ asset('storage/' . $subcategory->image) }}" width="50" class="mt-2 rounded"> @endif
                @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> تحديث</button>
        </form>
    </div>
</div>
@endsection