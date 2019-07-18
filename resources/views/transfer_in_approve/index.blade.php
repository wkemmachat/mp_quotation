@extends('layouts.back.blank')


@section('title')
    Transfer In (Approved)
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
            Transfer In
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


        @if(!empty($transfer_in_without_confirmed))
        <!-- List Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data <strong><font color='red'>NOT CONFIRMED</font></strong></h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Document Id</th>
                                    <th class="text-center">Created Date / วันที่</th>
                                    {{--  <th class="text-center">Name / ผู้ทำงาน</th>  --}}

                                    <th class="text-center">หมายเลข Shipment</th>
                                    <th class="text-center">Confirmed</th>
                                    <th class="text-center">Delete</th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php
                                    $uniqueDocRefId=array();
                                    for($i=0 ; $i<count($transfer_in_without_confirmed) ;$i++) {
                                        $isDubplicate = false;
                                        if($i!=0){
                                            if(!in_array($transfer_in_without_confirmed[$i]->document_reference_id,$uniqueDocRefId,TRUE)){
                                                $isDubplicate = false;
                                                array_push($uniqueDocRefId,$transfer_in_without_confirmed[$i]->document_reference_id);
                                                $uniqueDocRefId = array_unique($uniqueDocRefId);
                                            }else{
                                                $uniqueDocRefId = array_unique($uniqueDocRefId);
                                                $before = count($uniqueDocRefId);
                                                array_push($uniqueDocRefId,$transfer_in_without_confirmed[$i]->document_reference_id);
                                                $after  = count($uniqueDocRefId);
                                                if($before != $after){
                                                    $isDubplicate = true;
                                                }
                                            }

                                        }else{
                                            array_push($uniqueDocRefId,$transfer_in_without_confirmed[$i]->document_reference_id);
                                        }
                                        $uniqueDocRefId = array_unique($uniqueDocRefId);
                                ?>
                                    <tr>
                                        <td class="text-center">{{ $i+1 }}</td>
                                        <td>{{ $transfer_in_without_confirmed[$i]->product_running->productId }}</td>
                                        <td>{{ $transfer_in_without_confirmed[$i]->product_running->productName }}</td>
                                        <td class="text-center">{{ $transfer_in_without_confirmed[$i]->amount}}</td>
                                        <td class="text-center"><font color="blue">{{ $transfer_in_without_confirmed[$i]->document_reference_id }}</font></td>
                                        <td class="text-center">{{ date('d-M-Y',strtotime($transfer_in_without_confirmed[$i]->input_date)) }}</td>
                                        {{--  <td class="text-center">{{ $transfer_in_without_confirmed[$i]->user_key_in->name }}</td>  --}}
                                        <td class="text-center">{{ $transfer_in_without_confirmed[$i]->remark }}</td>
                                        <td class="text-center">
                                            {{--  <a href="{{ route('transfer_in_approve.approve_in',$transfer_in_without_confirmed[$i]->id) }}" class="btn btn-block btn-warning">Confirmed<a>  --}}
                                            @if(!$isDubplicate)
                                            <form class="" method="post" action="{{ route('transfer_in_approve.approve_in') }}">
                                                @method('POST')
                                                @csrf
                                                <input type="hidden" name="document_reference_id" value="{{ $transfer_in_without_confirmed[$i]->document_reference_id }}"/>
                                                <button type="submit" class="btn btn-block btn-warning" onclick="return confirm('Are you sure?')">Confirmed </button>
                                            </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$isDubplicate)
                                            <form class="form-delete" method="post" action="{{ route('transfer_in.destroy_in',$transfer_in_without_confirmed[$i]->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="document_reference_id" value="{{ $transfer_in_without_confirmed[$i]->document_reference_id }}"/>
                                                <button type="submit" class="btn btn-block btn-danger" onclick="return confirm('Are you sure?')">x</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>


                        </table>
                        {{--  {{ $products->links() }}  --}}
                    </div>

                </div>
            </div>
        </div>
        @endif

        @if(!empty($transfer_in_confirmed))
        <!-- List Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Data <strong><font color='green'>CONFIRMED</font></strong></h3>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Document Id</th>
                                    <th class="text-center">Created Date / วันที่</th>
                                    <th class="text-center">Name / ผู้ทำงาน</th>
                                    <th class="text-center">หมายเลข Shipment</th>
                                </tr>

                            </thead>

                            <tbody>
                                <?php
                                $uniqueDocRefId=array();
                                for($i=0 ; $i<count($transfer_in_confirmed) ;$i++) {
                                    $isDubplicate = false;
                                    if($i!=0){
                                        $uniqueDocRefId = array_unique($uniqueDocRefId);
                                        $before = count($uniqueDocRefId);
                                        array_push($uniqueDocRefId,$transfer_in_confirmed[$i]->document_reference_id);

                                        $after  = count($uniqueDocRefId);

                                        if($before != $after){
                                            $isDubplicate = true;

                                        }
                                    }else{
                                        array_push($uniqueDocRefId,$transfer_in_confirmed[$i]->document_reference_id);
                                    }
                                    $uniqueDocRefId = array_unique($uniqueDocRefId);
                                ?>
                                    <tr>
                                        <td class="text-center">{{ $i+1 }}</td>
                                        <td>{{ $transfer_in_confirmed[$i]->product_running->productId }}</td>
                                        <td>{{ $transfer_in_confirmed[$i]->product_running->productName }}</td>
                                        <td class="text-center">{{ $transfer_in_confirmed[$i]->amount}}</td>
                                        <td class="text-center"><font color="blue">{{ $transfer_in_confirmed[$i]->document_reference_id }}</font></td>
                                        <td class="text-center">{{ date('d-M-Y',strtotime($transfer_in_confirmed[$i]->input_date)) }}</td>
                                        <td class="text-center">{{ $transfer_in_confirmed[$i]->user_key_in->name }}</td>
                                        <td class="text-center">{{ $transfer_in_confirmed[$i]->remark }}</td>

                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>


                        </table>
                        {{ $transfer_in_confirmed->links() }}
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

@section('js')

@endsection




