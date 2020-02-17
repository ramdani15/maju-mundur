<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Points;
use App\Rewards;

class RewardController extends Controller
{
    public function index(Request $request){
    	return Rewards::all();
    }

    public function buy(Request $request, $id){
    	if(app(PermissionController::class)->isCustomer($request->user()->role)){
    		$reward = Rewards::find($id);
    		$point = Points::where('customer_id', $request->user()->_id)->first();
    		
    		if($point->poin < $reward->poin){
    			return response()->json(["status" => 'Point not Enough'], 400);		
    		}

    		// update point
    		Points::where('customer_id', $request->user()->_id)->update([
    			"poin" => $point->poin - $reward->poin,
    		]);

    		return Points::where('customer_id', $request->user()->_id)->get();
    	}
    	return response()->json(["status" => 'You don\'t have permission'], 403);
    }
}
