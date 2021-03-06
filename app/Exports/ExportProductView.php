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
use App\KpiOutput;
use App\Product;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportProductView implements FromView,WithColumnFormatting, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    // protected $kpi_type_id;


    public function __construct($request)
    {
        $this->startDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->format('Y-m-d');
        $this->endDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->format('Y-m-d');
        // $this->kpi_type_id = $request->kpi_type_id;

        // dd($this->kpi_type_id);
    }

    public function view(): View
    {
        $products = Product::where('updated_at','>=',$this->startDate)->where('updated_at','<=',$this->endDate)
        ->orderby('id', 'asc')->get();

        $count = Product::where('updated_at','>=',$this->startDate)->where('updated_at','<=',$this->endDate)
        ->orderby('id', 'asc')->count();

        // dd($count);
        // dd($this->startDate);
        // dd($this->endDate);
        // dd($products[0]);
        // dd(sizeof($products));

        return view('product._exportProduct', [
            'products' => $products
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

}
