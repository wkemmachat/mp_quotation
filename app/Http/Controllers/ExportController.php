<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportQuotation;

class ExportController extends Controller
{
    //
    public function Index($pi_number)
    {
        return (new ExportQuotation)->index($pi_number);
    }

}
