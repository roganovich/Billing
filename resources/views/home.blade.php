@extends('layouts.app')

@section('content')
    <div class="pricing-header mx-auto text-center">
        <img src="https://www.insuranceclaimprocessing.co.uk/blog/wp-content/uploads/2018/11/Role-of-medical-billing-in-the-healthcare-industry.jpg" class="img-fluid"/>
        <h1 class="display-4 fw-normal">{{ config('app.name', 'Laravel') }}</h1>
        <p class="fs-5 text-muted">Небольшая CRM для обслуживания счетов корпоративных клиентов.</p>
    </div>

    <div class="float-lg-start">
        <img src="{{ $item->pageThumb }}" class="card-img-top" title="{{ $item->title }}" alt="{{ $item->title }}">
    </div>
    <div>
        <h2 class="card-title">{{ $item->title }}</h2>
        <p class="card-text">{!! $item->description !!}</p>
        <div>
            {{ $item->created_at->format('d.m.Y') }}
        </div>
    </div>

@endsection
