@extends('layouts.app')

@section('content')
<img src="{{ url('images/system_images/background.png') }}"  class="back-img">

<div class="container">

    <div class="row main-login-block">
        <div class="col-lg-5 col-md-7 login-block">
            <div class="card">
                <div class="card-header">{{ __('Sign in') }}</div>

                <div class="card-body">
                    <form method="POST" action="" autocomplete="off" enctype="multipart/form-data"  id="login_form">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
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

        $(document).on('submit','#login_form',function(e) {

            e.preventDefault();

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            jQuery.ajax({
                
                    url: 'http://127.0.0.1:8000/api/login',
                    type: 'post',
                    data: {
                        email: email,
                        password: password,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: "success",
                                title: 'Login Success!',
                                showConfirmButton: false,
                                timer: 3500
                            });

                            localStorage.setItem("token", response.auth_data.access_token);
                            window.location = "http://127.0.0.1:8000/dashboard";

                        }else{
                            Swal.fire({
                                toast: true,
                                position: 'bottom-end',
                                icon: "warning",
                                title: response.message,
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

                console.log(localStorage.getItem("token"));

                let token = localStorage.getItem("token");


            function LoginCall(token){

                jQuery.ajax({
                
                    url: 'http://127.0.0.1:8000/dashboard',
                    headers: {
                    Authorization: "Bearer " + token,
                    Accept: "application/json"
                    },
                    type: 'get',
                    data: {
                        token: token,
                    },
                    success: function(response) {

                        console.log(response);

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

            }    

        });

</script>
@endpush

