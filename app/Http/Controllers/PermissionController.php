<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Products;
use App\Transactions;


class PermissionController extends Controller
{
    public function isSuper($role) {
        if($role == 'super'){
            return true;
        }
        return false;
    }

    public function isMerchant($role){
    	if($role == 'merchant'){
    		return true;
    	}
    	return false;
    }

    public function isCustomer($role){
    	if($role == 'customer'){
    		return true;
    	}
    	return false;
    }

    // Product Permissions
    public function addProducts($role){
    	if(Self::isSuper($role) || Self::isMerchant($role)){
    		return true;
    	}
    	return false;
    }

    public function ownerProduct($role, $product_id, $merchant_id){
    	$product = Products::find($product_id);
    	if(Self::isMerchant($role) && $product->merchant_id == $merchant_id){
    		return true;
    	}
    	return false;
    }

    // Transaction Permissions
    public function merchantTransaction($role, $transaction_id, $merchant_id){
    	$transaction = Transactions::find($transaction_id);
    	if(Self::isMerchant($role) && $transaction->merchant_id == $merchant_id){
    		return true;
    	}
    	return false;
    }

    public function customerTransaction($role, $id, $user_id){
    	$transaction = Transactions::find($id);
    	if(Self::isCustomer($role) && $user_id == $transaction->customer_id){
    		return true;
    	}
    	return false;
    }

    // User Permissions
    public function usersPermission($username, $user_id){
        $user = User::find($user_id);
        $owner = User::where('username', $username)->first();
        if($user != null || $owner != null){
            if(Self::isSuper($owner->role)){
                if($user->_id != $owner->_id){
                    return true;
                }
            } else if(Self::isCustomer($user->role)){
                if(Self::addProducts($owner->role) || $user->_id == $owner->_id){
                    return true;
                }
            } else if(Self::isMerchant($user->role)){
                if($user->_id == $owner->_id){
                    return true;
                }
            }
            return false;
        }
        return abort(404);

    }
}
