<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\KpiOutput;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $date_collection    = collect([]);
        $date_collection_not_input_data    = collect([]);
        $total_amount_this_month       = collect([]);
        $total_amount_last_month       = collect([]);
        $total_defect_this_month       = collect([]);
        $total_defect_last_month       = collect([]);

        $startThisMonth     = Carbon::now()->startOfMonth();
        $endThisMonth       = Carbon::now()->endOfMonth();

        $startLastMonth     = new Carbon('first day of last month');
        $endLastMonth       = new Carbon('last day of last month');

        $roles = Auth::user()->roles;
        foreach ($roles as $role) {

            // check date not input

            $date_now = Carbon::today();
            // dd($date_now);
            $dt = $date_now->subDays(60);
            // dd($dt);
            $found = false;
            $i = 0;
            while(!$found){
                $kpi_outputCheck = KpiOutput::where([
                    ['role_id', '=', $role->id],
                    ['input_date', '=', $dt]
                ])->first();

                if($kpi_outputCheck==null){
                    $found = true;
                    $date_collection_not_input_data->push($dt);
                    break;
                }
                if($i==60){
                    $found = true;
                    $date_collection_not_input_data->push(null);
                    break;
                }
                $dt = $dt->addDay();

            }

            // dd($date_collection_not_input_data);



            // end check date not input

            // $dotArray = Dot::where([
            //     ['created_at', '>=', $carbon_date_nowSub15hr],
            //     ['created_at', '<=', $carbon_date_nowPlus1hr],
            //     ['user_id', '=', Auth::user()->id]
            // ])->orderby('updated_at', 'desc')->get();

            $kpi_outputArray = KpiOutput::where([
                ['role_id', '=', $role->id]
            ])->orderby('input_date', 'desc')->first();

            if($kpi_outputArray==null){
                $date_collection->push(null);
            }else{
                $date_collection->push($kpi_outputArray->input_date);
            }

            /*
            Model::selectRaw('count(*), min(some_field) as someMin, max(another_field) as someMax')->first();

            $output = KpiOutput::selectRaw('sum(total_amount) , sum(total_defect) ')
            ->where([
                ['input_date', '>=', $startThisMonth],
                ['input_date', '<=', $endThisMonth],
            ]);

            dd($output);
            */

            $output1 = KpiOutput::where([
                ['input_date', '>=', $startThisMonth],
                ['input_date', '<=', $endThisMonth],
                ['role_id', '=', $role->id]
            ])->sum('total_amount');

            $output2 = KpiOutput::where([
                ['input_date', '>=', $startThisMonth],
                ['input_date', '<=', $endThisMonth],
                ['role_id', '=', $role->id]
            ])->sum('total_defect');

            $output3 = KpiOutput::where([
                ['input_date', '>=', $startLastMonth],
                ['input_date', '<=', $endLastMonth],
                ['role_id', '=', $role->id]
            ])->sum('total_amount');

            $output4 = KpiOutput::where([
                ['input_date', '>=', $startLastMonth],
                ['input_date', '<=', $endLastMonth],
                ['role_id', '=', $role->id]
            ])->sum('total_defect');

            $total_amount_this_month->push($output1);
            $total_defect_this_month->push($output2);
            $total_amount_last_month->push($output3);
            $total_defect_last_month->push($output4);


            //sum example
            /*
            1)
            $purchases = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.kind', '=', 1)
            ->sum('transactions.amount');

            2)
            Model::where('username', 'john')->sum('balance');
            */

        }// end roles


        // dd($date_collection);
        // $canShow = false;
        // foreach($roles as $role){
        //     if(strcasecmp($role->title ,'abc')==0){
        //         $canShow = true;
        //         break;
        //     }
        // }
        // dd($canShow);

        // $start = Carbon::now()->startOfMonth();
        // $end = Carbon::now()->endOfMonth();
        // dd($end);

        return view('dashboard',compact('roles','date_collection','total_amount_this_month',
        'total_amount_last_month','total_defect_this_month','total_defect_last_month','startThisMonth','startLastMonth','date_collection_not_input_data'));
    }
}
