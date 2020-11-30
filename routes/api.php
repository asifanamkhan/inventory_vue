<?php


Route::group([

    'middleware' => 'api',
    //'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('employee','EmployeeController');
Route::get('allEmployee', 'EmployeeController@allEmployee');

Route::apiResource('supplier','SupplierController');
Route::get('allSuppliers', 'SupplierController@allSuppliers');

Route::apiResource('category','CategoryController');
Route::get('allCategories', 'CategoryController@allCategories');

Route::apiResource('product','ProductController');
Route::get('allProducts', 'ProductController@allProducts');

Route::apiResource('expense','ExpenseController');
Route::get('allExpenses', 'ExpenseController@allExpenses');

Route::apiResource('salary','SalaryController');
Route::get('employeeListSalary', 'SalaryController@allEmployee');
Route::get('monthList', 'SalaryController@monthList');
Route::get('salaryDetails/{id}', 'SalaryController@salaryDetails');
