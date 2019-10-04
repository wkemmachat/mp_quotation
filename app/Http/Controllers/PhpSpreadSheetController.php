<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
//phpspreadsheet Date class
use PhpOffice\PhpSpreadsheet\Shared\Date;
//phpspreadsheet numberformat style class
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
//rich text class
use \PhpOffice\PhpSpreadsheet\RichText\RichText;
//phpspreadsheet style color
use \PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PhpSpreadSheetController extends Controller
{
    public function index(Request $request){

        // get parameter from Request
        // $startDate = Carbon::createFromFormat('d-m-Y', $request->startDate)->format('Y-m-d');
        // $endDate = Carbon::createFromFormat('d-m-Y', $request->endDate)->format('Y-m-d');
    
        // dd($startDate);

        //make a new spreadsheet object
        $spreadsheet = new Spreadsheet();
        //get current active sheet (first sheet)
        $sheet = $spreadsheet->getActiveSheet();
        // set the value of cell a1 to "Hello World!"
        $sheet->setCellValue('A1', "Hello World");

        //make an xlsx writer object using above spreadsheet
        $writer = new Xlsx($spreadsheet);
        //write the file in current directory
        // $writer->save('hello_world.xlsx');
        //redirect to the file
        // echo "<meta http-equiv='refresh' content='0;url=hello_world.xlsx'/>";
        $filename = 'name-of-the-generated-file';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$writer->save('php://output'); // download file 

    }

    public function index_type(Request $request){
    
        //file_get_contents(resource_path('views/admin/templates/show.blade.php'));

        //make a new spreadsheet object
        $spreadsheet = new Spreadsheet();
        //get current active sheet (first sheet)
        $sheet = $spreadsheet->getActiveSheet();

        //set default font
        $spreadsheet->getDefaultStyle()
                    ->getFont()
                    ->setName('Arial')
                    ->setSize(10);

        //set column dimension to auto size
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('B')
                    ->setAutoSize(true);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('C')
                    ->setAutoSize(true);

        //simple text data
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A1',"String")
                    ->setCellValue('B1',"Simple Text")
                    ->setCellValue('C1',"This is Phpspreadsheet");

        //symbols
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A2',"String")
                    ->setCellValue('B2',"Symbols")
                    ->setCellValue('C2',"ÚÔÛï¢£´°ƤǠњс҃ҭ");

        //utf-8 string
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A3',"String")
                    ->setCellValue('B3',"UTF-8")
                    ->setCellValue('C3',"добро пожаловать в мой учебник видео");


        //integer
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A4',"Number")
                    ->setCellValue('B4',"Integer")
                    ->setCellValue('C4',55);

        //float
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A5',"Number")
                    ->setCellValue('B5',"Float")
                    ->setCellValue('C5',55.55);

        //negative
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A6',"Number")
                    ->setCellValue('B6',"Negative")
                    ->setCellValue('C6',-55.55);
        //boolean
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A7',"Number")
                    ->setCellValue('B7',"Boolean")
                    ->setCellValue('C7',true)
                    ->setCellValue('D7',false);

        //date datatype
        //make a variable from current timestamp
        $dateTimeNow = time();

        //date
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A8',"Date/Time")
                    ->setCellValue('B8',"Date")
                    ->setCellValue('C8',Date::PHPToExcel($dateTimeNow));

        //set the cell format into a date
        $spreadsheet->getActiveSheet()
                    ->getStyle('C8')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD2);


        //date with time
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A9',"Date/Time")
                    ->setCellValue('B9',"Date Time")
                    ->setCellValue('C9',Date::PHPToExcel($dateTimeNow));

        //set the cell format into a date
        $spreadsheet->getActiveSheet()
                    ->getStyle('C9')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_DATETIME);

        //only time
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A10',"Date/Time")
                    ->setCellValue('B10',"Only Time")
                    ->setCellValue('C10',Date::PHPToExcel($dateTimeNow));

        //set the cell format into a date
        $spreadsheet->getActiveSheet()
                    ->getStyle('C10')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_TIME4);

        //rich text
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A11',"Rich text");

        $richText = new RichText();
        $richText->createText('normal text ');
        $payable = $richText->createTextRun('bold italic and dark green');
        $payable->getFont()->setBold(true);
        $payable->getFont()->setItalic(true);
        $payable->getFont()->setColor( new Color( Color::COLOR_DARKGREEN ) );

        //add a rich text
        $redText = $richText->createTextRun('red text');
        $redText->getFont()->setColor( new Color( Color::COLOR_RED ) );

        $richText->createText(' normal text again');
        $spreadsheet->getActiveSheet()->getCell('C11')->setValue($richText);

        //hyperlink
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A12',"Hyperlink")
                    ->setCellValue('B12',"Cell Hyperlink")
                    ->setCellValue('C12',"Visit Gemul's Channel");

        //set the cell as hyperlink
        $spreadsheet->getActiveSheet()
                    ->getCell('C12')
                    ->getHyperlink()
                    ->setUrl('https://youtube.com/c/GemulChannel')
                    ->setTooltip('Go to my youtube channel');

        //hyperlink with formula
        $spreadsheet->getActiveSheet()
                    ->setCellValue('A13',"Hyperlink")
                    ->setCellValue('B13',"Formula Hyperlink")
                    ->setCellValue('C13',"=HYPERLINK(\"https://youtube.com/c/GemulChannel\",\"My Youtube Channel\")");

        //change worksheet name
        $spreadsheet->getActiveSheet()
                    ->setTitle('Phpspreadsheet Chapter 2');

        //make an xlsx writer object using above spreadsheet
        $writer = new Xlsx($spreadsheet);
        //write the file in current directory
        // $writer->save('hello_world.xlsx');
        //redirect to the file
        // echo "<meta http-equiv='refresh' content='0;url=hello_world.xlsx'/>";
        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 

    }

    public function index_type2(Request $request){
    
        //file_get_contents(resource_path('views/admin/templates/show.blade.php'));


        //styling arrays
        //table head style
        $tableHead = [
            'font'=>[
                'color'=>[
                    'rgb'=>'000000'
                ],
                'bold'=>true,
                'size'=>11
            ],
            
            'borders' => [
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                ]
            ]
        ];
        //even row
        $evenRow = [
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '00BDFF'
                ]
            ]
        ];
        //odd row
        $oddRow = [
            'fill'=>[
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '00EAFF'
                ]
            ]
        ];

        //styling arrays end

        //make a new spreadsheet object
        $spreadsheet = new Spreadsheet();
        //get current active sheet (first sheet)
        $sheet = $spreadsheet->getActiveSheet();

        //print
        $spreadsheet->getActiveSheet()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_PORTRAIT);
        $spreadsheet->getActiveSheet()->getPageSetup()
                    ->setPaperSize(PageSetup::PAPERSIZE_A4);


        // fit to width            
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);            
        
        // page margin
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.75);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.75);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(1);

        //print header footer
        // $spreadsheet->getActiveSheet()->getHeaderFooter()
        //             ->setOddHeader('&C&HPlease treat this document as confidential!');
        // $spreadsheet->getActiveSheet()->getHeaderFooter()
        //             ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
        $spreadsheet->getActiveSheet()->getHeaderFooter()
                    ->setOddFooter('&RPage &P of &N');

        // printing break
        // $spreadsheet->getActiveSheet()->setBreak('A2', Worksheet::BREAK_ROW);            

        // repeat row 
        $spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);

        



        //set default font
        $spreadsheet->getDefaultStyle()
                    ->getFont()
                    ->setName('Arial')
                    ->setSize(10);

        //heading
        $spreadsheet->getActiveSheet()
        ->setCellValue('A1',"Participant Students");

        //merge heading
        $spreadsheet->getActiveSheet()->mergeCells("A1:F1");

        // set font style
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        // set cell alignment
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //setting column width
        // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);


        // images
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/mammoth.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A2');
        $drawing->setWorksheet($spreadsheet->getActiveSheet());


        //header text
        $spreadsheet->getActiveSheet()
        ->setCellValue('A3',"ID")
        ->setCellValue('B3',"First Name")
        ->setCellValue('C3',"Last Name")
        ->setCellValue('D3',"Email")
        ->setCellValue('E3',"Gender")
        ->setCellValue('F3',"Class");

        //set font style and background color
        $spreadsheet->getActiveSheet()->getStyle('A3:F3')->applyFromArray($tableHead);

        //the content
        //read the json file
        // $file = file_get_contents('student-data.json');
        $file = file_get_contents(resource_path('views/data_test/student-data.json'));

        $studentData = json_decode($file,true);

        //loop through the data
        //current row
        $row=4;
        foreach($studentData as $student){
            $spreadsheet->getActiveSheet()
                ->setCellValue('A'.$row , $student['id'])
                ->setCellValue('B'.$row , $student['first_name'])
                ->setCellValue('C'.$row , $student['last_name'])
                ->setCellValue('D'.$row , $student['email'])
                ->setCellValue('E'.$row , $student['gender'])
                ->setCellValue('F'.$row , $student['class']);

            //set row style
            if( $row % 2 == 0 ){
                //even row
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($evenRow);
            }else{
                //odd row
                $spreadsheet->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray($oddRow);
            }
            //increment row
            $row++;
        }

        //autofilter
        //define first row and last row
        $firstRow=2;
        $lastRow=$row-1;
        //set the autofilter
        // $spreadsheet->getActiveSheet()->setAutoFilter("A".$firstRow.":F".$lastRow);


        //make an xlsx writer object using above spreadsheet
        $writer = new Xlsx($spreadsheet);
        //write the file in current directory
        // $writer->save('hello_world.xlsx');
        //redirect to the file
        // echo "<meta http-equiv='refresh' content='0;url=hello_world.xlsx'/>";
        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file 

    }
}
