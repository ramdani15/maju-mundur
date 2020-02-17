<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Products;
use App\Transactions;

class ProductController extends Controller
{
    public function index(Request $request){
    	return Products::all();
    }

    public function store(Request $request){
    	if(app(PermissionController::class)->isMerchant($request->user()->role)){
    		$validator = Validator::make($request->all(), [
	            'name' => 'required|string|max:255',
	            'price' => 'required|integer',
	            'stock' => 'required|integer',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors()->toJson(), 400);
	        }

	        // add product
	        $product = Products::create([
	        	"name" => $request->name,
	        	"price" => $request->price,
	        	"stock" => $request->stock,
	        	"merchant_id" => $request->user()->_id,
	        ]);

	        return $product;
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }

    public function show(Request $request, $id){
    	return Products::find($id);
    }

    public function edit(Request $request, $id){
    	if(app(PermissionController::class)->ownerProduct($request->user()->role, $id, $request->user()->_id)){
    		$validator = Validator::make($request->all(), [
	            'name' => 'required|string|max:255',
	            'price' => 'required|integer',
	            'stock' => 'required|integer',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors()->toJson(), 400);
	        }

	        // update product
	        Products::where('_id', $id)->update([
	        	"name" => $request->name,
	        	"price" => $request->price,
	        	"stock" => $request->stock,
	        ]);

	        return Products::find($id);
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }

    public function destroy(Request $request, $id){
    	if(app(PermissionController::class)->ownerProduct($request->user()->role, $id, $request->user()->_id)){
    		// delete product
	        Products::destroy($id);

	        return response()->json(["status" => 'Deleted'], 200);
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }

    public function buy(Request $request, $id){
    	if(app(PermissionController::class)->isCustomer($request->user()->role)){
    		$validator = Validator::make($request->all(), [
	            'amount' => 'required|integer',
	            'paid' => 'required|integer',
	        ]);

	        if($validator->fails()){
	            return response()->json($validator->errors()->toJson(), 400);
	        }

	        // check product price
	        $product = Products::find($id);
	        $paid = $product->price * $request->amount;
	        if($request->paid < $paid){
	        	return response()->json(["status" => 'Less Money'], 400);
	        }
	        $refund = $request->paid - $paid;

	        // check product stock
	        if($product->stock < $request->amount){
	        	return response()->json(["status" => 'Stock not Enough'], 400);
	        }
	        
			// add transaction
	        $transaction = Transactions::create([
	        	'customer_id' => $request->user()->_id,
	        	'merchant_id' => $product->merchant_id,
	        	'product_id' => $id,
	        	'amount' => $request->amount,
	        	'paid' => $request->paid,
	        	'refund' => $refund,
	        	'success' => false,
	        ]);

	        // update stock product
	        Products::where('_id', $product->_id)->update([
	        	"stock" => $product->stock - $request->amount,
	        ]);

	        return $transaction;

    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }
}
