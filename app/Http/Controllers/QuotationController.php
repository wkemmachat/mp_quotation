<?php

namespace App\Http\Controllers;

use App\QuotationMain;
use App\QuotationDetail;
use Illuminate\Http\Request;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use Kamaln7\Toastr\Facades\Toastr;
use Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $quotations          = Quotation::where('isConfirmed','=',1)->where('in_or_out','=','in')->orderby('id','desc')->paginate(10);
        $quotations         = QuotationMain::orderby('id','desc')->paginate(10);
        $now = now();
        $products           = Product::orderBy('productId', 'asc')->get();
        $customers          = Customer::all();
        return view('quotation.index',compact('customers','quotations','now','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_running_id.*' => 'required|integer',
            'amount.*' => 'required|integer',
            'PI_number' => 'required',
            'depositPercentOrValue' => 'required',
            'customer_running_id' => 'required',
        ]);


        if($request->remarkInPI == null){
            $request->remarkInPI = '';
        }
        if($request->shippingCostInPI == null){
            $request->shippingCostInPI = '';
        }
        if($request->specialDiscount == null){
            $request->specialDiscount = '';
        }
        if($request->depositAmountPercentOrValue == null){
            $request->depositAmountPercentOrValue = '';
        }

        //check duplicate
        // get quotationMain
        $isDuplicated = false;
        $quotatiomMainSelected = QuotationMain::where([
            ['PI_number', '=', $request->PI_number]
        ])->first();
        if($quotatiomMainSelected!=null){
            $isDuplicated = true;
            $message = "Error, Duplicate PI_Number!!";
            Toastr::warning($message, $title = "Error Action", $options = []);
        }

        // dd($request->all());
        if(!$isDuplicated){
            // check Unique
            if (count($request->product_running_id) !== count(array_unique($request->product_running_id))){

                // echo 'not equal';
                $message = "Error, Same Product Id!!";
                Toastr::warning($message, $title = "Error Action", $options = []);


            }else{
                // echo 'equal';
                // Quotation Main

                // protected $fillable = [ 'customer_running_id'
                // ,'PI_number','PI_date','shippingCostInPI','specialDiscount'
                // ,'depositPercentOrValue','depositdepositeAmountPercentOrValue','remarkInPI' ];

                $products   = $request->product_running_id;
                $amounts    = $request->amount;
                $discountPercentByProducts = $request->discountPercentByProduct;
                $remarkByProducts    = trim($request->remarkByProduct);

                $quotationMainToBeSave = new QuotationMain();
                $quotationMainToBeSave->customer_running_id         = $request->customer_running_id;
                $quotationMainToBeSave->user_key_in_id              = Auth::user()->id;
                $quotationMainToBeSave->PI_number                   = trim($request->PI_number);

                $quotationMainToBeSave->PI_date                     = now();
                $quotationMainToBeSave->shippingCostInPI            = $request->shippingCostInPI;
                $quotationMainToBeSave->specialDiscount             = $request->specialDiscount;
                $quotationMainToBeSave->depositPercentOrValue       = $request->depositPercentOrValue;
                $quotationMainToBeSave->depositAmountPercentOrValue       = $request->depositAmountPercentOrValue;
                $quotationMainToBeSave->remarkInPI                  = $request->remarkInPI;

                // only update
                $quotationMainToBeSave->ref_PI_number = "";

                $quotationMainToBeSave->save();

                // save details
                for ($i = 0; $i < count($products); $i++) {
                    // dd($products[$i]);
                    if($amounts[$i]<=0){
                        continue;
                    }

                    if($remarkByProducts[$i]==null){
                        $remarkByProducts[$i] = "";
                    }

                    if($discountPercentByProducts[$i]==null){
                        $discountPercentByProducts[$i] = 0;
                    }


                    // Quotation Detail

                    // protected $fillable = [ 'product_running_id','amount','remarkByProduct'
                    //             ,'discountPercentByProduct','quotation_main_running_id'];




                    // save continue;

                    $quotationDetailToBeSave                        = new QuotationDetail();
                    $quotationDetailToBeSave->product_running_id    = $products[$i];
                    $quotationDetailToBeSave->amount                      = $amounts[$i];
                    $quotationDetailToBeSave->remarkByProduct             = $remarkByProducts[$i];
                    $quotationDetailToBeSave->discountPercentByProduct    = $discountPercentByProducts[$i];

                    // $user->groups()->save(new Group($groupdata));
                    $quotationMainToBeSave->quotation_details()->save($quotationDetailToBeSave);

                } // end for

                $message = "Successfully add data";
                Toastr::success($message, $title = "Successfully Action", $options = []);

            } // end else
        }//end if(!$isDuplicated)


        $quotations         = QuotationMain::orderby('id','desc')->paginate(10); // must edit later
        $now = now();
        $products           = Product::orderBy('productId', 'asc')->get();
        $customers          = Customer::all();
        return view('quotation.index',compact('customers','quotations','now','products'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $quotationMainSelected = QuotationMain::findOrFail($id);
        $now = now();
        $products           = Product::orderBy('productId', 'asc')->get();
        $customers          = Customer::all();
        return view('quotation.edit',  compact('quotationMainSelected','customers','products','now'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //dd($request->all());

        $request->validate([
            'product_running_id.*' => 'required|integer',
            'amount.*' => 'required|integer',
            'PI_number' => 'required',
            'depositPercentOrValue' => 'required',
            'customer_running_id' => 'required',
        ]);

        if($request->remarkInPI == null){
            $request->remarkInPI = '';
        }
        if($request->shippingCostInPI == null){
            $request->shippingCostInPI = '';
        }
        if($request->specialDiscount == null){
            $request->specialDiscount = '';
        }
        if($request->depositAmountPercentOrValue == null){
            $request->depositAmountPercentOrValue = '';
        }

        // dd($request->PI_number);


        // $myString = 'Hello, there!';
        // PI_number = ABCD__rev2
        $next_PI_number = "";
        $old_PI_number  = $request->PI_number;

        if ( strpos( $request->PI_number, '__rev' ) !== false ) {
           //echo "Found";
           $pi_number_without_rev = explode('__rev',$old_PI_number);
           //dd($pi_number_without_rev);
           $rev_number = (int)(explode('__rev',$old_PI_number)[1]);
        //    dd($rev_number+1);
           $next_PI_number = $pi_number_without_rev[0]."__rev".($rev_number+1);
            // dd($next_PI_number);
        } else {
            //echo "Not Found";
            //$request->PI_number =  $request->PI_number." ".__"rev2;
            $next_PI_number = $request->PI_number."__rev2";

        }

        // get quotationMainSelected
        $quotatiomMainSelected = QuotationMain::where([
            ['PI_number', '=', $request->PI_number]
        ])->first();

        // check duplicate after create next_PI_number
        $quotatiomMainMainNextPINumber = QuotationMain::where([
            ['PI_number', '=', $next_PI_number]
        ])->first();

        $isDuplicated = false;
        if($quotatiomMainMainNextPINumber!=null){
            $isDuplicated = true;
            $message = "Error, Duplicate PI_Number!!";
            Toastr::warning($message, $title = "Error Action", $options = []);
        }

        if(!$isDuplicated){
            // dd($next_PI_number);
            if (count($request->product_running_id) !== count(array_unique($request->product_running_id))){

                // echo 'not equal';
                $message = "Error, Same Product Id!!";
                Toastr::warning($message, $title = "Error Action", $options = []);


            }else{
                // echo 'equal';
                // Quotation Main

                // protected $fillable = [ 'customer_running_id'
                // ,'PI_number','PI_date','shippingCostInPI','specialDiscount'
                // ,'depositPercentOrValue','depositdepositeAmountPercentOrValue','remarkInPI' ];

                $products   = $request->product_running_id;
                $amounts    = $request->amount;
                $discountPercentByProducts = $request->discountPercentByProduct;
                $remarkByProducts    = $request->remarkByProduct;

                $quotationMainToBeSave = new QuotationMain();
                $quotationMainToBeSave->customer_running_id         = $request->customer_running_id;
                $quotationMainToBeSave->user_key_in_id              = Auth::user()->id;
                $quotationMainToBeSave->PI_number                   = $next_PI_number;

                $quotationMainToBeSave->PI_date                     = $quotatiomMainSelected->PI_date;
                $quotationMainToBeSave->shippingCostInPI            = $request->shippingCostInPI;
                $quotationMainToBeSave->specialDiscount             = $request->specialDiscount;
                $quotationMainToBeSave->depositPercentOrValue       = $request->depositPercentOrValue;
                $quotationMainToBeSave->depositAmountPercentOrValue = $request->depositAmountPercentOrValue;
                $quotationMainToBeSave->remarkInPI                  = $request->remarkInPI;

                // only update
                $quotationMainToBeSave->ref_PI_number = $old_PI_number;

                $quotationMainToBeSave->save();

                // save details
                for ($i = 0; $i < count($products); $i++) {
                    // dd($products[$i]);
                    if($amounts[$i]<=0){
                        continue;
                    }

                    if($remarkByProducts[$i]==null){
                        $remarkByProducts[$i] = "";
                    }

                    if($discountPercentByProducts[$i]==null){
                        $discountPercentByProducts[$i] = 0;
                    }


                    // Quotation Detail

                    // protected $fillable = [ 'product_running_id','amount','remarkByProduct'
                    //             ,'discountPercentByProduct','quotation_main_running_id'];




                    // save continue;

                    $quotationDetailToBeSave                        = new QuotationDetail();
                    $quotationDetailToBeSave->product_running_id    = $products[$i];
                    $quotationDetailToBeSave->amount                      = $amounts[$i];
                    $quotationDetailToBeSave->remarkByProduct             = $remarkByProducts[$i];
                    $quotationDetailToBeSave->discountPercentByProduct    = $discountPercentByProducts[$i];

                    // $user->groups()->save(new Group($groupdata));
                    $quotationMainToBeSave->quotation_details()->save($quotationDetailToBeSave);

                } // end for

                $message = "Successfully add data";
                Toastr::success($message, $title = "Successfully Action", $options = []);

            } // end else

        }//end if(!$isDuplicated)





        $quotations         = QuotationMain::orderby('id','desc')->paginate(10); // must edit later
        $now = now();
        $products           = Product::orderBy('productId', 'asc')->get();
        $customers          = Customer::all();
        return view('quotation.index',compact('customers','quotations','now','products'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
