<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Product;
use App\TransferInOut;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportStock implements FromView,WithColumnFormatting, ShouldAutoSize
{
    // protected $startDate;
    // protected $endDate;
    // protected $inOrOut;
    // protected $kpi_type_id;


    public function __construct($request)
    {
        // $this->startDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->format('Y-m-d');
        // $this->endDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->format('Y-m-d');
        // $this->in_or_out = $request->in_or_out;
        // $this->kpi_type_id = $request->kpi_type_id;

        // dd($this->kpi_type_id);
    }

    public function view(): View
    {
        $now = now();
        // echo $now->toDateTimeString();
        $products           = Product::orderBy('productId', 'asc')->get();
        $outWaitingArrayMp       = array();
        $outWaitingArrayFur      = array();
        $outWaitingArrayOff      = array();
        $inWaitingArray         = array();

        for($i=0 ; $i<count($products) ;$i++) {

            $sumOutByProductMp = TransferInOut::where('product_running_id','=',$products[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','mp')->sum('amount');

            $sumOutByProductFur = TransferInOut::where('product_running_id','=',$products[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','fur')->sum('amount');

            $sumOutByProductOff = TransferInOut::where('product_running_id','=',$products[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','out')->where('out_type','=','off')->sum('amount');

            $sumInByProduct = TransferInOut::where('product_running_id','=',$products[$i]->id)->where('isConfirmed','=',0)
            ->where('in_or_out','=','in')->sum('amount');


            array_push($outWaitingArrayMp,$sumOutByProductMp);
            array_push($outWaitingArrayFur,$sumOutByProductFur);
            array_push($outWaitingArrayOff,$sumOutByProductOff);
            array_push($inWaitingArray,$sumInByProduct);

            // dd($products[$i]->id);
            // dd($outByProductOff);
        }

        // dd($outWaitingArrayOff);
        // $transferInOutArray = TransferInOut::where('created_at','>=',$this->startDate)->where('created_at','<=',$this->endDate)
        // ->where('in_or_out','=',$this->in_or_out)->orderby('id', 'asc')->get();

        // dd($transferInOutArray);

        // $count = Product::where('updated_at','>=',$this->startDate)->where('updated_at','<=',$this->endDate)
        // ->orderby('id', 'asc')->count();

        // dd($count);
        // dd($this->startDate);
        // dd($this->endDate);
        // dd($products[0]);
        // dd(sizeof($products));

        return view('stock_real_time._export', [
            'now' => $now,
            'products' => $products,
            'outWaitingArrayMp' => $outWaitingArrayMp,
            'outWaitingArrayFur' => $outWaitingArrayFur,
            'outWaitingArrayOff' => $outWaitingArrayOff,
            'inWaitingArrayOff' => $inWaitingArray,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            // 'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            // 'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

}
