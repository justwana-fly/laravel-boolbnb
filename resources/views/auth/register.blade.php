
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center form-login">
        <div class="col-md-8">
            <div id="ls-register-form" class="card">
                <div id="register-title" class="p-3 text-white fs-4 border-bottom">
                    {{ __('Register') }}
                </div>
                <div class="p-3">
                    <form id="register-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" required>
                                <label for="name"><span class="text-danger">*</span> required</label>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>
                            
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" required>
                                <label for="last_name"><span class="text-danger">*</span> required</label> 
                                {{-- add label --}}
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span class="text-danger">*</span> </label>

                            <div class="col-md-6">
                                <input type="text" id="email"class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                <label for="email"><span class="text-danger">*</span> required</label>
                                <span id="checkEmail" class="invalid-feedback"></span><br>
                                @error('email')
                                <span  class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} <span class="text-danger">*</span> </label>
                            
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password"><span class="text-danger">*</span> required</label>
                                
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="text-danger">*</span> </label>

                            <div class="col-md-6">
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm"><span class="text-danger">*</span> required</label>
                            </div>
                            <span id="errorPassword" class="invalid-feedback"></span><br>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn draw-border">
                                <i class="fs-3 fa-regular fa-id-card"></i> {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
    <style>
        .invalid-feedback {
            color: red;
            display: none;
        }
    </style>
    <script>
        function isValidEmail(email) {
    const emailRegex = /^(?!.*\.\.)(?!.*\.$)[\w.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9-]+(\.[A-Z|a-z]{2,})+$/;
    return emailRegex.test(email);
}

function getEmailErrorMessage(email) {
    if (email.includes('..')) {
        return 'The address cannot contain two consecutive dots (..).';
    }
    if (email.startsWith('.') || email.endsWith('.')) {
        return 'The local part of the email address cannot start or end with a dot.';
    }
    if (!/^[A-Za-z0-9.-]+$/.test(email.split('@')[0])) {
        return 'The local part of the email address contains invalid special characters.';
    }
    if (!email.includes('@')) {
        return 'The email address must contain an @.';
    }
    if (!/^[A-Za-z0-9.-]+$/.test(email.split('@')[1])) {
        return 'The domain part contains invalid special characters.';
    }
    if (!/\.[A-Z|a-z]{2,}$/.test(email.split('@')[1])) {
        return 'The domain must end with at least two letters.';
    }
    if (email.split('@').length > 2) {
        return 'The email address can contain only one @.';
    }
    if (email.split('@')[1].startsWith('.') || email.split('@')[1].endsWith('.')) {
        return 'The domain cannot start or end with a dot.';
    }
}
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('register-form');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password-confirm');
            const emailInput = document.getElementById('email');
            const checkEmail = document.getElementById('checkEmail');
            const passwordError = document.getElementById('errorPassword');

            form.addEventListener('submit', function(event) {
                let valid = true;

                // Reset messaggi di errore
                checkEmail.textContent = '';
                passwordError.textContent = '';

                // Validazione email
                const emailError = getEmailErrorMessage(emailInput.value);
                if (emailError) {
                    checkEmail.textContent = emailError;
                    checkEmail.style.display = 'block';
                    valid = false;
                } else {
                    checkEmail.style.display = 'none';
                }

                // Validazione password
                if (passwordInput.value !== confirmPasswordInput.value) {
                    passwordError.textContent = 'Le password non corrispondono';
                    passwordError.style.display = 'block';
                    valid = false;
                } else {
                    passwordError.style.display = 'none';
                }

                // Se una delle validazioni fallisce, impedisci l'invio del modulo
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection