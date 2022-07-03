@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.css" />
@endpush

@push('custom-styles')
    <style>
        /* datatable */
        .child {
            table-layout: fixed
        }

        .child td {
            word-wrap: break-word;
            white-space: normal !important;
        }

    </style>
@endpush

@section('content')
<div class="container-full">
    <div class="row justify-content-center">
        <div class="col-md-12 home-block">
            <div class="card">
                <div class="card-header">{{ __('Customer List') }}</div>

                <div class="card-body">

                    <table id="customer_table" class="table align-items-center table-flush customer_table" cellspacing="0" width="100%">
                        <thead class="thead-light">
                            <tr>

                                <th scope="col">{{ __('First Name') }}</th>
                                <th scope="col">{{ __('Last Name') }}</th>
                                <th scope="col">{{ __('Phone Number') }}</th>
                                <th scope="col">{{ __('Contact Email') }}</th>
                                <th scope="col">{{ __('Date of Birth') }}</th>
                                <th scope="col">{{ __('Age') }}</th>
                                <th scope="col">{{ __('Gender') }}</th>
                                <th scope="col">{{ __('Address') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Created at') }}</th>
                                <th scope="col">{{ __('Last Updated at') }}</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                    
                            </tr>
                        </thead>
                        <tbody id="tbl_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush

@push('custom-scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    
    $(document).ready( function () {

        $.ajax({
            url:'http://127.0.0.1:8000/api/customer/list',
            type: 'get',
            dataType: 'json',

            success: function(response) {

                var len = 0;
                if (response.customer_data != null) {
                    len = response.customer_data.length;
                }


                if (len > 0) {

                    for (var i = 0; i < len; i++) {

                        var id = response.customer_data[i].id;
                        var first_name = response.customer_data[i].first_name;
                        var last_name = response.customer_data[i].last_name;
                        var phone_number = response.customer_data[i].phone_number;
                        var contact_email = response.customer_data[i].contact_email;
                        var dob = response.customer_data[i].dob;
                        var first_name = response.customer_data[i].first_name;
                        var gender = response.customer_data[i].gender;
                        var address = response.customer_data[i].address;
                        var is_active = response.customer_data[i].is_active;
                        var created_at = response.customer_data[i].created_at;
                        var updated_at = response.customer_data[i].updated_at;

                        // calculate age
                        var month_diff = Date.now() - Date.parse(dob);  
                        var age_dt = new Date(month_diff);
                        var year = age_dt.getUTCFullYear(); 
                        var age = Math.abs(year - 1970);

                        // status
                        if(is_active == 1){
                            var is_active = 'Active';
                        }else{
                            var is_active = 'Inactive';
                        }
                        
                        // edit link
                        var edit_url = "http://127.0.0.1:8000/customer/edit/" + id;

                        // delete link
                        var delete_url = "http://127.0.0.1:8000/api/customer/delete/" + id;



                        var customer = "<tr> <td>" + first_name +"<td>"+ last_name + "</td>"+ "<td>"+ phone_number + "</td>"+ "<td>"+ contact_email + "</td>"+ "<td>"+ dob + "</td>"+"<td>"+ age + "</td>"+"<td>"+ gender + "</td>"+"<td>"+ address + "</td>"+"<td>"+ is_active + "</td>"+"<td>"+ created_at + "</td>"+"<td>"+ updated_at + "</td>"+"<td> <a href='"+ edit_url +"'> Edit </a></td>"+ "<td> <a href='#' onclick='myFunction("+ id +")'> Delete </a></td> </tr>";

                        $("#tbl_body").append(customer);
                    }
                }

            }
        });




    } );

    
    function myFunction(id) {

            var customer_id = id;

            jQuery.ajax({

            url: 'http://127.0.0.1:8000/api/customer/delete/' + customer_id ,
            type: 'delete',

            success: function(response) {
                if (response.status == 'success') {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: "warning",
                        title: 'User Deleted!',
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

        }


</script>
@endpush
