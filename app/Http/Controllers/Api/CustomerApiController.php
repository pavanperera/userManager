<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerApiController extends Controller
{
    public function customerList()
    {

        try {

            $customerData = CustomerProfile::all();

            return response()->json([
                'status' => 'success',
                'customer_data' => $customerData,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }


    public function customerCreate(CustomerStoreRequest $request)
    {

        try {

            DB::beginTransaction();

            $createCustomer = CustomerProfile::create(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'contact_email' => $request->contact_email,
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'dob' => $request->dob,
                    'is_active' => $request->is_active,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => 'success',
                'customer_data' => $createCustomer,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }


    public function customerUpdate(CustomerUpdateRequest $request, $id)
    {

        try {

            $customerData = CustomerProfile::where('id', $id)->first();

            $customerData->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact_email' => $request->contact_email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
                'dob' => $request->dob,
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'status' => 'success',
                'customer_data' => $customerData,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }

    public function customerDelete($id)
    {

        try {

            $customerData = CustomerProfile::where('id', $id)->first();

            $customerData->delete();

            return response()->json([
                'status' => 'success',
                'customer_data' => 'Customer Deleted',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return response()->json(['status' => 'Something went wrong',], 500);
        }
    }
}
