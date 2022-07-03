@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@push('custom-styles')

    <style>


    </style>

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 home-block">
            <div class="card">
                <div class="card-header">{{ __('Customer Create') }}</div>

                <div class="card-body">

                    <form method="post" action="{{ url('/customer/store') }}" autocomplete="off"
                        enctype="multipart/form-data" id="customer_create_form">
                        @csrf
                        <div class="box">

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first_name">{{ __('First Name') }}</label>
                                        <input type="text" name="first_name" class="form-control form-control-alternative"
                                            id="input-first_name" 
                                            value="{{ old('first_name') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last_name">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" class="form-control form-control-alternative"
                                            id="input-last_name" 
                                            value="{{ old('last_name') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-contact_email">{{ __('Email') }}</label>
                                        <input type="text" name="contact_email" class="form-control form-control-alternative"
                                            id="input-contact_email" 
                                            value="{{ old('contact_email') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone_number">{{ __('Phone Number') }}</label>
                                        <input type="text" name="phone_number" class="form-control form-control-alternative"
                                            id="input-phone_number" 
                                            value="{{ old('phone_number') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-gender">{{ __('Gender') }}</label>
                                        <select class="form-control form-control-alternative"
                                        name="gender" id="select-gender">
                                        <option value="Unspecified">Unspecified</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                        <input type="text" name="address" class="form-control form-control-alternative"
                                            id="input-address" 
                                            value="{{ old('address') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-dob">{{ __('Date of Birth') }}</label>
                                        <input type="date" name="dob" class="form-control form-control-alternative"
                                            id="input-dob" 
                                            value="{{ old('dob') }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-is_active">{{ __('Active Status') }}</label>
                                        <select class="form-control form-control-alternative"
                                        name="is_active" id="select-is_active">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Save') }}</button>
                                </div>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.js"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

@endpush

@push('custom-scripts')

<script>

    $(document).on('submit','#customer_create_form',function(e) {

        e.preventDefault();

        var first_name = $('#input-first_name').val();
        var last_name = $('#input-last_name').val();
        var contact_email = $('#input-contact_email').val();
        var phone_number = $('#input-phone_number').val();
        var gender = $('#select-gender').val();
        var address = $('#input-address').val();
        var dob = $('#input-dob').val();
        var is_active = $('#select-is_active').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            
                url: 'http://127.0.0.1:8000/api/customer/store',
                type: 'post',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    contact_email: contact_email,
                    phone_number: phone_number,
                    gender: gender,
                    address: address,
                    dob: dob,
                    is_active: is_active,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            toast: true,
                            position: 'bottom-end',
                            icon: "warning",
                            title: 'Customer created!',
                            showConfirmButton: false,
                            timer: 3500
                        });

                        window.location = "http://127.0.0.1:8000/customer/list"

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

    {!! JsValidator::formRequest('App\Http\Requests\CustomerStoreRequest', '#customer_create_form') !!}
@endpush
