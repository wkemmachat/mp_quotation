<?php

namespace App\Http\Controllers;

use App\StockRealTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStock;

class StockRealTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock_real_time.index');
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
