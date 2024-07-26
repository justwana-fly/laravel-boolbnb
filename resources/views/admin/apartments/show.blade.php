@section('title', "Admin Dashboard / Apartments")
@extends('layouts.admin')

@section('content')

    <title>Apartment Details</title>
    <script src="https://js.braintreegateway.com/web/dropin/1.30.1/js/dropin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://js.braintreegateway.com/web/3.89.1/js/client.min.js"></script>


<div class="container my-1 ls-glass ls-border p-4">
    <div class="text-center img-show">
        <img src="{{ asset('storage/' . $apartment->image_cover) }}" alt="{{ $apartment->name }}">
    </div>

    <div class="d-flex p-4 mt-5 justify-content-between">
        <div id="info-left" class="ls-glass ls-border p-3">
            <h4 class="text-center text-uppercase mb-4">Information</h4>
            <h3 class="fw-bold">{{ $apartment->name }}</h3>

            <ul class="p-2">
                <li><i class="fa-solid fa-home"></i> Rooms: {{ $apartment->rooms }}</li>
                <li><i class="fa-solid fa-bath"></i> Bathrooms: {{ $apartment->bathrooms }}</li>
                <li><i class="fa-solid fa-bed"></i> Beds: {{ $apartment->beds }}</li>
                <li><i class="fa-solid fa-ruler"></i> Square Meters: {{ $apartment->square_meters }}</li>
            </ul>

            <h6 class="fw-bold">Address:</h6>
            <p>{{ $apartment->address }}</p>
            <br>
            <h6 class="fw-bold">Latitude:</h6>
            <p>{{ $apartment->latitude }}</p>
            <br>
            <h6 class="fw-bold">Longitude:</h6>
            <p>{{ $apartment->longitude }}</p>

            <div class="d-flex p-3 justify-content-between mt-3">
                <div id="ls-badges-container">
                    @if($apartment->services)
                        @foreach ($apartment->services as $service)
                            <div id="ls-badge" class="badge">{{ $service->name }}
                                <img id="ls-icons" src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div id="info-right" class="ls-border ls-glass p-3">
            <h4 class="text-center text-uppercase mb-4">Sponsorships</h4>
            @if($apartment->promotions->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    This apartment has no active promotions.
                </div>
            @else
                @foreach($apartment->promotions as $promotion)
                    <div class="promotion-details mb-3">
                        <h5 class="fw-bold">Types of Promotion: {{ $promotion->title }}</h5>
                        <p>{{ $promotion->description }}</p>
                        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($promotion->pivot->start_date)->format('d/m/Y H:i:s') }}</p>
                        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($promotion->pivot->end_date)->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Remaining Time:</strong> <span id="timer-{{ $apartment->id }}-{{ $promotion->id }}"></span></p>
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
            @endif

            <h4 class="text-center text-uppercase mt-4 mb-4">Description</h4>
            <p>{{ $apartment->description }}</p>
        </div>

    </div>
    <div>
        <label class="fs-4 ms-2">Actions</label>
        <div class="link d-flex align-items-center justify-content-start p-3">
            <a class="btn fs-5 draw-border p-2" href="{{ route('admin.apartments.edit', $apartment->slug) }}" class="update-link p-4">
                <i class="fa-solid fa-gear"></i>
            </a>
            <button type="button" class="btn fs-4 text-danger draw-border p-2 mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $apartment->id }}">
                <i class="fa-solid fa-trash"></i>
            </button>
            <a href="{{ route('admin.apartments.index') }}" class="btn draw-border">
                <i class="fa-solid fa-chevron-left"></i> Go back
            </a>
        </div>
        <div class="container w-25">
            <button id="cta-sponsor" class="btn-2 draw-border-2 mb-4 w-100" data-bs-toggle="modal" data-bs-target="#showPayment">   
                <strong><i class="fa-solid fa-crown fs-3 text-white me-3 "></i>Sponsor your apartment</strong>
            </button>
        </div>
    </div>
</div>  






<!-- MODALE DI PAGAMENTO -->

<div id="box-payment" class="d-none">

    {{-- <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal"
    data-bs-target="#showPayment">
        Activate
    </button> --}}

    <div class="modal fade" id="showPayment" tabindex="-1" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header " style="background-color: #0067697b; color:#4f4f4f">
                    <h1 class="modal-title fs-5">Activate your sponsorship</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #00676939;">
                    <form id="payment-form" action="{{ route('admin.payment.process') }}"  method="POST">
                        @csrf
                        <input type="hidden"  name="apartment_id" value="{{ $apartment->id }}">
                        <select id="promotion_id" class="form-select mb-3"  name="promotion_id" onclick="change(value)">
                        <option value="" disabled selected>select your sponsorship</option>
                            
                            @foreach ($promotions as $promotion)
                            
                            <option  class="option" value="{{$promotion->id}}">{{$promotion->title}}</option>
            
                            @endforeach
    
                        </select>
                        <div id="error-message" class="text-danger d-none">Please, select a sponsorship.</div>
    
                        <div id="box-description" class="box-description" >
    
                            <div id="text-description-1" class="text-hide d-none ">
                                <strong>Costo</strong>: {{$promotions[0]->price}}€ <br>
                                <strong>Durata</strong>: 24 h <br>
                                {{$promotions[0]->description}}
                            </div>
                            <div id="text-description-2" class="text-hide d-none">
                                <strong>Costo</strong>: {{$promotions[1]->price}}€ <br>
                                <strong>Durata</strong>: 48 h <br>
                                {{$promotions[1]->description}}
                            </div>
                            <div id="text-description-3" class="text-hide d-none">
                                <strong>Costo</strong>: {{$promotions[2]->price}}€ <br>
                                <strong>Durata</strong>: 144 h <br>
                                {{$promotions[2]->description}}
                            </div>
                        </div>
                        <div id="dropin-container"></div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-payment fw-bold my-2">Buy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- FINE MODALE DI PAGAMENTO -->
</div>




<script>
  document.addEventListener('DOMContentLoaded', function () {
    let form = document.getElementById('payment-form');
    let client_token = "{{ $clientToken }}"; // Token per Braintree    

    // Seleziona la prima opzione come predefinita e mostra la descrizione
    document.getElementById('promotion_id').selectedIndex = 1; // Seleziona la prima sponsorizzazione valida
    change(document.getElementById('promotion_id').value);

    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container'
    }, function (createErr, instance) {
        if (createErr) {
            console.error(createErr);
            return;
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Validazione: assicurarsi che una sponsorizzazione sia selezionata
            const promotionSelect = document.getElementById('promotion_id');
            const errorMessage = document.getElementById('error-message');

            if (promotionSelect.value === "") {
                errorMessage.classList.remove('d-none');
                return;
            } else {
                errorMessage.classList.add('d-none');
            }

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.error(err);
                    return;
                }

                let nonceInput = document.createElement('input');
                nonceInput.name = 'payment_method_nonce';
                nonceInput.type = 'hidden';
                nonceInput.value = payload.nonce; // Aggiunge il nonce al form
                form.appendChild(nonceInput);

                form.submit(); // Invia il form
            });
        });
    });

    // Gestisce il clic sul pulsante per mostrare/nascondere il box dei pagamenti
    let btn_sponsor = document.getElementById('cta-sponsor');
    btn_sponsor.addEventListener('click', function() {
        document.getElementById('box-payment').classList.toggle('d-none'); // Mostra/nasconde il box
    });
  });

  function change(value){
    console.log(value);

    const divs = document.querySelectorAll('.text-hide');
    divs.forEach(div => {
        div.classList.add('d-none');
    });

    document.querySelector('#box-description #text-description-' + value).classList.remove('d-none');
  }
</script>


@endsection

@include('partials.modal-delete', ['element' => $apartment, 'elementName' => 'apartment'])