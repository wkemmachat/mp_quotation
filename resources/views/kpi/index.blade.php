@extends('layouts.back.blank')


@section('title')
    KPI
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
          Manage KPI :{{ strtoupper($roleSelected->title) }}
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
                            <h3 class="box-title">Add <font color="blue"><strong> {{ strtoupper($roleSelected->title) }} </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{route('kpi_output.store',$roleSelected->title)}}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>Date: <font color="red">*</font></label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_input" value="" class="datepicker form-control pull-right" required />
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>User: <font color="red">*</font></label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                            </div>
                                            <select name="user_id" class="form-control pull-right " required >
                                            <option value="">Please Select User</option>
                                            @foreach ($usersHaveRoleArray as $user)
                                                @if(strcasecmp($user->user_type, "root") == 0)
                                                    @continue
                                                @endif
                                                <option value="{{ $user->id }}">{{ $user->name }} : {{ $user->user_type }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Total Amount/ยอดรวม : <font color="red">*</font> (ใส่ 0 ถ้าเป็นวันหยุดหรืออาทิตย์)</label>

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-th-large"></i>
                                            </div>
                                            <input type="text" name="total_amount" required class="form-control pull-right" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" >
                                            {{--  <input type="text" name="total_amount" value="" class="form-control pull-right" data-inputmask='"mask": "9999"' data-mask>  --}}
                                            {{--  <input type="text" name="total_amount" value="" class="form-control pull-right" data-inputmask='"mask": "(999) 999-9999"' data-mask>  --}}
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="form-group">
                                        <label>Total Defect/ยอดของเสีย :</label>

                                        <div class="input-group ">
                                            <div class="input-group-addon">
                                            <i class="fa fa-wheelchair"></i>
                                            </div>
                                            <input type="text" name="total_defect" value="" class="form-control pull-right" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" >
                                        </div>

                                        @if ($errors->has('total_defect'))
                                            <span class="text-red" role="alert">
                                                <strong>{{ $errors->first('total_defect') }}</strong>
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




        @if(!empty($kpi_outputs))
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
                                    <th class="text-center">Date / วันที่</th>
                                    <th class="text-center">Name / ผู้ทำงาน</th>
                                    <th class="text-center">Total Amount / ยอดรวม</th>
                                    <th class="text-center">Total Defect / ยอดเสีย</th>
                                    <th class="text-center">Remark / หมายเหตุ</th>
                                    <th class="text-center">Delete</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($kpi_outputs as  $indexKey => $kpi_outputInLoop)
                                <tr>
                                    <td class="text-center">{{++$indexKey}}</td>
                                    <td class="text-center">{{date('d-M-Y', strtotime($kpi_outputInLoop->input_date))}}</td>
                                    <td class="text-center">{{ $kpi_outputInLoop->user->name }}</td>
                                    <td class="text-center">{{ number_format($kpi_outputInLoop->total_amount) }}</td>
                                    <td class="text-center">{{ number_format($kpi_outputInLoop->total_defect) }}</td>
                                    <td class="text-center">{{ $kpi_outputInLoop->remark }}</td>
                                    <td class="text-center">
                                        {{-- <a href="{{ route('kpi_output.delete',$kpi_outputInLoop->id) }}" class="btn btn-block btn-danger">Delete<a> --}}
                                        <form class="form-delete" method="post" action="{{ route('kpi_output.delete', [$roleSelected->title]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="kpi_delete_id" value="{{ $kpi_outputInLoop->id }}"/>
                                            <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure?')">x</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>


                        </table>
                        {{ $kpi_outputs->links() }}
                    </div>

                </div>
            </div>
        </div>
        @endif


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Export To Excel <font color="blue"><strong> {{ strtoupper($roleSelected->title) }} </strong></font> Data</h3>
                        </div>

                        <div class="box-body">
                            <div class="register-box-body">

                                <form action="{{route('kpi_output.exportKPI')}}" method="post">
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

                                    <input type="hidden" name="kpi_type_id" value="{{ $roleSelected->id }}"/>



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


      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




