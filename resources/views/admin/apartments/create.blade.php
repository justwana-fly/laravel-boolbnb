@section('title', 'Admin Dashboard / Apartments')
@extends('layouts.admin')


@section('content')
<section class="container py-5">
    <div class="container rounded-2 container-table">
        <h1 class=" fw-bolder">Add a new Apartment:</h1>
        <h3>General informations</h3>
        <div id="ls-edit" class="">
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" id="create-apartment-form" >

                @csrf
                
                
                <div class="mb-3 @error('name') is-invalid @enderror">
                        <label for="name" class="form-label fs-5 fw-medium">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}"  maxlength="255" minlength="3">
                            <label for="name">*required</label>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <h3 class="mt-4">Apartment areas</h3>
                    <div class="row">
                        <div class="mb-3 col @error('rooms') @enderror">
                            <label for="rooms" class="form-label fs-5 fw-medium">Rooms</label>
                            <input class="form-control @error('rooms') is-invalid @enderror"
                                id="rooms" name="rooms" value="{{ old('rooms') }}" type="text" pattern="^\d+$" required maxlength="255" minlength="1">
                                <label for="rooms">*required</label>
                            @error('rooms')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        
                            <div class="mb-3 col @error('beds') @enderror">
                                <label for="beds" class="form-label fs-5 fw-medium">Beds</label>
                                <input class="form-control @error('beds') is-invalid @enderror"
                                    id="beds" name="beds" value="{{ old('beds') }}" type="text" pattern="^\d+$" required maxlength="255" minlength="1">
                                    <label for="beds">*required</label>
                                @error('beds')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    
    
                        <div class="mb-3 col @error('square_meters') @enderror">
                            <label for="bathrooms"  class="form-label fs-5 fw-medium">Bathrooms</label>
                            <input class="form-control @error('beds') is-invalid @enderror" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" type="text" pattern="^\d+$" required maxlength="255" minlength="1">
                            <label for="bathrooms">*required</label>
                            @error('bathrooms')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="mb-3 @error('square_meters') @enderror">
                            <label for="square_meters" class="form-label fs-5 fw-medium">Square meters</label>
                            <input  class="form-control @error('square_meters') is-invalid @enderror"
                                id="square_meters" name="square_meters" value="{{ old('square_meters') }}" type="text" pattern="^\d+$" required maxlength="255" minlength="1">
                                <label for="square_meters">*required</label>
                            @error('square_meters')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="mb-3 @error('description') @enderror">
                        <h3>Description</h3>
                        <label for="description" class="form-label fs-5 fw-medium">Write here</label>
                        <textarea rows="6" class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                    </div>  
                        
                    
                    <h3 class="mt-4">Address and visibility</h3>
                    <div class="address d-flex justify-content-center flex-column">
                            <div class="mb-3 @error('address') @enderror">
                                <div class="d-flex mt-3 align-content-center">
                                    <div id="adreesResult" class=""></div>
                                    <input class="form-control @error ('address') is-invalid @enderror" type="text" id="address" name="address" value="{{ old('address') }}" required maxlength="255" minlength="7">
                                    <button id="edit-btn" class="btn-2 ms-3 draw-border-2 mt-3"><i class="fa-solid fs-4 fa-pencil"></i></button>
                                </div>
                                
                                <label for="address">*required</label>

                                <div id="resultsContainer" class="results-container"></div>
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input mt-2"  type="checkbox" id="visibility" name="visibility" value="1" {{ old('visibility') ? 'checked' : ''}}>
                                    <label class="form-check-label fs-5  fw-medium" for="visibility">
                                        Make visible
                                    </label>
                                    <label for="fs-5">( this will allow your apartment to be visible in the research )</label>
                                </div>
                            </div>  
                    </div>

                    <h3 class="mt-4">Apartment picture</h3>
                    <div class="mb-3 d-flex justify-content-between @error('image_cover') @enderror gap-5 img_edit">
                        <div class="w-50">
                            <div class="w-75  text-center">
                                    <img id="uploadPreview" class="w-100 uploadPreview" width="100"src="{{ asset('image/placeholder.png') }}" alt="preview">
                            </div>
        
                            <div class="w-75 mb-3">
                                <label for="image" class="form-label text-white">Image </label>
                                <input type="file" accept="image/*" class="form-control upload_image" id="uploadImage" name="image_cover"
                                    value="{{ old('image_cover') }}">
                                @error('image_cover')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 w-75 @error('services') is-invalid @enderror">
                            <h5 class="mt-3 text-start">Select service:</h5>
                            @foreach ($services as $service)
                            <div>
                                <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input @error('services') is-invalid @enderror"
                                    {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                <label for="" class="form-check-label">{{ $service->name }}</label>
                            </div>
                            @endforeach
                            @error('services')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="alert alert-danger" id="service-error" style="display: none;">Please select at least one service.</div>
                        </div>
                    </div>

                <div class="text-center mx-auto justify-content-center d-flex gap-2">
                    <button type="submit" class="btn-2 draw-border-2 p-2 px-3 mt-3 mx-3"><i class="fa-solid fa-plus"></i> Add the Apartment</button>
                </div> 
        </form>
</section>    <script>
    //funzione per i service
    const addressInput = document.getElementById('address');
    const addressdiv = document.getElementById('adreesResult');
    document.getElementById('create-apartment-form').addEventListener('submit', function(event) {
        const serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
        const serviceError = document.getElementById('service-error');
        let isServiceSelected = false;
        
            serviceCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    isServiceSelected = true;
                }
            });
    
            if (!isServiceSelected) {
                event.preventDefault();
                serviceError.style.display = 'block';
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






