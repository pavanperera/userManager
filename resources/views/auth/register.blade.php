@extends('layouts.app')

@section('content')

<img src="{{ url('images/system_images/background.png') }}"  class="back-img">

<div class="container">
    <div class="row main-login-block">
        <div class="col-lg-5 col-md-7 login-block">
            <div class="card">
                <div class="card-header">{{ __('Sign up') }}</div>

                <div class="card-body">
                    <form method="POST" action="" autocomplete="off" enctype="multipart/form-data"  id="register_form">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-7 offset-md-4">
                                <button type="submit" class="btn btn-primary" >
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')

<script>

        $(document).on('submit','#register_form',function(e) {

            e.preventDefault();

            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                
                    url: 'http://127.0.0.1:8000/api/register',
                    type: 'post',
                    data: {
                        name: name,
                        email: email,
                        password: password,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: "warning",
                                title: 'User Registered!',
                                showConfirmButton: false,
                                timer: 3500
                            });

                            window.location = "http://127.0.0.1:8000/dashboard"

                        } else{
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: "warning",
                                title: 'Unauthorised!',
                                showConfirmButton: false,
                                timer: 3500
                            });
                        }
                    },
                    error: function(response) {

                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'error',
                        title: "Something went wrong!",
                        showConfirmButton: false,
                        timer: 3500
                    });
                    //close alert
                    Swal.hideLoading();
                }
                });

        });

</script>
@endpush

