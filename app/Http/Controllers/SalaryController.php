<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;


class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function allEmployee(Request $request){
        $columns = ['id','image', 'name','phone','salary'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Employee::select('*')->orderBy($columns[$column], $dir);

        $count = Employee::count();
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('salary', 'like', '%' . $searchValue . '%');
            });
        }

        if($length!='all'){
            $fetchData = $query->paginate($length);
        }
        else{
            $fetchData = $query->paginate($count);
        }

        //$footer = $fetchData -> sum('id');

        return ['data' => $fetchData, 'draw' => $request->input('draw')];
    }

    public function monthList(){
       $month_list = Salary::groupBy('salary_month') ->get('salary_month');
       return response()->json($month_list);

    }

    public function salaryDetails(Request $request,$id){
        $year = substr($id,0,4);
        $month = substr($id,4);
        $columns = ['id','image', 'name','phone','salary'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Salary::where('salary_year',$year)
            ->where('salary_month',$month)
            ->join('employees','employees.category_id','categories.id')
            ->select('categories.category_name','products.*')
            ->orderBy($columns[$column], $dir);

        $count = Salary::count();
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('amount', 'like', '%' . $searchValue . '%')
                    ->orWhere('salary_month', 'like', '%' . $searchValue . '%');
            });
        }

        if($length!='all'){
            $fetchData = $query->paginate($length);
        }
        else{
            $fetchData = $query->paginate($count);
        }

        //$footer = $fetchData -> sum('id');

        return ['data' => $fetchData, 'draw' => $request->input('draw')];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'salary_month'    => 'required',
            'salary_date'    => 'required',
        ]);

        $salary_check = Salary::where('employee_id',$request->employee_id)
            ->where('salary_year',date('Y'))
            ->where('salary_month',$request->salary_month)->first();

        if($salary_check){
            return response()->json(false);
        }
        else{
            $data = new Salary();
            $data -> employee_id = $request -> employee_id;
            $data -> salary_month = $request -> salary_month;
            $data -> salary_date = $request -> salary_date;
            $data -> salary_year = date('Y');
            $data -> amount = $request -> salary;

            $data -> save();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
