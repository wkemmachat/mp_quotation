@extends('layouts.back.blank')


@section('title')
    Product
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
            Products
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
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add <font color="blue"><strong> Products </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="active" value="1"/>
                                    {{-- <div class="form-group">
                                        <label>Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_input" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                    </div> --}}


                                    <div class="form-group">
                                            <label>Product Id : <font color="red">*</font></label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-archive"></i>
                                                </div>
                                                <input type="text" name="productId" value="" maxlength="200" class="form-control pull-right" >
                                            </div>

                                            @if ($errors->has('productId'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('productId') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                            <label>Product Name : <font color="red">*</font></label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-sticky-note-o"></i>
                                                </div>
                                                <input type="text" name="productName" value="" maxlength="200" class="form-control pull-right" >
                                            </div>

                                            @if ($errors->has('productName'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('productName') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Minimun : <font color="red">*</font></label>

                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                            <i class="fa fa-sort-amount-asc"></i>
                                            </div>
                                            <input type="text" name="min" value="" maxlength="200" class="form-control pull-right plus_only" >
                                        </div>

                                        @if ($errors->has('min'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('min') }}</strong>
                                            </span>
                                        @endif
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Product Category : <font color="red">*</font></label>
                                        <div class="form-group has-feedback">
                                            <select name="productCategory_running_Id" class="form-control select2" placeholder="USER_TYPE">
                                                @foreach ($categories as $categoriesInLoop)
                                                    <option value="{{ $categoriesInLoop->id }}">{{ $categoriesInLoop->productCategoryId }} : {{ $categoriesInLoop->productCategoryName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Remarks/หมายเหตุ :</label>

                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                            <i class="fa fa-sticky-note"></i>
                                            </div>
                                            <input type="text" name="remark" value="" maxlength="200" class="form-control pull-right" >
                                        </div>

                                        @if ($errors->has('remark'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('remark') }}</strong>
                                            </span>
                                        @endif
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Image/รูปภาพ :</label>

                                        <input type="file" name="image" value="" id="imgInp">
                                        <p class="help-block">Only .jpg, .jpeg, .png, max 2048 Bytes</p>
                                        @if ($errors->has('image'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif

                                        <img id='blah' src="{{ URL::to('/') }}/images/default_product.jpg" class="img-thumbnail" width="250" />
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




        @if(!empty($products))
        <!-- List Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Pic</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Product Cat</th>
                                    <th class="text-center">Active</th>
                                    <th class="text-center">Minimum</th>
                                    <th class="text-center">Updated Date / วันที่</th>
                                    {{--  <th class="text-center">Name / ผู้ทำงาน</th>  --}}
                                    <th class="text-center">Remark / หมายเหตุ</th>
                                    <th class="text-center">Edit</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($products as  $indexKey => $productInLoop)
                                    @php
                                        $showActiveOrNot = "<font color='red'>Inactive</font>";
                                        if($productInLoop->active==1){
                                            $showActiveOrNot = "<font color='blue'>Active</font>";
                                        }
                                    @endphp
                                <tr>
                                    <td class="text-center">{{++$indexKey}}</td>
                                    <td class="text-center">
                                        @if(strlen($productInLoop->imageName)>0)
                                            <a href="{{ URL::to('/') }}/images/{{ $productInLoop->imageName }}" data-fancybox data-caption="{{ $productInLoop->productName }}">
                                                <img src="{{ URL::to('/') }}/images/{{ $productInLoop->imageName }}" class="img-thumbnail" width="100" />
                                            </a>
                                        @else
                                        {{--  <img src="{{ URL::to('/') }}/images/default_product.jpg" class="img-thumbnail" width="100" />  --}}
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $productInLoop->productId }}</td>
                                    <td class="text-center">{{ $productInLoop->productName }}</td>
                                    <td class="text-center">{{ $productInLoop->product_category->productCategoryId }}</td>
                                    <td class="text-center">{!! $showActiveOrNot !!}</td>
                                    <td class="text-center">{{ $productInLoop->min }}</td>
                                    <td class="text-center">{{ date('d-M-Y',strtotime($productInLoop->created_at)) }}</td>
                                    {{-- <td class="text-center">{{ $productInLoop->created_at->format('d M Y') }}</td> --}}
                                    {{--  <td class="text-center">{{ $productInLoop->user_key_in->name }}</td>  --}}
                                    <td class="text-center">{{ $productInLoop->remark }}</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('kpi_output.delete',$kpi_outputInLoop->id) }}" class="btn btn-block btn-danger">Delete<a> --}}
                                        {{-- <form class="form-delete" method="post" action="{{ route('kpi_output.delete', [$roleSelected->title]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="kpi_delete_id" value="{{ $kpi_outputInLoop->id }}"/>
                                            <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure?')">x</button>
                                        </form> --}}

                                        <a href="{{ route('product.edit',$productInLoop->id) }}" class="btn btn-block btn-warning">Edit<a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>


                        </table>
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
        @endif

{{--
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> Products </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{ route('product.exportProduct')}}" method="post">
                                    @csrf

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
        </div> --}}

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> Products View</strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                {{-- <form action="{{ route('product.exportProduct')}}" method="post"> --}}
                                <form action="{{ route('product.exportProductView')}}" method="post">
                                    @csrf

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

                                    {{-- <input type="hidden" name="kpi_type_id" value="{{ $roleSelected->id }}"/> --}}



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


@section('js')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        readURL(this);
    });
</script>
@endsection

