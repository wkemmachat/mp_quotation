@extends('layouts.back.blank')


@section('title')
    Edit Customer
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
            Customer
            <small>Edit Data</small>
        </h1>
        {{--  <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>  --}}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit <font color="blue"><strong> Customer</strong></font> Data</h3>
                    </div>

                    <div class="box-body">
                        <div class="register-box-body">

                            <form action="{{route('customer.update',$customerSelected->id)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                        <label>Customer Name :<font color="red"> *</font></label>

                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                            <i class="fa pfa-archive"></i>
                                            </div>
                                            <input type="text" name="customerName" value="{{ $customerSelected->customerName }}" maxlength="100" class="form-control pull-right" >
                                        </div>

                                        @if ($errors->has('customerName'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('customerName') }}</strong>
                                            </span>
                                        @endif
                                        <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                        <label>customer Address 1 : <font color="red"> *</font></label>

                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                            <i class="fa fa-sticky-note-o"></i>
                                            </div>
                                            <input type="text" name="customerAddress1" value="{{ $customerSelected->customerAddress1 }}" maxlength="50" class="form-control pull-right" >
                                        </div>

                                        @if ($errors->has('customerAddress1'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('customerAddress1') }}</strong>
                                            </span>
                                        @endif
                                        <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>customer Address 2 :</label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-sticky-note-o"></i>
                                        </div>
                                        <input type="text" name="customerAddress2" value="{{ $customerSelected->customerAddress2 }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerAddress2'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerAddress2') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>customer Address 3 :</label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-sticky-note-o"></i>
                                        </div>
                                        <input type="text" name="customerAddress3" value="{{ $customerSelected->customerAddress3 }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerAddress3'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerAddress3') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>Customer's Contact Person: <font color="red"> *</font></label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-male"></i>
                                        </div>
                                        <input type="text" name="customerContactPerson" value="{{ $customerSelected->customerContactPerson }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerContactPerson'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerContactPerson') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>Customer's Tax Id:</label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                        </div>
                                        <input type="text" name="customerTaxId" value="{{ $customerSelected->customerTaxId }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerTaxId'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerTaxId') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>customer's Tel: <font color="red"> *</font></label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" name="customerTel" value="{{ $customerSelected->customerTel }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerTel'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerTel') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>customer's EMail:</label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="text" name="customerMail" value="{{ $customerSelected->customerMail }}" maxlength="50" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('customerMail'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('customerMail') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group">
                                    <label>Remarks/หมายเหตุ :</label>

                                    <div class="input-group ">
                                        <div class="input-group-addon">
                                        <i class="fa fa-sticky-note"></i>
                                        </div>
                                        <input type="text" name="remark" value="{{ $customerSelected->remark }}" maxlength="200" class="form-control pull-right" >
                                    </div>

                                    @if ($errors->has('remark'))
                                        <span class="text-red" role="alert">
                                            <strong>{{ $errors->first('remark') }}</strong>
                                        </span>
                                    @endif
                                    <!-- /.input group -->
                                </div>

                                <div class="row">
                                    <div class="col-xs-8">
                                        {{--  <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                                        </label>
                                        </div>  --}}
                                    </div>
                                <!-- /.col -->
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                                    </div>
                                <!-- /.col -->
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>









    </section>
    <!-- /.content -->


</div>



@endsection




@section('js')

@endsection
