<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Employee::all());
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
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'    => 'required|email',
            'join_date'    => 'required',
            'phone'    => 'required',
        ]);

        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/employee/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        else{
            $image_url='image/no_image.png';
        }


        $data = new Employee();

        $data -> name = $request -> name;
        $data -> email = $request -> email;
        $data -> address = $request -> address;
        $data -> salary = $request -> salary;
        $data -> phone = $request -> phone;
        $data -> join_date = $request -> join_date;
        $data -> nid = $request -> nid;
        $data -> image = $image_url;


        $data -> save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'    => 'required|email',
            'join_date'    => 'required',
            'phone'    => 'required',
        ]);

        if($request->image != $employee->image && $request->image != null){
            unlink($employee->image);
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/employees/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        elseif($request->image == null ){
            $image_url='image/no_image.png';
        }
        else{
            $image_url=$employee->image;
        }

        $employee->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'salary'=>$request->salary,
            'image'=>$image_url,
            'phone'=>$request->phone,
            'join_date'=>$request->join_date,
            'address'=>$request->address,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if ($employee->image != 'image/no_image.png'){
            unlink($employee->image);
            $employee->delete();
        }
        else{
            $employee->delete();
        }
    }
}
