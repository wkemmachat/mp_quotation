<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use DB;

class ExportQuotation
{
    public function index($pi_number)
    {

        \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );

        // Select customer data
        $quotationData = DB::table('quotation_mains')
        ->join('customers','quotation_mains.customer_running_id','=','customers.id')
        ->where('quotation_mains.PI_number','=',$pi_number)
        ->get()[0];

        // Select user data
        $userData =DB::table('users')
        ->where('id','=',$quotationData->user_key_in_id)
        ->get()[0];

        // Select quotation_details
        $detailData = DB::table('quotation_mains')
        ->join('quotation_details','quotation_mains.id','=','quotation_details.quotation_main_running_id')
        ->join('products','quotation_details.product_running_id','=','products.id')
        ->where('quotation_mains.PI_number','=',$pi_number)
        ->get();

        $companyData = (object)[
            'Name'=>'OFFICE INTREND Company Limited',
            'Address1'=>'587 Moo 3, Tambon Thepharak, Mphur Muang,',
            'Address2'=>'Samutprakarn 10270  THAILAND.',
            'Tel'=>'+(662)380-5555',
            'Fax'=>'+(662) 380-5555 Ext 100',
            'Email'=>'achara@officeintrend.com',
            'Website'=>'www.officeintrend.com'
        ];

        $signatureData = (object)[
            'FullName'=>'Miss Achara  Meesri',
            'Mobile'=>'+66 94 265 6451',
            'Email'=>'achara@officeintrend.com',
            'Image'=>public_path('images/Signature/'.$userData->imageSignature)
            // 'Image'=>public_path('images\\Signature\\'.$userData->imageSignature)
        ];

        $termsAndconditionsData = (object)[
            'DeliveryLeadtime'=>'At least 45 - 60 days upon receipt of confirmed Purchase Order and  deposit payment.',
            'DeliveryCondition'=>'Free installation for the project site located in Bangkok, Samut Prakarn and Nonthaburi province only (and during the company\'s working hours only). Installation in other areas and overtime is subject to extra charge.',
            'TermOfPaymentDeposit'=>'Deposit Payment upon Order Confirmation.',
            'TermOfPaymentBalance'=>(object)[
                'Percent'=>'Balance Payment before delivery day.',
                'Value'=>'The rest of the balance payment will be paid before the delivery date'
            ],
            'BankDetail'=>"Bank Name : kasikornbank\rBranch Name : Central Bangna Beneficiary\rAccount Name : Office intrend Company Limited\rAccount No. : 006-3-59226-9",
            'Note'=>'Price quoted is based on drawing and different in site measurement shall be charged accordingly.',
            'More'=>'We trust that above is acceptable & would like look forward to your favorable reply. Should there be any further queries, please do not hesitate to contact us.',
            'Remark'=>$quotationData->remarkInPI
        ];

        // Initial colmuns text
        $colObj = (object)[
            'SNo'=>'B',
            'Code'=>'C',
            'Desc'=>'F',
            'Qty'=>'G',
            'UnitPrice'=>'H',
            'Discount'=>'J',
            'UnitPrice2'=>'K',
            'Amount'=>'L',
            'Signature'=>'G'
        ];

        // Initial row number
        $rowObj = (object)[
            'Start'=>19,
            'Total'=>23,
            'SpecialDiscount'=>24,
            'SubTotal'=>25,
            'Shipping'=>26,
            'SubTotal2'=>27,
            'Vat'=>28,
            'GrandTotal'=>29,
            'DepositPayment'=>30,
            'BalancePayment'=>31,
        ];

        // style decimal
        // font : bold (false); alignment : HORIZONTAL_RIGHT;
        $itemDecimalStyle = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        // Initial row number control
        $rowCurrent = $rowObj->Start;
        $addRow = 11;

        // Load template excel
        $tempate = IOFactory::load(public_path('TemplateExcel/Template.xlsx'));

        // Set header value 1
        $tempate->getActiveSheet()->setCellValueExplicit('C8',$quotationData->customerName,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C9',$quotationData->customerAddress1,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C10',$quotationData->customerAddress2,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C11',$quotationData->customerAddress3,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C13',$quotationData->customerName,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C14',$quotationData->customerTel,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('C15',$quotationData->customerMail,DataType::TYPE_STRING);

        // Set header value 2
        $tempate->getActiveSheet()->setCellValueExplicit('K8',$quotationData->PI_number,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('K9',date('d/m/Y',strtotime($quotationData->PI_date)),DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('K10',$quotationData->customerTel,DataType::TYPE_STRING);
        //$tempate->getActiveSheet()->setCellValueExplicit('K11',$quotationData->PI_number,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('K12',$quotationData->customerTaxId,DataType::TYPE_STRING);

        // Set header company data
        $tempate->getActiveSheet()->setCellValueExplicit('H1',$companyData->Name,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('H2',$companyData->Address1,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('H3',$companyData->Address2,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('H4','TEL '.$companyData->Tel.' FAX '.$companyData->Fax,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('H5','E-mail : '.$companyData->Email,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('H6','WEBSITE : '.$companyData->Website,DataType::TYPE_STRING);

        // Set Terms & Conditions
        $tempate->getActiveSheet()->setCellValueExplicit('F33',$termsAndconditionsData->DeliveryLeadtime,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('F34',$termsAndconditionsData->DeliveryCondition,DataType::TYPE_STRING);
        if($quotationData->depositPercentOrValue=='percent'){
            $tempate->getActiveSheet()->setCellValueExplicit('F35',$quotationData->depositAmountPercentOrValue.'% '.$termsAndconditionsData->TermOfPaymentDeposit,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit('F36',(100-$quotationData->depositAmountPercentOrValue).'% '.$termsAndconditionsData->TermOfPaymentBalance->Percent,DataType::TYPE_STRING);
        }else{
            $tempate->getActiveSheet()->setCellValueExplicit('F35',number_format($quotationData->depositAmountPercentOrValue,2).' '.$termsAndconditionsData->TermOfPaymentDeposit,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit('F36',$termsAndconditionsData->TermOfPaymentBalance->Value,DataType::TYPE_STRING);
        }

        $tempate->getActiveSheet()->setCellValueExplicit('F37',$termsAndconditionsData->BankDetail,DataType::TYPE_STRING);
        //$tempate->getActiveSheet()->getStyle('F37')->getAlignment()->setWrapText(true);
        $tempate->getActiveSheet()->setCellValueExplicit('F38',$termsAndconditionsData->Note,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('B39',$termsAndconditionsData->More,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('F40',$termsAndconditionsData->Remark,DataType::TYPE_STRING);

        // Set footer signature company

        if($userData->imageSignature!=''){
            // Create image
            $drawing = new Drawing();
            $drawing->setName($userData->name);
            $drawing->setDescription($userData->name);
            $drawing->setPath($signatureData->Image); // path image
            $drawing->setHeight(52);
            // $drawing->setWidth(185);
            $drawing->setOffsetX(2);
            $drawing->setOffsetY(2);
            $drawing->setCoordinates('B45');
            $drawing->setWorksheet($tempate->getActiveSheet());
        }
        $tempate->getActiveSheet()->setCellValueExplicit('B48',$signatureData->FullName,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('B49','Mobile : '.$signatureData->Mobile,DataType::TYPE_STRING);
        $tempate->getActiveSheet()->setCellValueExplicit('B50','E : '.$signatureData->FullName,DataType::TYPE_STRING);

        // Signature customer
        $tempate->getActiveSheet()->setCellValueExplicit('G48',$quotationData->customerName,DataType::TYPE_STRING);

        foreach ($detailData as $key => $value) {

            $rowEarchItem = 0;

            // Add row
            $tempate->getActiveSheet()->insertNewRowBefore($rowCurrent, $addRow);

            //
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->SNo.$rowCurrent,($key+1),DataType::TYPE_NUMERIC);
            // Code and Name
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Code.$rowCurrent,$value->productId,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Code.($rowCurrent+1),$value->productName,DataType::TYPE_STRING);

            // Set style productCode productName
            $tempate->getActiveSheet()->getStyle($colObj->Code.($rowCurrent+1))->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $tempate->getActiveSheet()->getStyle($colObj->Code.($rowCurrent+1))->getAlignment()->setWrapText(true);
            $tempate->getActiveSheet()->mergeCells($colObj->Code.($rowCurrent+1).':'.$colObj->Code.($rowCurrent+2));
            $tempate->getActiveSheet()->getStyle($colObj->Code.$rowCurrent)->getFont()->setBold(true);
            $tempate->getActiveSheet()->getStyle($colObj->Code.($rowCurrent+1))->getFont()->setBold(true);

            // Qty
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Qty.$rowCurrent,$value->amount,DataType::TYPE_NUMERIC);
            $tempate->getActiveSheet()->getStyle($colObj->Qty.$rowCurrent)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Col UnitPrice
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->UnitPrice.$rowCurrent,$value->std_price,DataType::TYPE_NUMERIC);
            $tempate->getActiveSheet()->getStyle($colObj->UnitPrice.$rowCurrent)->getNumberFormat()->setFormatCode('#,##0.00');
            $tempate->getActiveSheet()->getStyle($colObj->UnitPrice.$rowCurrent)->applyFromArray($itemDecimalStyle);

            // Col PercentDiscount
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Discount.$rowCurrent,$value->discountPercentByProduct.'%',DataType::TYPE_STRING);
            $tempate->getActiveSheet()->getStyle($colObj->Discount.$rowCurrent)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Col UnitPrice2
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->UnitPrice2.$rowCurrent,'='.$colObj->UnitPrice.$rowCurrent.'*'.(100 - $value->discountPercentByProduct).'%',DataType::TYPE_FORMULA);
            $tempate->getActiveSheet()->getStyle($colObj->UnitPrice2.$rowCurrent)->getNumberFormat()->setFormatCode('#,##0.00');
            $tempate->getActiveSheet()->getStyle($colObj->UnitPrice2.$rowCurrent)->applyFromArray($itemDecimalStyle);

            // Col Amount
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowCurrent,'='.$colObj->UnitPrice2.$rowCurrent.'*'.$colObj->Qty.$rowCurrent,DataType::TYPE_FORMULA);
            $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowCurrent)->getNumberFormat()->setFormatCode('#,##0.00');
            $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowCurrent)->applyFromArray($itemDecimalStyle);

            if($value->imageName!=''){
                // Create image
                $drawing = new Drawing();
                $drawing->setName($value->productName);
                $drawing->setDescription($value->productName);
                $drawing->setPath(public_path('images/'.$value->imageName)); // path image
                // $drawing->setHeight(140);
                $drawing->setWidth(140);
                $drawing->setOffsetX(4);
                $drawing->setOffsetY(3);
                $drawing->setCoordinates($colObj->Code.($rowCurrent+3));
                $drawing->setWorksheet($tempate->getActiveSheet());
            }


            // set description value
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc1,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc2,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc3,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc4,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc5,DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.($rowCurrent+($rowEarchItem++)),$value->desc6,DataType::TYPE_STRING);

            // Update rowCurrent
            $rowCurrent+=$addRow;
        }

        $count = ($rowCurrent - $rowObj->Start);

        // Update rowObj
        $rowObj->Total += $count;
        $rowObj->SpecialDiscount += $count;
        $rowObj->SubTotal += $count;
        $rowObj->Shipping += $count;
        $rowObj->SubTotal2 += $count;
        $rowObj->Vat += $count;
        $rowObj->GrandTotal += $count;
        $rowObj->DepositPayment += $count;
        $rowObj->BalancePayment += $count;

        // Summary Col Amount
        // Total
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->Total,'=SUM('.$colObj->Amount.$rowObj->Start.':'.$colObj->Amount.$rowCurrent.')',DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Total)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Total)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Special Discount
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->SpecialDiscount,$quotationData->specialDiscount,DataType::TYPE_NUMERIC);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SpecialDiscount)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SpecialDiscount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Sub Total
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->SubTotal,'='.$colObj->Amount.$rowObj->Total.'-'.$colObj->Amount.$rowObj->SpecialDiscount,DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SubTotal)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SubTotal)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Shipping
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->Shipping,$quotationData->shippingCostInPI,DataType::TYPE_NUMERIC);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Shipping)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Shipping)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Sub Total2
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->SubTotal2,'='.$colObj->Amount.$rowObj->SubTotal.'+'.$colObj->Amount.$rowObj->Shipping,DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SubTotal2)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->SubTotal2)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Vat 7%
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->Vat,'='.$colObj->Amount.$rowObj->SubTotal2.'*7%',DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Vat)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->Vat)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Grand Total
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->GrandTotal,'='.$colObj->Amount.$rowObj->SubTotal2.'+'.$colObj->Amount.$rowObj->Vat,DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->GrandTotal)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->GrandTotal)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // DepositPayment
        if($quotationData->depositPercentOrValue=='percent'){
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.$rowObj->DepositPayment,$quotationData->depositAmountPercentOrValue.'% Deposit Payment',DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->DepositPayment,'='.$colObj->Amount.$rowObj->GrandTotal.'*'.$quotationData->depositAmountPercentOrValue.'%',DataType::TYPE_FORMULA);
        }else{
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Desc.$rowObj->DepositPayment,number_format($quotationData->depositAmountPercentOrValue,2).' Deposit Payment',DataType::TYPE_STRING);
            $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->DepositPayment,$quotationData->depositAmountPercentOrValue,DataType::TYPE_NUMERIC);
        }
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->DepositPayment)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->DepositPayment)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // BalancePayment
        $tempate->getActiveSheet()->setCellValueExplicit($colObj->Amount.$rowObj->BalancePayment,'='.$colObj->Amount.$rowObj->GrandTotal.'-'.$colObj->Amount.$rowObj->DepositPayment,DataType::TYPE_FORMULA);
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->BalancePayment)->getNumberFormat()->setFormatCode('#,##0.00');
        $tempate->getActiveSheet()->getStyle($colObj->Amount.$rowObj->BalancePayment)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set filename
        $fileName = 'Quotation-'.date("Ymd").'-'.$quotationData->PI_number;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($tempate, 'Xlsx');
        $writer->save('php://output');
        exit; // importent!
        //return dd($userData);
    }

}
?>
