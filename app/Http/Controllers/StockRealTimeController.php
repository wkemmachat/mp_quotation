<?php

namespace App\Http\Controllers;

use App\StockRealTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStock;
use App\Product;
use App\ProductCategory;
use App\TransferInOut;

class StockRealTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productAll = Product::orderBy('productId', 'asc')->get();
        $productCategoryAll = ProductCategory::orderBy('productCategoryId','asc')->get();
        return view('stock_real_time.index',compact('productAll','productCategoryAll'));
    }

    public function searchByProductId(Request $request)
    {
        // dd($request);
        $productSelected = Product::findOrFail($request->product_running_id_search);

        $sumOutByProductMp = TransferInOut::where('product_running_id','=',$productSelected->id)->where('isConfirmed','=',0)
        ->where('in_or_out','=','out')->where('out_type','=','mp')->sum('amount');

        $sumOutByProductFur = TransferInOut::where('product_running_id','=',$productSelected->id)->where('isConfirmed','=',0)
        ->where('in_or_out','=','out')->where('out_type','=','fur')->sum('amount');

        $sumOutByProductOff = TransferInOut::where('product_running_id','=',$productSelected->id)->where('isConfirmed','=',0)
        ->where('in_or_out','=','out')->where('out_type','=','off')->sum('amount');

        $sumInByProduct = TransferInOut::where('product_running_id','=',$productSelected->id)->where('isConfirmed','=',0)
        ->where('in_or_out','=','in')->sum('amount');


        $productCategoryAll = ProductCategory::orderBy('productCategoryId','asc')->get();
        $productAll = Product::orderBy('productId', 'asc')->get();
        return view('stock_real_time.index',compact('productAll','productCategoryAll','productSelected','sumOutByProductMp','sumOutByProductFur','sumOutByProductOff','sumInByProduct'));
    }

    public function searchByCategoryId(Request $request)
    {


        $productArrayByProductCatId = Product::where('productCategoryRunning_id','=',$request->product_category_running_id_search)->orderBy('productId', 'asc')->get();

        $outWaitingArrayMp       = array();
        $outWaitingArrayFur      = array();
        $outWaitingArrayOff      = array();
        $inWaitingArray         = array();

        for($i=0 ; $i<count($productArrayByProductCatId) ;$i++) {

            $sumOutByProductMp = TransferInOut::where('product_running_id','=',$productArrayByProductCatId[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','mp')->sum('amount');

            $sumOutByProductFur = TransferInOut::where('product_running_id','=',$productArrayByProductCatId[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','fur')->sum('amount');

            $sumOutByProductOff = TransferInOut::where('product_running_id','=',$productArrayByProductCatId[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','off')->sum('amount');

            $sumInByProduct = TransferInOut::where('product_running_id','=',$productArrayByProductCatId[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','in')->sum('amount');


            array_push($outWaitingArrayMp,$sumOutByProductMp);
            array_push($outWaitingArrayFur,$sumOutByProductFur);
            array_push($outWaitingArrayOff,$sumOutByProductOff);
            array_push($inWaitingArray,$sumInByProduct);

            // dd($products[$i]->id);
            // dd($outByProductOff);
        }




        $productCategoryAll = ProductCategory::orderBy('productCategoryId','asc')->get();
        $productAll = Product::orderBy('productId', 'asc')->get();
        return view('stock_real_time.index',compact('productAll','productArrayByProductCatId','productCategoryAll','outWaitingArrayMp','outWaitingArrayFur','outWaitingArrayOff','inWaitingArray'));
    }

    public function searchMinProduct(Request $request)
    {


        $productArrayActive = Product::where('active','=',1)->orderBy('productId', 'asc')->get();
        // dd($productArrayActive);
        $productArrayByMin      = array();
        $outWaitingArrayMp      = array();
        $outWaitingArrayFur     = array();
        $outWaitingArrayOff     = array();
        $inWaitingArray         = array();

        for($i=0 ; $i<count($productArrayActive) ;$i++) {

            $sumOutByProductMp = TransferInOut::where('product_running_id','=',$productArrayActive[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','mp')->sum('amount');

            $sumOutByProductFur = TransferInOut::where('product_running_id','=',$productArrayActive[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','fur')->sum('amount');

            $sumOutByProductOff = TransferInOut::where('product_running_id','=',$productArrayActive[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','off')->sum('amount');

            $sumInByProduct = TransferInOut::where('product_running_id','=',$productArrayActive[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','in')->sum('amount');

            if($productArrayActive[$i]->stock_real_time==null){
                $balance = 0;
                $totalBalance = $sumInByProduct;
            }else{
                $balance = $productArrayActive[$i]->stock_real_time->amount - $sumOutByProductMp - $sumOutByProductFur - $sumOutByProductOff;
                $totalBalance = $balance + $sumInByProduct;
            }
            if($productArrayActive[$i]->min > $totalBalance){

                array_push($productArrayByMin,$productArrayActive[$i]);
                array_push($outWaitingArrayMp,$sumOutByProductMp);
                array_push($outWaitingArrayFur,$sumOutByProductFur);
                array_push($outWaitingArrayOff,$sumOutByProductOff);
                array_push($inWaitingArray,$sumInByProduct);

            }

            // array_push($outWaitingArrayMp,$sumOutByProductMp);
            // array_push($outWaitingArrayFur,$sumOutByProductFur);
            // array_push($outWaitingArrayOff,$sumOutByProductOff);
            // array_push($inWaitingArray,$sumInByProduct);

            // dd($products[$i]->id);
            // dd($outByProductOff);
        }




        $productCategoryAll = ProductCategory::orderBy('productCategoryId','asc')->get();
        $productAll = Product::orderBy('productId', 'asc')->get();
        return view('stock_real_time.index',compact('productAll','productArrayByMin','productCategoryAll','outWaitingArrayMp','outWaitingArrayFur','outWaitingArrayOff','inWaitingArray'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockRealTime  $stockRealTime
     * @return \Illuminate\Http\Response
     */
    public function show(StockRealTime $stockRealTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockRealTime  $stockRealTime
     * @return \Illuminate\Http\Response
     */
    public function edit(StockRealTime $stockRealTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockRealTime  $stockRealTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockRealTime $stockRealTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockRealTime  $stockRealTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockRealTime $stockRealTime)
    {
        //
    }

    public function exportStock(Request $request)
    {
        return Excel::download(new ExportStock($request), 'exportStock.xlsx');
    }
}
