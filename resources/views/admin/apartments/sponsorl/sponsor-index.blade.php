@extends('layouts.admin')

@section('title', 'Sponsorship for {{ $apartment->name }}')

@section('content')
<h4 class="text-dark ms-4 pt-4 pb-2   text-center ">Sponsored Apartment Details</h4>

<div class="cont-spons container p-5 my-3 border rounded-3 shadow-lg">
    <div class="row p-1">
        @if ($apartments->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                You have no sponsored apartments at the moment.
            </div>
        @else
            @foreach($apartments as $apartment)
                @foreach($apartment->promotions as $promotion)
                    <div class="col-lg-6 col-md-12">
                        <div id="tile" class="row py-3 px-1 promotion-card ">
                            <a href="{{ route('admin.apartments.show', $apartment) }}" class="d-flex text-decoration-none">
                                <div id="img-container" class="col-6 col-sm-4 col-lg-4 rounded-2">
                                    <img src="{{ asset('storage/' . $apartment->image_cover) }}" class="img-fluid">

                                </div>
                                <div class="col-6 col-sm-8 col-lg-8 text-center text-sm-start">
                                    <div class="row ">

                                        <div class="col-12">
                                            <div class="content pt-1 pb-2 promotion-details text-end fw-bold">
                                                <div class="fw-bold pt-1 pb-2 pb-sm-1 ">{{ $apartment->name }}</div>
                                                <div class="address d-none d-sm-block pb-sm-1  fw-light ">{{ $apartment->address }}
                                                </div>
                                                <p class=" fw-semibold fst-italic">{{ $promotion->title }}
                                                    <span>{{ intval($promotion->duration) }}h</span></p>
                                                <p class=" fw-light fst-italic">Expiration:
                                                    {{ \Carbon\Carbon::parse($promotion->pivot->end_date)->format('d/m/Y') }} </p>
                                                <span class="timer-box p-1 border-0"
                                                    id="timer-{{ $apartment->id }}-{{ $promotion->id }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            function startTimer(duration, display) {
                                var timer = duration, hours, minutes, seconds;
                                setInterval(function () {
                                    hours = parseInt(timer / 3600, 10);
                                    minutes = parseInt((timer % 3600) / 60, 10);
                                    seconds = parseInt(timer % 60, 10);

                                    hours = hours < 10 ? "0" + hours : hours;
                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;

                                    display.textContent = hours + ":" + minutes + ":" + seconds;

                                    if (--timer < 0) {
                                        clearInterval(interval); // Ferma l'intervallo una volta terminato il timer
                                    }
                                }, 1000);
                            }

                            var now = new Date().getTime();
                            var end = new Date('{{ \Carbon\Carbon::parse($promotion->pivot->end_date)->format('Y-m-d H:i:s') }}').getTime();
                            var duration = Math.floor((end - now) / 1000);
                            var display = document.querySelector('#timer-{{ $apartment->id }}-{{ $promotion->id }}');

                            if (duration > 0) {
                                startTimer(duration, display);
                            } else {
                                display.textContent = '00:00:00';
                            }
                        });

                    </script>
                @endforeach
            @endforeach
        @endif
    </div>
</div>
@endsection