@extends('layouts.back.blank')


@section('title')
    Product Category
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
                            <h3 class="box-title">Add <font color="blue"><strong> Product Category</strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{route('category.store')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                            <label>Product Category Id :</label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-archive"></i>
                                                </div>
                                                <input type="text" name="productCategoryId" value="" maxlength="200" class="form-control pull-right" >
                                            </div>

                                            @if ($errors->has('productCategoryId'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('productCategoryId') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                            <label>Product Category Name :</label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-sticky-note-o"></i>
                                                </div>
                                                <input type="text" name="productCategoryName" value="" maxlength="200" class="form-control pull-right" >
                                            </div>

                                            @if ($errors->has('productCategoryName'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('productCategoryName') }}</strong>
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
                                            <input type="text" name="remark" value="" maxlength="200" class="form-control pull-right" >
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




        @if(!empty($categories))
        <!-- List Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data</h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Updated Date / วันที่</th>
                                    <th class="text-center">Name / ผู้ทำงาน</th>
                                    <th class="text-center">Remark / หมายเหตุ</th>
                                    <th class="text-center">Edit</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($categories as  $indexKey => $categoriesInLoop)
                                <tr>
                                    <td class="text-center">{{++$indexKey}}</td>
                                    <td class="text-center">{{ $categoriesInLoop->productCategoryId }}</td>
                                    <td class="text-center">{{ $categoriesInLoop->productCategoryName }}</td>
                                    <td class="text-center">{{ date('d-M-Y',strtotime($categoriesInLoop->created_at)) }}</td>
                                    {{-- <td class="text-center">{{ $productInLoop->created_at->format('d M Y') }}</td> --}}
                                    <td class="text-center">{{ $categoriesInLoop->user_key_in->name }}</td>
                                    <td class="text-center">{{ $categoriesInLoop->remark }}</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('kpi_output.delete',$kpi_outputInLoop->id) }}" class="btn btn-block btn-danger">Delete<a> --}}
                                        {{-- <form class="form-delete" method="post" action="{{ route('kpi_output.delete', [$roleSelected->title]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="kpi_delete_id" value="{{ $kpi_outputInLoop->id }}"/>
                                            <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure?')">x</button>
                                        </form> --}}

                                        <a href="{{ route('category.edit',$categoriesInLoop->id) }}" class="btn btn-block btn-warning">Edit<a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>


                        </table>
                        {{--  {{ $categories->links() }}  --}}
                    </div>

                </div>
            </div>
        </div>
        @endif


      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




