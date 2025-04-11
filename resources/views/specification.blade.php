@extends('layouts.app')

@section('title', $specification->title)

@section('content')
<div class="hero">
    <h1>{{ $specification->title }}</h1>
</div>
<div class="card mt-4">
    <div class="card-body specification-content">
        {!! $specification->content !!}
    </div>
    @if($specification->file_path)
    <div class="card-footer text-center">
        <a href="{{ asset('storage/' . $specification->file_path) }}" class="btn btn-primary" target="_blank">
            <i class="fas fa-download"></i> تحميل الملف
        </a>
    </div>
    @endif
</div>
@endsection