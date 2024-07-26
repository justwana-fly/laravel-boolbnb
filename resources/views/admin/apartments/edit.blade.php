@section('title', 'Edit Apartments {{ $apartment->name }}')
@extends('layouts.admin')

@section('content')
<section class="container py-5">
    <div  class="container rounded-2 container-table">
        <h1 class="fw-bolder">Edit apartment: {{ $apartment->title }}</h1>
        <h3>General informations</h3>
        <div id="ls-edit" class="">
            <form id="edit-apartment-form" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" 
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

            <div class="row">
                <div class="mb-3 col @error('name') @enderror">
                    <label for="name" class="form-label fs-5 fw-medium">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $apartment->name) }}"required maxlength="255"
                        minlength="3">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <h3 class="mt-4">Apartment areas</h3>
            <div class="mb-3 col @error('beds') @enderror">
                <label for="beds" class="form-label fs-5 fw-medium">Beds</label>
                <input
                    class="form-control @error('beds') is-invalid @enderror"
                    id="beds" name="beds"
                    value="{{ old('beds', $apartment->beds) }}" minlength="1" type="text" pattern="^\d+$" maxlength="255" minlength="1">
                @error('beds')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col @error('rooms') @enderror">
                <label for="rooms" class="form-label fs-5 fw-medium">Rooms</label>
                <input  class="form-control @error('rooms') is-invalid @enderror"
                    id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}"type="text" pattern="^\d+$" maxlength="255" minlength="1">
                @error('rooms')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col @error('bathrooms') @enderror">
                <label for="bathrooms" class="form-label fs-5 fw-medium">Bathrooms</label>
                <input  class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" name="bathrooms"
                placeholder="{{ old('bathrooms', $apartment->bathrooms) }}" type="text" pattern="^\d+$" maxlength="255" minlength="1">
                @error('bathrooms')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            </div>


            <div class="mb-3 col @error('square_meters') @enderror">
                <label for="square_meters" class="form-label fs-5 fw-medium">Square meters</label>
                <input type="text" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" name="square_meters"
                    placeholder="{{ old('square_meters', $apartment->square_meters) }}" pattern="^\d+$" maxlength="255" minlength="1">
                @error('square_meters')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        

            <h3 class="mt-4">Description</h3>
            <div class="mb-3 @error('description') @enderror">
                <label for="description" class="form-label fs-5 fw-medium">Write here</label>
                <textarea class="form-control w-100 @error('description') is-invalid @enderror" rows="6" id="description"
                    name="description"  >{{ old('description',  $apartment->description) }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            </div>
        </div>
        
            <h3 class="mt-4">Address and visibility</h3>
            <div class="address d-flex justify-content-center  flex-column">
                <div class="mb-3 @error('address') @enderror">
                    <div class="d-flex mt-3 align-content-start">
                        <div id="adreesResult" class=""></div>
                        <input class="form-control @error('address') is-invalid @enderror" type="text" id="address" name="address" value="{{ old('address', $apartment->address) }}" required maxlength="255" minlength="7">
                        <button id="edit-btn" class="btn-2 ms-3 draw-border-2 mt-3"><i class="fa-solid fs-4 fa-pencil"></i></button>
                    </div>
                    <div id="resultsContainer" class="results-container"></div>
                        @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check ">
                            <input class="form-check-input mt-2" type="checkbox" id="visibility" name="visibility" value="1" {{ $apartment->visibility ? 'checked' : '' }}>
                            <label class="form-check-label fs-5  fw-medium" for="visibility">
                                Make visible
                            </label>
                            <label for="fs-5">( this will allow your apartment to be visible in the research )</label>
                        </div>
                    </div> 
            </div>

            <h3 class=" mt-4">Apartment picture</h3>
            {{-- <div class="mb-3 @error('image_cover') @enderror d-flex gap-5 align-items-center">
                <div class="w-25">
                    @if ($movie->image_cover && strpos($movie->image_cover, 'http') !== false)
                        <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                            src="{{ $movie->image_cover }}" alt="preview">
                    @elseif ($movie->image_cover)
                        <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                            src="{{ asset('storage/' . $movie->image_cover) }}" alt="preview">
                    @else
                        <img id="uploadPreview" class="w-100 uploadPreview" width="100" src="/images/placeholder.png"
                            alt="preview">
                    @endif
                </div>
                <div class="w-75">
                    <label for="image" class="form-label text-white">Image</label>
                    <input type="file" accept="image/*" class="form-control upload_image" name="image_cover"
                        value="{{ old('image_cover', $apartment->image_cover) }}">
                    @error('image_cover')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}


            <div class="mb-3 d-flex justify-content-between @error('image_cover') @enderror gap-5 img_edit">
                <div class="w-50">
                    <div class="w-75  text-center">
                        @if ($apartment->image_cover && strpos($apartment->image_cover, 'http') !== false)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ $apartment->image_cover }}" alt="preview">
                        @elseif ($apartment->image_cover)
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100"
                                src="{{ asset('storage/' . $apartment->image_cover) }}" alt="preview">
                        @else
                            <img id="uploadPreview" class="w-100 uploadPreview" width="100" src="/images/placeholder.png"
                                alt="preview">
                        @endif
                    </div>
                
                    <div class="w-75 mb-3">
                        <label for="image" class="form-label text-white">Image </label>
                        <input type="file" accept="image/*" class="form-control upload_image" id="uploadImage" name="image_cover"
                            value="{{ old('image_cover', $apartment->image_cover) }}">
                        @error('image_cover')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 w-75">
                    <h5 class="mt-3 text-start">Select service:</h5>
                    @foreach ($services as $service)
                    <div>
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                        {{ $apartment->services->contains($service->id) ? 'checked' : ''}}>
                        <label for="" class="form-check-label">{{ $service->name }}</label>
                    </div>
                    @endforeach
                    @error('services')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="alert alert-danger" id="service-error" style="display: none;">Please select at least one service.</div>
                </div>
            </div>
            <br>
            <div class="text-center">
                <button type="submit" class="draw-border-2 p-2 px-3 btn-2 mt-3 mx-3"><i class="fa-solid fa-floppy-disk"></i> Salva</button>
            </div>
            <a href="{{ route('admin.apartments.index') }}" class="btn draw-border">
                <i class="fa-solid fa-chevron-left"></i> Go back
            </a>
        </form>
</section>

    <script>
        //funzione per i service
        const addressInput = document.getElementById('address');
        const addressdiv = document.getElementById('adreesResult');
        addressInput.style.display = 'none';
        addressdiv.style.display = 'block';
        addressdiv.innerHTML= "{{ old('address', $apartment->address) }}";
        document.getElementById('edit-apartment-form').addEventListener('submit', function(event) {
            const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
            const serviceError = document.getElementById('service-error');
            let isServiceSelected = false;
            const addressInput = document.getElementById('address');
            serviceCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isServiceSelected = true;
                }
            });

            if (!isServiceSelected) {
                serviceError.style.display = 'block';
                event.preventDefault();
            } else {
                serviceError.style.display = 'none';
            }
            if(  !(addressInput.style.display == 'none')){
                event.preventDefault();
            }
       
        });
        document.getElementById('edit-btn').addEventListener('click', (event) => {
            event.preventDefault();
            addressdiv.style.display = 'none';
            addressInput.style.display = 'block';

    });

        //lettura chiave api per la ricerca non tocca 
        window.apiKey = "{{ env('TOMTOM_API_KEY') }}";
    </script>
@endsection
