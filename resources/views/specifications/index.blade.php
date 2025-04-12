@extends('layouts.app')

@section('title', 'جميع المواصفات')

@section('content')
<div class="hero">
    <h1>جميع المواصفات</h1>
</div>
{{-- <div class="mb-3 text-left">
    <button class="btn btn-primary export-pdf" data-table="specifications-table"><i class="fas fa-file-pdf"></i> تصدير كـ PDF</button>
</div> --}}
<div class="table-responsive">
    <table class="table table-hover" id="specifications-table">
        <thead class="thead-dark">
            <tr>
                <th>العنوان</th>
                <th>القسم الرئيسي</th>
                <th>القسم الفرعي</th>
                <th>تاريخ الإضافة</th>
                <th>عرض</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specifications as $specification)
            <tr>
                <td>{{ $specification->title }}</td>
                <td>{{ $specification->subcategory->category->name }}</td>
                <td>{{ $specification->subcategory->name }}</td>
                <td>{{ $specification->created_at->format('Y-m-d') }}</td>
                <td><a href="{{ route('specification.show', $specification) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> عرض</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection