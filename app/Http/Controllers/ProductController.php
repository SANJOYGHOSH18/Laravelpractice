<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        //$products = Product::latest()->get();
        $products = Product::get();

        if ($request->ajax())
         {

            // $query = $request->get('query');

            // if($query != '')
            // {
                // $data = DB::table('Product')
                //    ->where('prod_name', 'like', '%'.$query.'%')
                // ->orWhere('prod_price', 'like', '%'.$query.'%')
                // ->orWhere('prod_variant', 'like', '%'.$query.'%')
                // ->orWhere('item_no', 'like', '%'.$query.'%')
                // ->orWhere('prod_image', 'like', '%'.$query.'%')
                // ->orderBy('id', 'desc')->get();

                //or

                // $data = Product::where('prod_name', 'like', '%'.$query.'%')
                // ->orWhere('prod_price', 'like', '%'.$query.'%')
                // ->orWhere('prod_variant', 'like', '%'.$query.'%')
                // ->orWhere('item_no', 'like', '%'.$query.'%')
                // ->orWhere('prod_image', 'like', '%'.$query.'%')
                // ->orderBy('id', 'desc')->get();

           // }
            //else
           // {
                // $data = DB::table('tbl_customer')
                // ->orderBy('CustomerID', 'desc')
                // ->get();


                 //$data = Product::latest()->get();
                 $data = Product::get();
           // }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('product',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[

            'prod_name'=>'required',
            'prod_price'=>'required',
            'prod_variant'=>'required',
            'item_no'=>'required',
            'prod_description'=>'required'
        ],
        [
           'prod_name.required'=> 'Product name is Required', // custom message
           'prod_price.required'=> 'Product price is Required', // custom message
           'prod_variant.required'=> 'Product variant is Required', // custom message
           'item_no.required'=> 'Item no is Required', // custom message
           'prod_description.required'=> 'Product description is Required', // custom message


       ]);


        // $input = $request->all();

        if($validator->fails())
        {
            //return response()->json(['error'=>$validator->errors()->toArray()]);
             //return response()->json(['error'=>$validator->errors()->all()]);
            return Response::json(['status'=>0, 'errors' => $validator->errors()->toArray()]);
        }
    else{
            Product::updateOrCreate(['id' => $request->id],
            ['cid' => 1, 'parent_id' => 2 ,'prod_name' => $request->prod_name, 'prod_price' => $request->prod_price, 'prod_variant' => $request->prod_variant,'item_no' => $request->item_no ,'prod_image' => ' ' , 'prod_description' => $request->prod_description ] );

           // Session::flash('success', __('Product saved successfully.'));
            //return response()->json(['status'=>1 ,'success'=> true]);
            return response()->json(['success'=>'Product saved successfully.']);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Product::find($id);
        return response()->json($products);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
