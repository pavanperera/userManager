<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\CustomerProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerData = CustomerProfile::all();

        return view('customer.index', compact('customerData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        // dd($request->contact_email);

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

            return redirect('/customer/list')->with('success', 'Customer Created!');
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return redirect()->back()->withInput()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customerData = CustomerProfile::where('id', $id)->first();

        return view('customer.edit', compact('customerData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
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

            return redirect('/customer/list')->with('success', 'Customer Updated!');
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return redirect()->back()->withInput()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $customerData = CustomerProfile::where('id', $id)->first();

            $customerData->delete();
            return redirect('/customer/list')->with('success', 'Customer Deleted!');
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return redirect()->back()->withInput()->with('error', 'Something went wrong!');
        }
    }
}
