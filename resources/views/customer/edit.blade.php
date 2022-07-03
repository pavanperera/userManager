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
                <div class="card-header">{{ __('Customer Edit') }}</div>

                <div class="card-body">

                    <form action="{{url('/customer/update',[$customerData->id])}}" method="post" autocomplete="off" enctype="multipart/form-data" id="customer_update_form">
                        @method('PUT')
                        @csrf
                        <div class="box">

                            <input type="hidden" name="id" id="customer_id" value="{{ old('id', $customerData->id) }}">

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first_name">{{ __('First Name') }}</label>
                                        <input type="text" name="first_name" class="form-control form-control-alternative"
                                            id="input-first_name" 
                                            value="{{ old('first_name', $customerData->first_name) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last_name">{{ __('Last Name') }}</label>
                                        <input type="text" name="last_name" class="form-control form-control-alternative"
                                            id="input-last_name" 
                                            value="{{ old('last_name' , $customerData->last_name) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-contact_email">{{ __('Email') }}</label>
                                        <input type="text" name="contact_email" class="form-control form-control-alternative"
                                            id="input-contact_email" 
                                            value="{{ old('contact_email' , $customerData->contact_email) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone_number">{{ __('Phone Number') }}</label>
                                        <input type="text" name="phone_number" class="form-control form-control-alternative"
                                            id="input-phone_number" 
                                            value="{{ old('phone_number' , $customerData->phone_number) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-gender">{{ __('Gender') }}</label>
                                        <select class="form-control form-control-alternative"
                                        name="gender" id="select-gender">
                                        <option value="Unspecified" @if($customerData->gender == 'Unspecified') selected @endif>Unspecified</option>
                                        <option value="Male" @if($customerData->gender == 'Male') selected @endif>Male</option>
                                        <option value="Female" @if($customerData->gender == 'Female') selected @endif>Female</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                        <input type="text" name="address" class="form-control form-control-alternative"
                                            id="input-address" 
                                            value="{{ old('address' , $customerData->address) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-dob">{{ __('Date of Birth') }}</label>
                                        <input type="date" name="dob" class="form-control form-control-alternative"
                                            id="input-dob" 
                                            value="{{ old('dob', $customerData->dob) }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-is_active">{{ __('Active Status') }}</label>
                                        <select class="form-control form-control-alternative"
                                        name="is_active" id="select-is_active">
                                        <option value="1" @if($customerData->is_active == 1) selected @endif>Yes</option>
                                        <option value="0" @if($customerData->is_active == 0) selected @endif>No</option>
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

        $(document).on('submit','#customer_update_form',function(e) {

                e.preventDefault();

                var id = $('#customer_id').val();
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
                    
                        url: 'http://127.0.0.1:8000/api/customer/update/' + id,
                        type: 'PUT',
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
                                    title: 'Customer Updated!',
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

    {!! JsValidator::formRequest('App\Http\Requests\CustomerUpdateRequest', '#customer_update_form') !!}
@endpush
