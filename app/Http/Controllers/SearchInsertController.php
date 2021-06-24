<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeDetails;
use Response;

class SearchInsertController extends Controller
{
    public function index()
    {
    	return view('back-end.search_insert_index');
    }

    public function SearchEmployee(Request $request)
    {
    	$result = Employee::where('designation','like', '%'.$request->designation.'%')->get();

    	return json_encode($result);
    	
    }


    public function getEmployee(Request $request)
    {
    	$employee = Employee::find($request->id);

    	return json_encode($employee);
    }

    public function finalSubmit(Request $request)
    {
    	if(count($request->id) > 0){

            foreach ($request->id as $items => $value) {
                
                $employee_details = new EmployeeDetails();

                $employee_details->employee_id = $request->id[$items];
                $employee_details->address = $request->address[$items];
                $employee_details->phone = $request->phone[$items];
                $employee_details->email = $request->email[$items];

                $employee_details->save();
            }
        }

        return ['success'=>true];
        

    }
}
