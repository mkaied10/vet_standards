@extends('layouts.app')

@section('title', 'الأقسام الفرعية لـ ' . $category->name)

@section('content')
<div class="hero">
    <h1>الأقسام الفرعية لـ {{ $category->name }}</h1>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>اسم القسم الفرعي</th>
                <th>المواصفات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subcategories as $subcategory)
            <tr>
                <td>{{ $subcategory->name }}</td>
                <td><a href="{{ route('specifications.subcategory', $subcategory) }}" class="btn btn-primary btn-sm"><i class="fas fa-file-alt"></i> عرض المواصفات</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection