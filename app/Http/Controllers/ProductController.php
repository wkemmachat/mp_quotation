<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Kamaln7\Toastr\Facades\Toastr;
use App\Exports\ExportProduct;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // $kpi_outputs = KpiOutput::where('role_id','=',$roleSelected->id)->orderBy('updated_at', 'desc')->paginate(10);
        $products = Product::orderBy('updated_at', 'desc')->paginate(10);

        // return view('kpi.index',compact('roleSelected','usersHaveRoleArray','kpi_outputs'));
        return view('product.index',compact('products'));

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
            'productId' => 'required',
            'productName' => 'required',
        ]);


        // save
        $productToBeSave = new Product();
        // $productToBeSave->input_date        = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
        $productToBeSave->user_key_in_id    = Auth::user()->id;
        $productToBeSave->productId         = $request->productId;
        $productToBeSave->productName       = $request->productName;
        $productToBeSave->remark            = $request->remark;

        $productToBeSave->save();

        $products = Product::orderBy('updated_at', 'desc')->paginate(10);

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);
        return view('product.index',compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function show(KpiOutput $kpiOutput)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $productSelected = Product::findOrFail($id);
        // dd($userSelected);
        // $users = User::all();
        return view('product.edit',compact('productSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $productSelected = Product::findOrFail($id);

        $validatedData = $request->validate([
            'productId' => 'required|max:255',
            'productName' => 'required|max:255',
        ]);

        // update
        $productSelected->productId     = $request['productId'];
        $productSelected->productName   = $request['productName'];
        $productSelected->remark        = $request['remark'];
        $productSelected->save();

        $products = Product::orderBy('updated_at', 'desc')->paginate(10);

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);
        return view('product.index',compact('products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

    }


    public function exportProduct(Request $request)
    {
        return Excel::download(new ExportProduct($request), 'product.xlsx');
    }
}
