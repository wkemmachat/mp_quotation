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

class ExportKPI implements FromQuery, WithMapping, WithHeadings,WithColumnFormatting, ShouldAutoSize
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
        $this->kpi_type_id = $request->kpi_type_id;

        // dd($this->kpi_type_id);
    }

    public function query()
    {

        $kpiOutputArray =  KpiOutput::where('input_date','>=',$this->startDate)->where('input_date','<=',$this->endDate)
        ->where('role_id','=',$this->kpi_type_id)->orderby('input_date', 'asc');

        // $num = 1;
        foreach($kpiOutputArray as $kpiOutput) {
            dd("testaaa");
            $kpiOutput['num'] = "abc";

            dd($kpiOutput->num);
        }



        // dd($kpiOutputArray);
        return $kpiOutputArray;
    }

    public function map($kpiOutput): array
    {

        /*
        'input_date','remark','user_id','user_key_in_id'
                            ,'role_id','total_amount','total_defect'
        */

        return [


            Date::dateTimeToExcel($kpiOutput->input_date),
            $kpiOutput->user->name,
            $kpiOutput->total_amount,
            $kpiOutput->total_defect,
            $kpiOutput->remark,
            $kpiOutput->role->title,
            $kpiOutput->user_key_in->name,
            Date::dateTimeToExcel($kpiOutput->created_at),
            $kpiOutput->id,
            $kpiOutput->num,
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


            'Input Date',
            'Name',
            'Total amount',
            'Total defect',
            'Remark',
            'KPI Type',
            'Key in',
            'Created at',
            'Unique Id',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

}
