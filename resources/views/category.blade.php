@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>{{ $category->name }}</h1>
</div>
<div class="row">
    @foreach($subcategories as $subcategory)
    <div class="col-md-4 col-sm-6 mb-4">
        <a href="{{ route('subcategory.show', $subcategory) }}" class="text-decoration-none">
            <div class="card">
                @if($subcategory->image)
                <img src="{{ asset('storage/' . $subcategory->image) }}" class="card-img-top" alt="{{ $subcategory->name }}">
                @else
                <img src="https://source.unsplash.com/400x220/?{{ $subcategory->name }}" class="card-img-top" alt="{{ $subcategory->name }}">
                @endif
                <div class="card-body">
                    <h4 class="card-title">{{ $subcategory->name }}</h4>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection