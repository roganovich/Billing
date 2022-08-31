@extends('layouts.app')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('wikipages.index') }}

        <h1 class="mt-2">{{ config('app.name', 'Laravel') }} {{ ($parent) ? $parent->title : '' }}</h1>

        <div class="row mt-2 justify-content-left">
            @foreach ($items as $item)
                <div class="card col-md-12 col-lg-12 p-2 mb-2">
                    <img src="{{ $item->pageThumb }}" class="card-img-top" title="{{ $item->title }}" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h3 class="card-title"><a href="{{ route('wikipages.show', ['id' => $item->id]) }}"
                           class="">{{ $item->title }}</a>
                        </h3>
                        <p class="card-text">{!! $item->description !!}</p>
                        <div class=" position-absolute bottom-0 start-0 m-2">
                            {{ $item->created_at->format('d.m.Y') }}
                        </div>
                        <a href="{{ route('wikipages.show', ['id' => $item->id]) }}"
                           class="btn btn-primary position-absolute bottom-0 end-0 m-2">{{ __('default.follow') }}</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-2">
            {{ $items->links('pagination')}}
        </div>
    </div>
@endsection
