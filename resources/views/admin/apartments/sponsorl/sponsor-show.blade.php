@extends('layouts.admin')

@section('title', 'Sponsorizzazioni per {{ $apartment->name }}')

@section('content')
<div class="container">
    <h1>Sponsorships for{{ $apartment->name }}</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Sponsorship Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
                <th>Remaining Duration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
                <tr>
                    <td>{{ $promotion->title }}</td>
                    <td>{{ $promotion->pivot->start_date }}</td>
                    <td>{{ $promotion->pivot->end_date }}</td>
                    <td>{{ $promotion->duration }} hour</td>
                    <td>
                        <span id="timer-{{ $promotion->id }}"></span>
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
                                            timer = 0;
                                        }
                                    }, 1000);
                                }

                                var now = new Date().getTime();
                                var end = new Date('{{ \Carbon\Carbon::parse($promotion->pivot->end_date) }}').getTime();
                                var duration = Math.floor((end - now) / 1000);
                                var display = document.querySelector('#timer-{{ $promotion->id }}');
                                if (duration > 0) {
                                    startTimer(duration, display);
                                } else {
                                    display.textContent = '00:00:00';
                                }
                            });
                        </script>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection