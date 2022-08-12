<?php

namespace App\Http\Controllers\admin\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\traits\generalTrait;
use File;
class productsController extends Controller
{
    use generalTrait;
    public function index()
    {
        // $products = DB::select('select * from products');     //Query builder
        $products = DB::table('products')->select('products.*')->get();
        return view ('admin.en.products.all',compact('products'));
    }
    public function create()
    {
        $subs = DB::table('sub_cat')->select('*')->get();
        return view('admin.en.products.create',compact('subs'));
    }
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|string',
            'code'=>'required',
            'price'=>'required|numeric|min:1',
            'stock'=>'required|numeric|min:1|max:100',
            'details'=>'required',
            'sub_cat_id'=>'required|numeric|exists:sub_cat,id',
            'image'=>'required|image|mimes:png,jpg,jpeg|max:1024'

        ];
        $request->validate($rules);
        $singleProduct = $request->except('_token');
        $photoName = $this->uploadPhoto($request->image,'products');
        $singleProduct['image'] =$photoName;
        // return $singleProduct;
        DB::table('products')->insert($singleProduct);
        return redirect()->back()->with('Success', 'The Product has been inserted suuccessfully');
    }
    public function destroy($id)
    {
        $singleProduct = DB::table('products')->where('id','=',$id)->first();
        if($singleProduct){
            $photoPath = public_path("uploads\products\\".$singleProduct->image);
            if(File::exists($photoPath)){
                File::delete($photoPath);
                // unlink($photoPath);
            }
            DB::table('products')->where('id','=',$id)->delete();
            return redirect()->back()->with('Success','The Product has been successfuly deleted with id :'.$id);    
        }else{
            return redirect()->back()->with('Error','No Product has This ID :'.$id);    
        }
    }
    public function edit($id)
    {
        $check = DB::table('products')->where('id','=',$id)->exists();
        if($check){
            $product = DB::table('products')->where('id','=',$id)->first();
            $subs = DB::table('sub_cat')->select('*')->get();
            return view('admin.en.products.edit',compact('product','subs'));
        }else{
            return abort(404);
        }
    }
    public function update(Request $request)
    {
        $rules = [

            'id'=>'required|numeric|exists:products,id',            //anthor solution
            'name'=>'required|string',
            'code'=>'required',
            'price'=>'required|numeric|min:1',
            'stock'=>'required|numeric|min:1|max:100',
            'details'=>'required',
            'sub_cat_id'=>'required|numeric|exists:sub_cat,id',
            'image'=>'nullable|image|mimes:png,jpg,jpeg|max:1024'
        ];
        $request->validate($rules);
        // return $request->all();
        $updateData = $request->except('_token','_method','id');
        if($request->has('image')){
            $imageName= $this->uploadPhoto($request->image,'products');
            $updateData['image'] = $imageName;
        }
        DB::table('products')->where('id','=',$request->id)->update($updateData);
        return redirect('admin/products/all')->with('Success','Data Updted Successfuly');
    }
}
