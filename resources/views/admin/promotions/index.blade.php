@section('title', 'Admin Dashboard / Apartments')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="text-decoration-underline m-3">Your promotions</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @include('partials.table-promotions', ['elements' => $promotions, 'elementName' => 'promotion']) 
        {{-- {{$apartments->links('vendor.pagination.bootstrap-5')}}  --}}
    </section>
@endsection
