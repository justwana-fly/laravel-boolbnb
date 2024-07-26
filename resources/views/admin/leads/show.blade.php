@section('title', 'Admin Dashboard / Messages')
@extends('layouts.admin')

@section('content')
    <section class="my-5">
        <h1 class=" m-3"><strong>{{ $lead->name }}</strong> has sent you a message</h1>
        <div><strong>Date:</strong>{{ $lead->created_at }}</div>
        
        <div class="my-3 py-2"> 
            <strong>Message content:</strong>  {{ $lead->message }}
        </div>

        <div>You may contact {{ $lead->name }} through the following email: <strong>{{ $lead->email }}</strong></div>

    </section>
@endsection
