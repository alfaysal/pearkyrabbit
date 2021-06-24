<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use DataTables;
use Response;

class EmployeeController extends Controller
{
    public function index()
    {
    	return view('back-end.home');
    }

    public function EmployeeStore(Request $request)
    {
    	$employee = new Employee();

    	$employee->name = $request->name;	
    	$employee->address = $request->address;	
    	$employee->phone = $request->phone;	

    	$employee->save();	

        return ['success'=>true];

    }

    public function DatatableData()
    {
    	$employees = Employee::all();

    	return DataTables::of($employees)
    						->addColumn('action',function($row){
    							return "<a href='#' class='btn btn-sm btn-primary' id='edit' data-id='".$row->id."'>edit</a> <a href='#' class='btn btn-sm btn-danger' id='delete' data-id='".$row->id."'>delete</a>";
    						})
    						->addIndexColumn()
    						->make(true);
    }


    public function EditData(Request $request)
    {
    	$employee = Employee::find($request->id);

    	return Response::json(array('data'=>$employee));
    }

    public function UpdateEmployee(Request $request)
    {
    	$employee = Employee::find($request->id);

    	$employee->name = $request->name;
    	$employee->address = $request->address;
    	$employee->phone = $request->phone;

    	$employee->save();

        return ['success'=>true];

    }


    public function DeleteEmployee(Request $request)
    {

    	$employee = Employee::find($request->id);
    	
    	$employee->delete();

        return ['success'=>true];

    }
}
