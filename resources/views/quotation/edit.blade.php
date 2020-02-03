@extends('layouts.back.blank')


@section('title')
   Quotation
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
            Quotation
            <small>View/Edit Data</small>
        </h1>
        {{--  <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>  --}}
    </section>

    <!-- Main content -->
    <section class="content">
        {{--  <div class="row">  --}}
        <form action="{{ route('quotation.update',$quotationMainSelected->id)}}" onSubmit="return confirm('Are you sure you want to edit?');">
            @csrf
            @method('PATCH')
            {{-- <input type="hidden" name="in_or_out" value="in" maxlength="10" class="form-control pull-right" > --}}

            <?php
                // round( 1.55, 1, PHP_ROUND_HALF_UP) // 1 digit
                $totalShow = 0.00;
                $specialDiscountShow = 0.00;
                $subTotalShow = 0.00;
                $shippingShow = 0.00;
                $subTotalAfterShippingShow = 0.00;
                $vat7PercentShow = 0.00;
                $grandTotalShow = 0.00;
                $depositPaymentShow = 0.00;
                $balancePaymentShow = 0.00;
                $depositPercentOrValueShow = "";
                $depositAmountPercentOrValueShow = 0.00;


                foreach ($quotationMainSelected->quotation_details as $key=>$quotationDetail){
                    $std_price_eachProduct = $quotationDetail->product->std_price ;
                    $price_each_product_afterDiscount = $std_price_eachProduct*(100-$quotationDetail->discountPercentByProduct)/100;
                    $totalShow += $price_each_product_afterDiscount*$quotationDetail->amount;
                }

                // protected $fillable = [ 'customer_running_id'
                //             ,'PI_number','PI_date','shippingCostInPI','specialDiscount'
                //             ,'depositPercentOrValue','depositAmountPercentOrValue','remarkInPI' ];

                $specialDiscountShow                = $quotationMainSelected->specialDiscount;
                $subTotalShow                       = $totalShow - $specialDiscountShow;
                $shippingShow                       = $quotationMainSelected->shippingCostInPI;
                $subTotalAfterShippingShow          = round($subTotalShow+$shippingShow,2,PHP_ROUND_HALF_UP);
                $vat7PercentShow                    = round(7/100*$subTotalAfterShippingShow,2,PHP_ROUND_HALF_UP);
                $grandTotalShow                     = $subTotalAfterShippingShow + $vat7PercentShow;
                $depositPercentOrValueShow          = $quotationMainSelected->depositPercentOrValue;
                $depositAmountPercentOrValueShow    = $quotationMainSelected->depositAmountPercentOrValue;

                if(strcasecmp($depositPercentOrValueShow, "value")==0){
                    $depositPaymentShow = $depositAmountPercentOrValueShow;
                    $balancePaymentShow = $grandTotalShow-$depositPaymentShow;
                }else if(strcasecmp($depositPercentOrValueShow, "percent")==0){
                    $depositPaymentShow = round($depositAmountPercentOrValueShow*$grandTotalShow/100,2,PHP_ROUND_HALF_UP);
                    $balancePaymentShow = $grandTotalShow-$depositPaymentShow;
                }else{
                    $depositPercentOrValueShow = "ERROR !!";
                }


            ?>



            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <!-- Default box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <font color="blue"><strong> Edit Quotation </strong></font> Data</h3>
                            </div>

                            <div class="box-body table-responsive">
                                <div class="register-box-body">


                                        <div class="form-group">
                                            <label>Date: <font color="red">*</font></label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="PI_date" disabled value="{{ $quotationMainSelected->PI_date }}" class=" form-control pull-right" required />
                                            </div>
                                            <!-- /.input group -->
                                        </div>


                                        <div class="form-group">
                                            <label>PI No. : <font color="red">* Unique</font></label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-sticky-note"></i>
                                                </div>
                                            <input type="text" name="PI_number" disabled value="{{$quotationMainSelected->PI_number}}" maxlength="20" class="form-control pull-right" >

                                                {{-- <input type="text" name="PI_number" disabled value="IN-{{ $now->format('d-m-Y-H-i-s') }}" maxlength="100" class="form-control pull-right" > --}}
                                                {{-- <input type="hidden" name="document_reference_id" value="IN-{{ $now->format('d-m-Y-H-i-s') }}" maxlength="100" class="form-control pull-right" > --}}

                                            </div>

                                            @if ($errors->has('PI_number'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('PI_number') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>


                                        {{-- protected $fillable = [ 'customer_running_id'
                                        ,'PI_number','PI_date','shippingCostInPI','specialDiscount'
                                        ,'depositPercentOrValue','depositAmountPercentOrValue','remarkInPI' ]; --}}


                                        <div class="form-group">
                                            <label>Customer : <font color="red">*</font></label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-user-plus"></i>
                                                </div>
                                                <select name="customer_running_id" class="form-control pull-right select2 input-medium" required >
                                                    <option value=""> -- Please Select Customer -- </option>
                                                    @foreach ($customers as $customer)
                                                        <option
                                                            value="{{ $customer->id }}" {{ ($quotationMainSelected->customer_running_id==$customer->id)? "selected" : ""  }}>
                                                            {{ $customer->customerName }} : {{ $customer->customerContactPerson }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('customer_running_id'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('customer_running_id') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Shipping Cost / ค่าขนส่ง : </label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-truck"></i>
                                                </div>
                                                <input type="text" name="shippingCostInPI" value="{{ $quotationMainSelected->shippingCostInPI}}" maxlength="20" class="form-control pull-right plus_only" >

                                            </div>

                                            @if ($errors->has('shippingCostInPI'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('shippingCostInPI') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Special Discount / ส่วนลดเพิ่มเติม : </label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-money"></i>
                                                </div>
                                                <input type="text" name="specialDiscount" value="{{ $quotationMainSelected->specialDiscount}}" maxlength="20" class="form-control pull-right decimal_only" >

                                            </div>

                                            @if ($errors->has('specialDiscount'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('specialDiscount') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Deposit Type / ประเภทมัดจำ: </label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-cog"></i>
                                                </div>
                                                <select name="depositPercentOrValue" class="form-control pull-right input-medium" required >
                                                    <option value="value" {{ ($quotationMainSelected->depositPercentOrValue == "value")?"selected":""}}>--Value--</option>
                                                    <option value="percent" {{ ($quotationMainSelected->depositPercentOrValue == "percent")?"selected":""}}>--Percent--</option>
                                                </select>
                                            </div>

                                            @if ($errors->has('depositPercentOrValue'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('depositPercentOrValue') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Deposit Value / มัดจำ : </label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-bitcoin"></i>
                                                </div>
                                                <input type="text" name="depositAmountPercentOrValue" value="{{ $quotationMainSelected->depositAmountPercentOrValue}}" maxlength="20" class="form-control pull-right decimal_only" >

                                            </div>

                                            @if ($errors->has('depositAmountPercentOrValue'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('depositAmountPercentOrValue') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                        <div class="form-group">
                                            <label>Remark : </label>

                                            <div class="input-group ">
                                                <div class="input-group-addon">
                                                <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <input type="text" name="remarkInPI" value="{{ $quotationMainSelected->remarkInPI}}" maxlength="20" class="form-control pull-right " >

                                            </div>

                                            @if ($errors->has('remarkInPI'))
                                                <span class="text-red" role="alert">
                                                    <strong>{{ $errors->first('remarkInPI') }}</strong>
                                                </span>
                                            @endif
                                            <!-- /.input group -->
                                        </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                <!-- Default box -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <font color="green"><strong> Summary Data </strong></font> Data</h3>
                            </div>

                            <div class="box-body table-responsive">
                                <div class="register-box-body">


                                        <div class="form-group">
                                            <label>Total: </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                            <input type="text" name="" disabled value="{{$totalShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Special Discount: </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$specialDiscountShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sub Total: </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$subTotalShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>ค่าขนส่ง / Shipping: </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$shippingShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sub Total After Shipping : </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$subTotalAfterShippingShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>VAT 7% : </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$vat7PercentShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Grand Total : </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$grandTotalShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Deposit Payment : </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$depositPaymentShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Balance Payment : </label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="" disabled value="{{$balancePaymentShow}}" class=" form-control pull-right" required />
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                </div>
            </div>

            {{--  Add Row  --}}

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Quotation Data</h3>
                        </div>

                        <div class="box-body">
                            <table class="table table-responsive" id="myTbl">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No.</th>
                                        <th class="text-center" style="width: 40%">Product</th>
                                        <th class="text-center" style="width: 10%">Amount</th>
                                        <th class="text-center" style="width: 10%">% Discount</th>
                                        <th class="text-center" style="width: 35%">Remark</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($quotationMainSelected->quotation_details as $key=>$quotationDetail)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td>
                                            <select name="product_running_id[]" disabled class="form-control pull-right select2 input-medium" required >
                                                <option value=""> -- Please Select Product -- </option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ ($quotationDetail->product->id == $product->id)?"selected":""}}
                                                    >
                                                        {{ $product->productId }} : {{ $product->productName }} : Price -> {{$product->std_price}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="amount[]" value="{{ $quotationDetail->amount }}" class="form-control pull-right plus_only" >

                                        </td>
                                        <td>
                                            <input type="text" name="discountPercentByProduct[]" value="{{ $quotationDetail->discountPercentByProduct }}" class="form-control pull-right plus_only" >
                                        </td>
                                        <td>
                                            <input type="text" name="remarkByProduct[]" value="{{ $quotationDetail->remarkByProduct }}" class="form-control pull-right" >
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input class="btn btn-success" type="button" id="addRow" value="Add Row">
                                            <input class="btn btn-danger pull-right" type="button" id="removeRow" value="Remove Row">
                                            {{-- <a href="" class="btn btn-success" id="addRow">Add Row</a> --}}
                                            {{-- <a href="" class="btn btn-danger pull-right" id="removeRow">Remove Row</a> --}}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <br/><br/>
                            <div class="col-md-8 col-md-offset-2">
                                    <button type="submit" class="btn btn-warning btn-block btn-flat ">Edit And Create New Quotation</button>
                            </div>
                        </div>

                    </div>

                </div>


            </div>


        </form>
        {{--  </div>  --}}


      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection

@section('js')
<script type="text/javascript">
    $(function(){
        var counter = 1;

        $("#addRow").click(function(){
            counter ++;

            var parentData   = '<tr>';
                parentData  += '<td class="text-center">'+counter+'</td>';

                parentData  += '<td>';
                parentData  += '<select name="product_running_id[]" class="form-control pull-right select2 input-medium" required >';
                parentData  += '<option value=""> -- Please Select Product -- </option>';
                parentData  += '@foreach ($products as $product)';
                parentData  += '<option value="{{ $product->id }}">{{ $product->productId }} : {{ $product->productName }} : Price -> {{$product->std_price}}</option>';
                parentData  += '@endforeach';
                parentData  += '</select>';
                parentData  += '</td>';


                parentData 	+= '<td>';
                parentData 	+= '<input type="text" name="amount[]" value="" class="form-control pull-right plus_only" >' ;
                parentData 	+= '</td>';

                parentData 	+= '<td>';
                parentData 	+= '<input type="text" name="discountPercentByProduct[]" value="" class="form-control pull-right plus_only" >';
                parentData 	+= '</td>';

                parentData 	+= '<td>';
                parentData 	+= '<input type="text" name="remarkByProduct[]" value="" class="form-control pull-right" >';
                parentData 	+= '</td>';

                parentData += '</tr>';



            $("#myTbl tbody").append(parentData);

            $("select.select2").select2();

        });

        $("#removeRow").click(function(){

            if($("#myTbl tbody tr").length>1){
                counter --;
                $("#myTbl tbody tr:last").remove();
            }else{
                alert("ต้องมีรายการข้อมูลอย่างน้อย 1 รายการ");
            }
        });

        $(document).ready(function() {
            $(".select2").select2();
            $(".plus_only").inputFilter(function(value) {
                return /^\d*$/.test(value);
            });

        });

    });
</script>
@endsection




