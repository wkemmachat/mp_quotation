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
        {{-- Stock Inventory --}}
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




