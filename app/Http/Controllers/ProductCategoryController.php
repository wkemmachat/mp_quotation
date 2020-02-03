<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Auth;
use Kamaln7\Toastr\Facades\Toastr;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(!Gate::allows('isRoot')){
        //     abort(404,"Sorry, You can do this actions");
        // }

        // old method
        $categories = ProductCategory::all();
        $main_categories = ProductCategory::where('parent_id',NULL)->get();
        return view('product_category.index',compact('categories','main_categories'));
        // new method with sub
        // $categories = ProductCategory::where('parent_id',NULL)->get();
        // return view('product_category.index',compact('categories'));


    }

    public function add_sub_index($id)
    {

        // dd($id);
        $productCategorySelected = ProductCategory::findOrFail($id);
        // dd($userSelected);
        // $users = User::all();
        return view('product_category.add_sub',  compact('productCategorySelected'));


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
            'productCategoryId' => 'required',
            'productCategoryName' => 'required',
        ]);


        if($request->remark == null){
            $request->remark = '';
        }
        // save
        $productCatToBeSave = new ProductCategory();
        // $productToBeSave->input_date        = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
        $productCatToBeSave->user_key_in_id    = Auth::user()->id;
        $productCatToBeSave->productCategoryId         = $request->productCategoryId;
        $productCatToBeSave->productCategoryName       = $request->productCategoryName;
        $productCatToBeSave->remark            = $request->remark;

        $productCatToBeSave->save();

        $categories = ProductCategory::all();

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);
        return view('product_category.index',compact('categories'));
    }



    public function add_sub_store(Request $request)
    {

        $request->validate([
            'productCategoryId' => 'required',
            'productCategoryName' => 'required',
            'parent_id' => 'required',
        ]);


        if($request->remark == null){
            $request->remark = '';
        }
        // save
        $productCatToBeSave = new ProductCategory();
        // $productToBeSave->input_date        = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
        $productCatToBeSave->user_key_in_id    = Auth::user()->id;
        $productCatToBeSave->productCategoryId          = $request->productCategoryId;
        $productCatToBeSave->productCategoryName        = $request->productCategoryName;
        $productCatToBeSave->remark                     = $request->remark;
        $productCatToBeSave->parent_id                  = $request->parent_id;

        $productCatToBeSave->save();

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);


        $categories = ProductCategory::all();
        $main_categories = ProductCategory::where('parent_id',NULL)->get();
        return view('product_category.index',compact('categories','main_categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $productCategorySelected = ProductCategory::findOrFail($id);
        // dd($userSelected);
        // $users = User::all();
        return view('product_category.edit',  compact('productCategorySelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        // dd($id);

        $productCategorySelected = ProductCategory::findOrFail($id);

        // dd($productCategorySelected);

        $request->validate([
            'productCategoryId' => 'required',
            'productCategoryName' => 'required',
        ]);

        if($request->remark == null){
            $request->remark = '';
        }
        // update
        $productCategorySelected->productCategoryId     = $request['productCategoryId'];
        $productCategorySelected->productCategoryName   = $request['productCategoryName'];
        $productCategorySelected->remark                = $request->remark;
        $productCategorySelected->save();

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        $categories = ProductCategory::all();
        $main_categories = ProductCategory::where('parent_id',NULL)->get();
        return view('product_category.index',compact('categories','main_categories'));



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
