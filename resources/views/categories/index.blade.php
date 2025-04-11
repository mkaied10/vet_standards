@extends('layouts.app')

@section('title', 'الأقسام الرئيسية')

@section('content')
<div class="hero">
    <h1>الأقسام الرئيسية</h1>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>اسم القسم</th>
                <th>الأقسام الفرعية</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td><a href="{{ route('subcategories.index', $category) }}" class="btn btn-primary btn-sm"><i class="fas fa-folder-open"></i> عرض الأقسام الفرعية</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection