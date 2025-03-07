
@extends('layouts.main')

@section('container')
  <h1 class="mb-5">Post Categories</h1>

  <div class="container">
    <div class="row">
      @foreach ($categories as $category)
      <div class="col-md-4 mb-4">
        <a style="text-decoration: none" href="/posts?category={{ $category->slug }}">
          <div class="card bg-dark text-white">
            <img class="card-img" src="https://picsum.photos/600/400?{{ $category->name }}" alt="{{ $category->name }}">
            <div class="card-img-overlay d-flex align-items-center p-0">
              <h5 class="card-title text-center flex-fill p-4 fs-3" style="background-color: rgba(0, 0, 0, 0.6)">{{ $category->name }}</h5>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>

    

@endsection