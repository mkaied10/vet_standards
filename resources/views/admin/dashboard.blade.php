@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>لوحة تحكم الأدمن</h1>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 mb-4">
        <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-folder fa-3x mb-3" style="color: var(--primary);"></i>
                    <h3 class="card-title">إدارة الأقسام</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-4">
        <a href="{{ route('admin.subcategories.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-folder-open fa-3x mb-3" style="color: var(--secondary);"></i>
                    <h3 class="card-title">إدارة الأقسام الفرعية</h3>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-4">
        <a href="{{ route('admin.specifications.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-3x mb-3" style="color: var(--primary);"></i>
                    <h3 class="card-title">إدارة المواصفات</h3>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection