<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Products;
use App\Transactions;
use App\Points;

class PointController extends Controller
{
    public function index(Request $request){
    	if(app(PermissionController::class)->isSuper($request->user()->role)){
    		return Points::all();
    	} else if (app(PermissionController::class)->isCustomer($request->user()->role)) {
    		return Points::where('customer_id', $request->user()->_id)->get();
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }
}
