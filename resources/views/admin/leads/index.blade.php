@section('title', 'Admin Dashboard / Messages')
@extends ('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class="text-decoration-underline m-3">You have {{ $totalMessage }} messages</h1>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        @include('partials.table-messages', ['elements' => $messages, 'elementName' => 'messages']) 
        {{$messages->links('vendor.pagination.bootstrap-5')}}  

    </section>
@endsection
