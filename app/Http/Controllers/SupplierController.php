<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Supplier::all());
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
            'phone'    => 'required',
        ]);

        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/supplier/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        else{
            $image_url='image/no_image.png';
        }

        $data = new Supplier();

        $data -> name = $request -> name;
        $data -> email = $request -> email;
        $data -> address = $request -> address;
        $data -> shop_name = $request -> shop_name;
        $data -> phone = $request -> phone;
        $data -> image = $image_url;

        $data -> save();
    }

    public function allSuppliers(Request $request){
        $columns = ['id', 'image', 'name','phone','email','shop_name','address'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Supplier::select('*')->orderBy($columns[$column], $dir);

        $count = Supplier::count();
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('id', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_name', 'like', '%' . $searchValue . '%');
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
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'    => 'required|string',
            'email'    => 'required|email',
            'phone'    => 'required',
        ]);

        if($request->image != $supplier->image && $request->image != null){
            unlink($supplier->image);
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/supplier/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        elseif($request->image == null ){
            $image_url='image/no_image.png';
        }
        else{
            $image_url=$supplier->image;
        }

        $supplier->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'image'=>$image_url,
            'phone'=>$request->phone,
            'shop_name'=>$request->shop_name,
            'address'=>$request->address,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier->image != 'image/no_image.png'){
            unlink($supplier->image);
            $supplier->delete();
        }
        else{
            $supplier->delete();
        }
    }
}
