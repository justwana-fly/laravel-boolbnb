@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="text-decoration-underline m-3">All services</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @include('partials.table-services', ['elements' => $services, 'elementName' => 'service'])
        {{$services->links('vendor.pagination.bootstrap-5')}} 
        
    </section>
@endsection