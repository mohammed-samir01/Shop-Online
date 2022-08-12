<?php

namespace App\Http\Controllers\api\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\traits\generalTrait;

class productController extends Controller
{
    use generalTrait;
    public function index(Request $request)
    {
        $lang = $this->getCurrentLang();
        $lang == 'ar' ? $lang  = '_ar' : $lang  = '';
        $products = Product::select('id','name'.$lang.' AS name','details'.$lang.' AS details','sub_cat_id')
        ->With(['sub_cat'=>function($sub_cat) use ($lang) {
            $sub_cat->select('id','name'.$lang.' AS name','image');
        }])
        ->paginate(PAGINATE);
        // $products = Product::select('id','name'.$lang.' AS name','details'.$lang.' AS details')->with('sub_cat')->get();
        return $this->returnData('products',$products);
    }

    public function store(Request $request)
    {
        $lang = $this->getCurrentLang();
        $rules = [
            'name'=>'required',
            'price'=>'required|numeric|min:1',
            'code'=>'required',
            'stock'=>'required|min:1|numeric',
            'details'=>'required|string',
            'image'=>'required|image|mimes:png,jpg,jpeg|max:1024',
            'sub_cat_id'=>'required|numeric|exists:sub_cat,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return $this->returnValidationError($validator);
        }
        $photoName = $this->uploadPhoto($request->image,'products');
        $insertData = $request->all();
        $insertData['image'] = $photoName;
        Product::insert($insertData);
        return $this->returnSuccessMessage('data has been successfully inserted');

    }

    public function update(Request $request)
    {
        $rules = [
            'id'=>'required|exists:products|numeric|min:1',
            'name'=>'required',
            'price'=>'required|numeric|min:1',
            'code'=>'required',
            'stock'=>'required|min:1|numeric',
            'details'=>'required|string',
            'image'=>'image|mimes:png,jpg,jpeg|max:1024',
            'sub_cat_id'=>'required|numeric|exists:sub_cat,id'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $this->returnValidationError($validator);
        }
        $id = $request->id;
        $updatedData = $request->except('id');
          if($request->has('image')){
            $photoName = $this->uploadPhoto($request->image,'products');
            $updatedData['image'] = $photoName;
        }
        Product::where('id','=',$id)->update($updatedData);
        $pro = Product::find($id);
        return $this->returnData('product',$pro);

    }

    public function delete($id)
    {
        $rules = [
            'id'=>'required|exists:products|numeric|min:1'
        ];
        $validator = Validator::make(['id'=>$id],$rules);
        if($validator->fails()){
           return $this->returnValidationError($validator);
        }

        Product::destroy($id);
        return $this->returnSuccessMessage('Successfully deleted');


    }
}
