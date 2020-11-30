<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
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
            'category_id'    => 'required',
            'product_name'    => 'required|string',
            'product_code'    => 'required',
        ]);

        if($request->image){
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/product/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        else{
            $image_url='image/no_image.png';
        }

        $data = new Product();

        $data -> category_id = $request -> category_id;
        $data -> product_name = $request -> product_name;
        $data -> product_code = $request -> product_code;
        $data -> root = $request -> root;
        $data -> buying_price = $request -> buying_price;
        $data -> selling_price = $request -> selling_price;
        $data -> supplier_id = $request -> supplier_id;
        $data -> buying_date = $request -> buying_date;
        $data -> product_quantity = $request -> product_quantity;
        $data -> details = $request -> details;
        $data -> image = $image_url;

        $data -> save();
    }

    public function allProducts(Request $request){
        $columns = ['id','image','product_name', 'category_id'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $count = Product::count();

        $query = DB::table('products')
            ->join('categories','products.category_id','categories.id')
            ->select('categories.category_name','products.*')
            ->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('products.id', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('category_name', 'like', '%' . $searchValue . '%');
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = DB::table('products')
            ->where('products.id',$product->id)
            ->join('categories','products.category_id','categories.id')
            ->join('suppliers','products.supplier_id','suppliers.id')
            ->select('categories.category_name','suppliers.name as s_name','products.*')
            ->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'    => 'required',
            'product_name'    => 'required|string',
            'product_code'    => 'required',
        ]);

        if($request->image != $product->image && $request->image != null){
            unlink($product->image);
            $position = strpos($request->image,';');
            $sub = substr($request->image,0,$position);
            $ext = explode('/',$sub)[1];
            $image = time().'.'.$ext;
            $img = Image::make($request->image);
            $upload_path = 'image/product/';
            $image_url = $upload_path.$image;
            $img->save($image_url);
        }
        elseif($request->image == null ){
            $image_url='image/no_image.png';
        }
        else{
            $image_url=$product->image;
        }

        $product->update([
            'category_id'=>$request->category_id,
            'product_name'=>$request->product_name,
            'product_code'=>$request->product_code,
            'root'=>$request->root,
            'buying_price'=>$request->buying_price,
            'selling_price'=>$request->selling_price,
            'supplier_id'=>$request->supplier_id,
            'buying_date'=>$request->buying_date,
            'product_quantity'=>$request->product_quantity,
            'details'=>$request->details,
            'image'=>$image_url,

        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image != 'image/no_image.png'){
            unlink($product->image);
            $product->delete();
        }
        else{
            $product->delete();
        }
    }
}
