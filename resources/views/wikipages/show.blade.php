@extends('layouts.app')

@section('title', $item->title . ' | '. config('app.name', ''))
@section('meta_keywords', $item->title)
@section('meta_description', $item->preview)

@section('content')
    <div class="pricing-header mx-auto text-center">
        <img src="{{ $item->pageThumb }}"/>
        @if ($item->header)
            <h2 class="header">{{ $item->header }}</h2>
        @endif
        @if ($item->preview)
            <div class="preview">{!!  $item->preview !!}</div>
        @endif
    </div>
    <p class="card-text">{!! $item->description !!}</p>

@endsection
