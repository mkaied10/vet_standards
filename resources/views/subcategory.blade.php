@extends('layouts.app')

@section('content')
<div class="hero">
    <h1>{{ $subcategory->name }}</h1>
</div>
<div class="row">
    @foreach($specifications as $specification)
    <div class="col-md-4 col-sm-6 mb-4">
        <a href="{{ route('specification.show', $specification) }}" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $specification->title }}</h5>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection