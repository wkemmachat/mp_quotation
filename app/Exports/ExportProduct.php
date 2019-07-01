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

class ExportProduct implements FromQuery, WithMapping, WithHeadings,WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $startDate;
    protected $endDate;
    protected $kpi_type_id;


    public function __construct($request)
    {
        $this->startDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->format('Y-m-d');
        $this->endDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->format('Y-m-d');
        // $this->kpi_type_id = $request->kpi_type_id;

        // dd($this->startDate);
    }

    public function query()
    {

        $productArray =  Product::where('updated_at','>=',$this->startDate)->where('updated_at','<=',$this->endDate)
        ->orderby('id', 'asc');

        // $num = 1;
        // foreach($productArray as $product) {
        //     dd("testaaa");
        //     $kpiOutput['num'] = "abc";

        //     dd($kpiOutput->num);
        // }



        // dd($kpiOutputArray);
        return $productArray;
    }

    public function map($obj): array
    {

        /*
        'input_date','remark','user_id','user_key_in_id'
                            ,'role_id','total_amount','total_defect'
        */

        return [


            $obj->id,
            $obj->productId,
            $obj->productName,
            $obj->remark,
            $obj->user_key_in->name,
            Date::dateTimeToExcel($obj->created_at),
            Date::dateTimeToExcel($obj->updated_at),

            // Date::dateTimeToExcel($kpiOutput->updated_at),

            /*
            empty($dot->fg_date)?"":Date::dateTimeToExcel($dot->fg_date),
            $dot->customer->customer_name,
            $dot->customer->size,
            $dot->top,
            $dot->bottom,
            $dot->spud,
            $dot->collar,
            $dot->footring,
            $dot->circle,
            $dot->longitudinal,
            $dot->tare_weight,

            empty($dot->user_key_fg)?"":$dot->user_key_fg->name,
            Date::dateTimeToExcel($dot->created_at),
            Date::dateTimeToExcel($dot->updated_at),
            */
        ];
    }

    public function headings(): array
    {
        return [

            'ID',
            'Product ID',
            'Product Name',
            'Remark',
            'Key in',
            'Created_at Date',
            'Updated_at Date',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

}
