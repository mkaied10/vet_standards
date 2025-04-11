@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')
<div class="hero">
    <h1>المواصفات القياسية البيطرية في مصر</h1>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 mb-4">
        <a href="{{ route('specifications.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">جميع المواصفات</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-4">
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">الأقسام الرئيسية</h3>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection