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
            Product Category
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
                        <h3 class="box-title">Add <font color="blue"><strong><font color="green"> Main</font> Product Category</strong></font> Data</h3>
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
                        {{-- <table class="table table-responsive"> --}}
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Category Id</th>
                                    <th class="text-center">Category Name</th>
                                    <th class="text-center">Updated Date / วันที่</th>
                                    <th class="text-center">Name / ผู้ทำงาน</th>
                                    <th class="text-center">Remark / หมายเหตุ</th>
                                    <th class="text-center">Parent Name</th>
                                    <th class="text-center">Add Sub / Edit</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($categories as  $indexKey => $categoriesInLoop)
                                <tr>
                                    <td class="text-center">{{++$indexKey}}</td>
                                    <td class="text-center">{{ $categoriesInLoop->productCategoryId }}</td>
                                    <td class="text-center">{{ $categoriesInLoop->productCategoryName }}</td>
                                    <td class="text-center">{{ date('d-M-Y',strtotime($categoriesInLoop->updated_at)) }}</td>
                                    {{-- <td class="text-center">{{ $productInLoop->created_at->format('d M Y') }}</td> --}}
                                    <td class="text-center">{{ $categoriesInLoop->user_key_in->name }}</td>
                                    <td class="text-center">{{ $categoriesInLoop->remark }}</td>
                                    <td class="text-center">{{ $categoriesInLoop->has_parent==null?"":  $categoriesInLoop->has_parent->productCategoryName}}</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('kpi_output.delete',$kpi_outputInLoop->id) }}" class="btn btn-block btn-danger">Delete<a> --}}
                                        {{-- <form class="form-delete" method="post" action="{{ route('kpi_output.delete', [$roleSelected->title]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="kpi_delete_id" value="{{ $kpi_outputInLoop->id }}"/>
                                            <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure?')">x</button>
                                        </form> --}}
                                        <a href="{{ route('category.add_sub_index',$categoriesInLoop->id) }}" class="btn  btn-primary">Add Sub<a>
                                        <a href="{{ route('category.edit',$categoriesInLoop->id) }}" class="btn  btn-warning">Edit<a>
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


        <!-- // Test Method -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>List All Categories</strong></div>
                    <div class="card-body">
                        @foreach($main_categories as $category)
                            <ul>
                                <li><font color="blue">{{$category->productCategoryName}}</font></li>
                                @if(count($category->subcategory))
                                    @include('product_category.subCategoryList',['subcategories' => $category->subcategory])
                                @endif
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                    <table id="tree-table" class="table table-hover table-bordered">
                        <tbody>
                            <th>Categories </th>
                                @foreach($categories as $category)
                                    <tr data-id="{{$category->id}}" data-parent="0" data-level="1">
                                        <td data-column="name">{{$category->productCategoryName}}</td>
                                    </tr>
                                    @if(count($category->subcategory))
                                        @include('product_category.subCategoryView',['subcategories' => $category->subcategory, 'dataParent' => $category->id , 'dataLevel' => 1])
                                    @endif
                                @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- // End Test Method -->
        @endif


        <!-- Start datatable -->

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                      <h3 class="box-title">Data Table With Full Features</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Rendering engine</th>
                          <th>Browser</th>
                          <th>Platform(s)</th>
                          <th>Engine version</th>
                          <th>CSS grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 4.0
                          </td>
                          <td>Win 95+</td>
                          <td> 4</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 5.0
                          </td>
                          <td>Win 95+</td>
                          <td>5</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 5.5
                          </td>
                          <td>Win 95+</td>
                          <td>5.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 6
                          </td>
                          <td>Win 98+</td>
                          <td>6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet Explorer 7</td>
                          <td>Win XP SP2+</td>
                          <td>7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>AOL browser (AOL desktop)</td>
                          <td>Win XP</td>
                          <td>6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 1.0</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 1.5</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 2.0</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 3.0</td>
                          <td>Win 2k+ / OSX.3+</td>
                          <td>1.9</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Camino 1.0</td>
                          <td>OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Camino 1.5</td>
                          <td>OSX.3+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape 7.2</td>
                          <td>Win 95+ / Mac OS 8.6-9.2</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape Browser 8</td>
                          <td>Win 98SE+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape Navigator 9</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.0</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.1</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.2</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.2</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.3</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.3</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.4</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.4</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.5</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.6</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.7</td>
                          <td>Win 98+ / OSX.1+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.8</td>
                          <td>Win 98+ / OSX.1+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Seamonkey 1.1</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Epiphany 2.20</td>
                          <td>Gnome</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 1.2</td>
                          <td>OSX.3</td>
                          <td>125.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 1.3</td>
                          <td>OSX.3</td>
                          <td>312.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 2.0</td>
                          <td>OSX.4+</td>
                          <td>419.3</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 3.0</td>
                          <td>OSX.4+</td>
                          <td>522.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>OmniWeb 5.5</td>
                          <td>OSX.4+</td>
                          <td>420</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>iPod Touch / iPhone</td>
                          <td>iPod</td>
                          <td>420.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>S60</td>
                          <td>S60</td>
                          <td>413</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 7.0</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 7.5</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 8.0</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 8.5</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 9.0</td>
                          <td>Win 95+ / OSX.3+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 9.2</td>
                          <td>Win 88+ / OSX.3+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 9.5</td>
                          <td>Win 88+ / OSX.3+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera for Wii</td>
                          <td>Wii</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Nokia N800</td>
                          <td>N800</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Nintendo DS browser</td>
                          <td>Nintendo DS</td>
                          <td>8.5</td>
                          <td>C/A<sup>1</sup></td>
                        </tr>
                        <tr>
                          <td>KHTML</td>
                          <td>Konqureror 3.1</td>
                          <td>KDE 3.1</td>
                          <td>3.1</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>KHTML</td>
                          <td>Konqureror 3.3</td>
                          <td>KDE 3.3</td>
                          <td>3.3</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>KHTML</td>
                          <td>Konqureror 3.5</td>
                          <td>KDE 3.5</td>
                          <td>3.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Tasman</td>
                          <td>Internet Explorer 4.5</td>
                          <td>Mac OS 8-9</td>
                          <td>-</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Tasman</td>
                          <td>Internet Explorer 5.1</td>
                          <td>Mac OS 7.6-9</td>
                          <td>1</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Tasman</td>
                          <td>Internet Explorer 5.2</td>
                          <td>Mac OS 8-X</td>
                          <td>1</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>NetFront 3.1</td>
                          <td>Embedded devices</td>
                          <td>-</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>NetFront 3.4</td>
                          <td>Embedded devices</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>Dillo 0.8</td>
                          <td>Embedded devices</td>
                          <td>-</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>Links</td>
                          <td>Text only</td>
                          <td>-</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>Lynx</td>
                          <td>Text only</td>
                          <td>-</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>IE Mobile</td>
                          <td>Windows Mobile 6</td>
                          <td>-</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Misc</td>
                          <td>PSP browser</td>
                          <td>PSP</td>
                          <td>-</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Other browsers</td>
                          <td>All others</td>
                          <td>-</td>
                          <td>-</td>
                          <td>U</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Rendering engine</th>
                          <th>Browser</th>
                          <th>Platform(s)</th>
                          <th>Engine version</th>
                          <th>CSS grade</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>


            </div>
            <!-- /.col -->
        </div> --}}

        <!-- End datatable -->



      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




@section('js')
    <script>
        $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
        })
  </script>
@endsection
