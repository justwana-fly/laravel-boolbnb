@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="mb-4 m-3">Total apartments: {{ $totalApartments }}</h1>
        <a role="button" class="btn-2 strong draw-border-2 m-3" href="{{ route('admin.apartments.create') }}"><i class=" text-secondary fa-solid fa-plus"></i>  Add an Apartment</a> 
        <div class="container mt-5">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @include('partials.table-apartments', ['elements' => $apartments, 'elementName' => 'apartment'])
            {{$apartments->links('vendor.pagination.bootstrap-5')}}
        </div>
    </section>
@endsection 




