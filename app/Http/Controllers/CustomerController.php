<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Auth;
use Kamaln7\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customerName' => 'required',
            'customerAddress1' => 'required',
            'customerContactPerson' => 'required',
            'customerTel' => 'required'
        ]);

        if($request->customerAddress2 == null){
            $request->customerAddress2 = '';
        }
        if($request->customerAddress3 == null){
            $request->customerAddress3 = '';
        }
        if($request->customerTaxId == null){
            $request->customerTaxId = '';
        }
        if($request->customerMail == null){
            $request->customerMail = '';
        }
        if($request->remark == null){
            $request->remark = '';
        }
        // save
        $customerToBeSave = new Customer();
        // $productToBeSave->input_date        = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
        $customerToBeSave->user_key_in_id       = Auth::user()->id;
        $customerToBeSave->customerName         = $request->customerName;
        $customerToBeSave->customerAddress1     = $request->customerAddress1;
        $customerToBeSave->customerAddress2     = $request->customerAddress2;
        $customerToBeSave->customerAddress3     = $request->customerAddress3;
        $customerToBeSave->customerContactPerson     = $request->customerContactPerson;
        $customerToBeSave->customerTel          = $request->customerTel;
        $customerToBeSave->customerTaxId        = $request->customerTaxId;
        $customerToBeSave->customerMail         = $request->customerMail;
        $customerToBeSave->remark               = $request->remark;

        $customerToBeSave->save();

        $customers = Customer::all();

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);
        return view('customer.index',compact('customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $customerSelected = Customer::findOrFail($id);
        // dd($userSelected);
        // $users = User::all();
        return view('customer.edit',  compact('customerSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        // dd($id);

        $customerSelected = Customer::findOrFail($id);

        // dd($productCategorySelected);
        $request->validate([
            'customerName' => 'required',
            'customerAddress1' => 'required',
            'customerContactPerson' => 'required',
            'customerTel' => 'required'
        ]);

        if($request->customerAddress2 == null){
            $request->customerAddress2 = '';
        }
        if($request->customerAddress3 == null){
            $request->customerAddress3 = '';
        }
        if($request->customerTaxId == null){
            $request->customerTaxId = '';
        }
        if($request->customerMail == null){
            $request->customerMail = '';
        }
        if($request->remark == null){
            $request->remark = '';
        }

        // update
        $customerSelected->user_key_in_id       = Auth::user()->id;
        $customerSelected->customerName         = $request->customerName;
        $customerSelected->customerAddress1     = $request->customerAddress1;
        $customerSelected->customerAddress2     = $request->customerAddress2;
        $customerSelected->customerAddress3     = $request->customerAddress3;
        $customerSelected->customerContactPerson     = $request->customerContactPerson;
        $customerSelected->customerTel          = $request->customerTel;
        $customerSelected->customerTaxId        = $request->customerTaxId;
        $customerSelected->customerMail         = $request->customerMail;
        $customerSelected->remark               = $request->remark;

        $customerSelected->save();

        $message = "Successfully edit data";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        $customers = Customer::all();
        return view('customer.index',compact('customers'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
