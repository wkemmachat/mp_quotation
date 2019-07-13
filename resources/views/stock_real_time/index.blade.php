@extends('layouts.back.blank')


@section('title')
    Stock Real Time
@endsection

@section('content')

<div class="content-wrapper">

    {!! Toastr::render() !!}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content-header">
        <h1>
            Stock/Inventory
            <small>Add/Edit/List Data</small>
        </h1>
        {{--  <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>  --}}
    </section>

    <!-- Main content -->
    <section class="content">
        {{-- Stock Inventory Search--}}
        <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <!-- Default box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Search By Product<font color="blue"><strong> Stock / Inventory</strong></font> Data</h3>
                            </div>

                            <div class="box-body">
                                <div class="register-box-body">
                                    <form action="{{ route('stock_real_time.searchByProductId')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>Product: <font color="red">*</font></label>

                                            <select name="product_running_id_search" class="form-control select2 "  >
                                                <option value=""> -- Please Select Product -- </option>
                                                @foreach ($productAll as $product)
                                                    <option value="{{ $product->id }}">{{ $product->productId }} : {{ $product->productName }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="row">
                                            <div class="col-xs-8">

                                            </div>
                                        <!-- /.col -->
                                            <div class="col-xs-4">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Search</button>
                                            </div>
                                        <!-- /.col -->
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                </div>
            </div>

            @if(!empty($productSelected))
            <!-- List Data -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">List Data <strong><font color='red'>Search Product By Id</font></strong></h3>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Product Id</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Product Cat</th>
                                        <th class="text-center">Inventory</th>
                                        <th class="text-center">Pending Delivery (MP)</th>
                                        <th class="text-center">Pending Delivery (FUR)</th>
                                        <th class="text-center">Pending Delivery (OFF)</th>
                                        <th class="text-center">Balance</th>
                                        <th class="text-center">On P/O</th>
                                        <th class="text-center">Total Balance</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    @php
                                        $balance = $productSelected->stock_real_time->amount - $sumOutByProductMp - $sumOutByProductFur - $sumOutByProductOff;
                                        $totalBalance = $balance + $sumInByProduct;
                                    @endphp
                                        <tr>
                                            <td class="text-center">{{ 1 }}</td>
                                            <td class="text-center">{{ $productSelected->productId }}</td>
                                            <td class="text-center">{{ $productSelected->productName }}</td>
                                            <td class="text-center">{{ $productSelected->product_category->productCategoryId }}</td>
                                            <td class="text-center">{{ $productSelected->stock_real_time->amount}}</td>
                                            <td class="text-center">{{ $sumOutByProductMp }}</td>
                                            <td class="text-center">{{ $sumOutByProductFur }}</td>
                                            <td class="text-center">{{ $sumOutByProductOff }}</td>
                                            <td class="text-center">{{ $balance }}</td>
                                            <td class="text-center">{{ $sumInByProduct }}</td>
                                            <td class="text-center">{{ $totalBalance }}</td>
                                        </tr>
                                    @php

                                    @endphp

                                </tbody>


                            </table>
                            {{--  {{ $products->links() }}  --}}
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <!-- Search By product cat -->

        <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <!-- Default box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Search By Product Category<font color="blue"><strong> Stock / Inventory</strong></font> Data</h3>
                            </div>

                            <div class="box-body">
                                <div class="register-box-body">
                                    <form action="{{ route('stock_real_time.searchByCategoryId')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label>Product Category: <font color="red">*</font></label>

                                            <select name="product_category_running_id_search" class="form-control select2 "  >
                                                <option value=""> -- Please Select Product -- </option>
                                                @foreach ($productCategoryAll as $productCategoryInLoop)
                                                    <option value="{{ $productCategoryInLoop->id }}">{{ $productCategoryInLoop->productCategoryId }} : {{ $productCategoryInLoop->productCategoryName }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="row">
                                            <div class="col-xs-8">

                                            </div>
                                        <!-- /.col -->
                                            <div class="col-xs-4">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Search</button>
                                            </div>
                                        <!-- /.col -->
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                </div>
        </div>

        @if(!empty($productArrayByProductCatId))
        <!-- List Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data <strong><font color='red'>Search Product By Category Id</font></strong></h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Product Cat</th>
                                    <th class="text-center">Inventory</th>
                                    <th class="text-center">Pending Delivery (MP)</th>
                                    <th class="text-center">Pending Delivery (FUR)</th>
                                    <th class="text-center">Pending Delivery (OFF)</th>
                                    <th class="text-center">Balance</th>
                                    <th class="text-center">On P/O</th>
                                    <th class="text-center">Total Balance</th>
                                </tr>

                            </thead>

                            <tbody>
                                @php
                                    for($i=0 ; $i<count($productArrayByProductCatId) ;$i++) {
                                    $balance = $productArrayByProductCatId[$i]->stock_real_time->amount - $outWaitingArrayMp[$i] - $outWaitingArrayFur[$i] - $outWaitingArrayOff[$i];
                                    $totalBalance = $balance + $inWaitingArray[$i];

                                @endphp
                                    <tr>
                                        <td class="text-center">{{ $i+1 }}</td>
                                        <td class="text-center">{{ $productArrayByProductCatId[$i]->productId }}</td>
                                        <td class="text-center">{{ $productArrayByProductCatId[$i]->productName }}</td>
                                        <td class="text-center">{{ $productArrayByProductCatId[$i]->product_category->productCategoryId }}</td>
                                        <td class="text-center">{{ $productArrayByProductCatId[$i]->stock_real_time->amount}}</td>
                                        <td class="text-center">{{ $outWaitingArrayMp[$i] }}</td>
                                        <td class="text-center">{{ $outWaitingArrayFur[$i] }}</td>
                                        <td class="text-center">{{ $outWaitingArrayOff[$i] }}</td>
                                        <td class="text-center">{{ $balance }}</td>
                                        <td class="text-center">{{ $inWaitingArray[$i] }}</td>
                                        <td class="text-center">{{ $totalBalance }}</td>
                                    </tr>
                                @php
                                    }
                                @endphp

                            </tbody>


                        </table>
                        {{--  {{ $products->links() }}  --}}
                    </div>

                </div>
            </div>
        </div>
        @endif


        {{-- Stock Inventory Excel--}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> Stock / Inventory</strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">
                                <form action="{{ route('stock.exportStock')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-8">

                                        </div>
                                    <!-- /.col -->
                                        <div class="col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Export</button>
                                        </div>
                                    <!-- /.col -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
        {{-- Transfer IN --}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> Transfer In </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">
                                <form action="{{ route('transfer.exportTransferInOut')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="in_or_out" value="in" class=""  />

                                    <div class="form-group">
                                        <label>Start Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="startDate" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>End Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="endDate" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                        <!-- /.input group -->
                                    </div>



                                    <div class="row">
                                        <div class="col-xs-8">

                                        </div>
                                    <!-- /.col -->
                                        <div class="col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Export</button>
                                        </div>
                                    <!-- /.col -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
        {{-- Transfer Out --}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> Transfer Out </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">
                                <form action="{{ route('transfer.exportTransferInOut')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="in_or_out" value="out"  />
                                    <div class="form-group">
                                        <label>Start Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="startDate" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>End Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="endDate" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                        <!-- /.input group -->
                                    </div>



                                    <div class="row">
                                        <div class="col-xs-8">

                                        </div>
                                    <!-- /.col -->
                                        <div class="col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Export</button>
                                        </div>
                                    <!-- /.col -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>

        {{--  @include('product._exportProduct',$products)  --}}
      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




