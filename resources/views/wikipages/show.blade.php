@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('wikipages.show', $item) }}

        <div class="row mt-2 justify-content-center">
            <div class="card col-md-12 col-lg-12 p-2 mb-2">
                <img src="{{ $item->pageThumb }}" class="card-img-top" title="{{ $item->title }}" alt="{{ $item->title }}">
                <div class="card-body">
                    <h1 class="card-title">{{ $item->title }}
                    </h1>
                    <p class="card-text">{!! $item->description !!}</p>
                    <div class=" position-absolute bottom-0 start-0 m-2">
                        {{ $item->created_at->format('d.m.Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
