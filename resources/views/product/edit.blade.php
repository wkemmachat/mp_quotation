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
                            <h3 class="box-title">Add <font color="red"><strong> Edit Product </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{route('product.update',$productSelected->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
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
                                                <input type="text" name="productId" value="{{ $productSelected->productId }}" maxlength="200" class="form-control pull-right" >
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
                                                <input type="text" name="productName" value="{{ $productSelected->productName }}" maxlength="200" class="form-control pull-right" >
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
                                            <input type="text" name="min" value="{{ ($productSelected->min > 0)? $productSelected->min : "" }}" maxlength="20" class="form-control pull-right plus_only" >
                                        </div>

                                        @if ($errors->has('min'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('min') }}</strong>
                                            </span>
                                        @endif
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Active : <font color="red">*</font></label>
                                        <div class="form-group has-feedback">
                                            <select name="active" class="form-control select2" placeholder="Active">
                                                <option value="1" {{ ($productSelected->active == 1)?"selected":"" }}>ACTIVE</option>
                                                <option value="0" {{ ($productSelected->active == 0)?"selected":"" }}>INACTIVE</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Product Category : <font color="red">*</font></label>
                                        <div class="form-group has-feedback">
                                            <select name="productCategory_running_Id" class="form-control select2" placeholder="USER_TYPE">
                                                @foreach ($categories as $categoriesInLoop)
                                                    <option value="{{ $categoriesInLoop->id }}" {{ ($categoriesInLoop->id==$productSelected->product_category->id)?" selected ":"" }}
                                                    >
                                                    {{ $categoriesInLoop->productCategoryId }} : {{ $categoriesInLoop->productCategoryName }}
                                                    </option>
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
                                            <input type="text" name="remark" value="{{ $productSelected->remark }}" maxlength="200" class="form-control pull-right" >
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

                                        <table width="100%" height="100%" align="center" valign="center">
                                            <tr>
                                                <td>
                                                @if(strlen($productSelected->imageName)>0)
                                                <img id='blah' src="{{ URL::to('/') }}/images/{{ $productSelected->imageName }}" class="img-thumbnail" width="250" />
                                                @else
                                                <img src="{{ URL::to('/') }}/images/default_product.jpg" class="img-thumbnail" width="250" />
                                                <font color='red'>No Image</font>
                                                @endif
                                                </td>
                                            </tr>
                                        </table>


                                        <br/>
                                        <input type="file" name="image" value="" id="imgInp" >

                                        <p class="help-block">Only .jpg, .jpeg, .png, max 2048 Bytes</p>
                                        @if ($errors->has('image'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
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
                                            <button type="submit" class="btn btn-warning btn-block btn-flat">Edit</button>
                                        </div>
                                    <!-- /.col -->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
            </div>
        </div>






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

