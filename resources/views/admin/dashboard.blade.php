@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-decoration-underline fs-4 my-4">Welcome to the dashboard</h2>

    <div id="dashboard" class="row justify-content-center">
        <div class="col">
            @include('partials.dashboard-card.messages')
            @include('partials.dashboard-card.analytics')
            @include('partials.dashboard-card.contability')
            @include('partials.dashboard-card.views')
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
