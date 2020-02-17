<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Products;
use App\Transactions;
use App\Points;

class TransactionController extends Controller
{
    public function index(Request $request){
    	if(app(PermissionController::class)->isSuper($request->user()->role)){
    		return Transactions::all();
    	} else if(app(PermissionController::class)->isMerchant($request->user()->role)){
    		return Transactions::where('merchant_id', $request->user()->_id)->get();
    	} else {
    		return Transactions::where('customer_id', $request->user()->_id)->get();
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }

    public function show(Request $request, $id) {
    	if(app(PermissionController::class)->isSuper($request->user()->role) ||
    		(app(PermissionController::class)->merchantTransaction($request->user()->role, $id, $request->user()->_id)) ||
    		(app(PermissionController::class)->customerTransaction($request->user()->role, $id, $request->user()->_id))){
    		return Transactions::find($id);
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);	
    }

    public function approve(Request $request, $id){
    	if(app(PermissionController::class)->merchantTransaction($request->user()->role, $id, $request->user()->_id)){
    		$transaction = Transactions::find($id);

    		// check status transaction
    		if($transaction->success){
    			return response()->json(['status' => 'Transaction Already Approved'], 400);
    		}

    		// add point
    		$point = Points::where('customer_id', $transaction->customer_id)->get();
    		if($point->isEmpty()){
    			Points::create([
    				"poin" => 1,
    				"customer_id" => $transaction->customer_id,
    			]);
    		} else {
    			$point = Points::where('customer_id', $transaction->customer_id)->first();
    			Points::where('customer_id', $transaction->customer_id)->update([
    				"poin" => $point->poin + 1,
    			]);
    		}

    		// update transaction
    		Transactions::where('_id', $id)->update([
    			'success' => true,
    		]);

    		return Transactions::find($id);
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }
}
