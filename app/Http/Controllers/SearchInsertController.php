<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
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
}
