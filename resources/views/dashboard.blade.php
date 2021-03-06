@extends('layouts.back.blank')


@section('title')
    User
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
          Dashboard
          <small>Details</small>
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
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Type: <font color="blue"><strong>{{ Auth::user()->user_type }}  </strong></font></h3>
                    </div>
                    <div class="box-body">
                        <p>1) User (No login allowed) </p>
                        <p>2) Admin (login allowed, can input data, uses EMAIL to login) </p>
                        <p>3) Root (login allowed and can manage user) </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- List User -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Roles/ Input Data</h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Not Input Data (last 2 months)</th>
                                    <th class="text-center">Lastest Record Date</th>
                                    <th class="text-center">Total Amount <font color="green"><strong>{{date('M', strtotime($startLastMonth))}}</strong></font></th>
                                    <th class="text-center">Total Defect <font color="green"><strong>{{date('M', strtotime($startLastMonth))}}</strong></font></th>
                                    <th class="text-center">Total Amount <font color="blue"><strong>{{date('M', strtotime($startThisMonth))}}</strong></font></th>
                                    <th class="text-center">Total Defect <font color="blue"><strong>{{date('M', strtotime($startThisMonth))}}</strong></font></th>
                                </tr>

                            </thead>

                            <tbody>
                                @for ($i = 0; $i < count($roles); $i++)
                                    <tr>
                                        <td class="text-center">{{ $roles[$i]->title }}</td>
                                        <td class="text-center">{{ $roles[$i]->description }}</td>

                                        @if($date_collection_not_input_data[$i]==null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">
                                            <font color="red"><strong>{{date('d-M-Y', strtotime($date_collection_not_input_data[$i]))}}</strong></font>
                                        </td>
                                        @endif
                                        {{--  <td>{{ $date_collection[$i] }}</td>  --}}
                                        @if($date_collection[$i]==null)
                                        <td class="text-center">-</td>
                                        @else
                                        <td class="text-center">
                                            <font color="blue"><strong>{{date('d-M-Y', strtotime($date_collection[$i]))}}</strong></font>
                                        </td>
                                        @endif
                                        <td class="text-center"><font color="green"><strong>{{ number_format($total_amount_last_month[$i]) }}</strong></font></td>
                                        <td class="text-center"><font color="green"><strong>{{ number_format($total_defect_last_month[$i]) }}</strong></font></td>
                                        <td class="text-center"><font color="blue"><strong>{{ number_format($total_amount_this_month[$i]) }}</strong></font></td>
                                        <td class="text-center"><font color="blue"><strong>{{ number_format($total_defect_this_month[$i]) }}</strong></font></td>

                                    </tr>
                                @endfor
                            </tbody>


                        </table>
                    </div>

                </div>
            </div>
        </div>




      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




