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

                    <table class="table align-items-center table-flush company_table" cellspacing="0" width="100%">
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
                        <tbody>
            
                            @foreach ($customerData as $customer)
                                <tr>
                                    <td>{{ $customer->first_name ?? '--' }}</td>
                                    <td>{{ $customer->last_name ?? '--' }}</td>
                                    <td>{{ $customer->phone_number ?? '--' }}</td>
                                    <td>{{ $customer->contact_email ?? '--' }}</td>
                                    <td>{{ $customer->dob ?? '--' }}</td>
                                    <td>{{ $customer->age() ?? '--' }}</td>
                                    <td>{{ $customer->gender ?? '--' }}</td>
                                    <td>{{ $customer->address ?? '--' }}</td>
                                    <td>
                                        @if($customer->is_active == 1)
                                        {{ 'Active' }}
                                        @else
                                        {{ 'Inactive' }}
                                        @endif
                                    </td>
                                    <td>{{ $customer->created_at ?? '--' }}</td>
                                    <td>{{ $customer->updated_at ?? '--' }}</td>
                                    <td class="text-center">
                                        <form action="{{url('/customer/edit',[$customer->id])}}" method="POST">
                                            @method('GET')
                                            @csrf
                                            <button type="submit">Edit</button>               
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{url('/customer/delete',[$customer->id])}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit">Delete</button>               
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
@endpush

@push('custom-scripts')

<script>

    $('.company_table').DataTable({
        responsive: true,
        columnDefs: [{
            responsivePriority: 1,
            targets: 0
            },
            {
            responsivePriority: 1,
            targets: 2
            },
            {
            responsivePriority: 2,
            targets: 3
            },
            {
            responsivePriority: 1,
            targets: -2
            },
            {
            responsivePriority: 1,
            targets: -1
            }
            ],
            language: {
                    oPaginate: {
                        sNext: '<i class="fa fa-angle-right"></i>',
                        sPrevious: '<i class="fa fa-angle-left"></i>',
                        sFirst: '<i class="fa fa-step-backward"</i>',
                        sLast: '<i class="fa fa-step-forward"></i>'
                    }
                }
            });

</script>
@endpush
