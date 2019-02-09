<?php

namespace App\Http\Controllers;

use App\KpiOutput;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Kamaln7\Toastr\Facades\Toastr;
use Gate;
use Auth;
use App\Exports\ExportKPI;
use Maatwebsite\Excel\Facades\Excel;

class KpiOutputController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $kpi_type = $id;
        // dd($id);
        $roleSelected = Role::where('title','=',$kpi_type)->first();
        // dd($roleSelected);
        $usersHaveRoleArray = $roleSelected->users;

        $kpi_outputs = KpiOutput::where('role_id','=',$roleSelected->id)->orderBy('updated_at', 'desc')->paginate(10);


        // foreach ($usersHaveRoleArray as $user){
        //     if($user->user_type)
        // }

        // foreach($usersHaveRoleArray as $userInLoop){
        //     dd($userInLoop->name);
        // }

        return view('kpi.index',compact('roleSelected','usersHaveRoleArray','kpi_outputs'));
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
    public function store(Request $request,$id)
    {
        // dd($id);

        $request->validate([
            'date_input' => 'required',
            'user_id' => 'required',
            'total_amount' => 'required',
        ]);

        $kpi_type = $id;
        $roleSelected = Role::where('title','=',$kpi_type)->first();
        $usersHaveRoleArray = $roleSelected->users;

        // dd($request->date_input);

        try {
            $date = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
            // check the format from datepicker
            // dd($date);
        }
        catch (\Exception $e) {

            $message = "Error date input";
            Toastr::error($message, $title = "Error Action", $options = []);

            return view('kpi.index',compact('roleSelected','usersHaveRoleArray'));
        }// end catch

        if(strlen(trim($request->total_defect))==0){
            $request->total_defect = 0;
        }
        if(strlen(trim($request->remark))==0){
            $request->remark = "";
        }

        // save
        $kpiToBeSave = new KpiOutput();
        $kpiToBeSave->input_date        = Carbon::createFromFormat('d-m-Y', $request->date_input)->format('Y-m-d');
        $kpiToBeSave->user_key_in_id    = Auth::user()->id;
        $kpiToBeSave->role_id           = $roleSelected->id;
        $kpiToBeSave->user_id           = $request->user_id;
        $kpiToBeSave->total_amount      = $request->total_amount;
        $kpiToBeSave->total_defect      = $request->total_defect;
        $kpiToBeSave->remark            = $request->remark;

        $kpiToBeSave->save();

        $kpi_outputs = KpiOutput::where('role_id','=',$roleSelected->id)->orderBy('updated_at', 'desc')->paginate(10);

        $message = "Successfully add data";
        Toastr::success($message, $title = "Successfully Action", $options = []);
        return view('kpi.index',compact('roleSelected','usersHaveRoleArray','kpi_outputs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function show(KpiOutput $kpiOutput)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function edit(KpiOutput $kpiOutput)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KpiOutput $kpiOutput)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KpiOutput  $kpiOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        // dd($id);
        // dd($request->all());
        $kpiToDelete = KpiOutput::findOrFail($request->kpi_delete_id);
        $kpiToDelete->delete();

        $kpi_type = $id;
        $roleSelected = Role::where('title','=',$kpi_type)->first();
        $usersHaveRoleArray = $roleSelected->users;
        $kpi_outputs = KpiOutput::where('role_id','=',$roleSelected->id)->orderBy('updated_at', 'desc')->paginate(10);

        $message = "Successfully delete data";
        Toastr::success($message, $title = "Successfully Action", $options = []);

        return view('kpi.index',compact('roleSelected','usersHaveRoleArray','kpi_outputs'));
    }


    public function exportKPI(Request $request)
    {
        return Excel::download(new ExportKPI($request), 'kpi.xlsx');
    }
}
