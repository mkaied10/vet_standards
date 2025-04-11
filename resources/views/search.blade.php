@extends('layouts.app')

@section('title', 'نتائج البحث')

@section('content')
<div class="hero">
    <h1>نتائج البحث عن: {{ $query }}</h1>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>العنوان</th>
                <th>القسم الفرعي</th>
                <th>عرض</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $specification)
            <tr>
                <td>{{ $specification->title }}</td>
                <td>{{ $specification->subcategory->name }}</td>
                <td><a href="{{ route('specification.show', $specification) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> عرض</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">لم يتم العثور على نتائج</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection