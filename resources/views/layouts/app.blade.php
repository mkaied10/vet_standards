<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>المواصفات القياسية البيطرية | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('imgs/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="{{ route('home') }}">المواصفات البيطرية</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
                        الأقسام الرئيسية
                    </a>
                    <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @foreach(\App\Models\Category::with('subcategories')->get() as $category)
                        <div class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">{{ $category->name }}</a>
                            <div class="dropdown-menu">
                                @foreach($category->subcategories as $subcategory)
                                <a class="dropdown-item" href="{{ route('specifications.subcategory', $subcategory) }}">{{ $subcategory->name }}</a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('specifications.category', $category) }}">عرض الكل</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('specifications.index') }}">جميع المواصفات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">الأقسام</a>
                </li>
            </ul>
            <form class="form-inline search-form my-2 my-lg-0" action="{{ route('search') }}" method="GET">
                <input class="form-control mr-sm-2" type="search" name="query" placeholder="ابحث في المواصفات..." aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light ml-3"><i class="fas fa-tachometer-alt"></i> لوحة التحكم</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light ml-3"><i class="fas fa-users"></i> إدارة المستخدمين</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="d-inline ml-2">
                @csrf
                <button type="submit" class="btn btn-light"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</button>
            </form>
            @endauth
            
        </div>
    </nav>
    <div class="container my-4">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @yield('content')
    </div>
    <footer>
        <p>© 2025 المواصفات القياسية البيطرية - جميع الحقوق محفوظة</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>