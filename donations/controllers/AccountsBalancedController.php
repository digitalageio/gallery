<?php 
class AccountBalancedController extends BaseController {


    public function permissionCheck($level){

        $user = Auth::user();
        switch($level){
            case 'admin':
                $permissions = Permissions::where('user_id','=',$user->id)
                                        ->where('is_admin','=','1')
                                        ->first();
            break;
            case 'manager':
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1');
                                         })->first();
            break;
            case 'donor':
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1')
                                             ->orWhere('is_donor','=','1');
                                         })->first();
            break;
            default:
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1')
                                             ->orWhere('is_donor','=','1');
                                         })->first();               
            break;
        }
        $account = Account::where('id','=',$permissions->account_id)->first();
        if($account->count()){
            return $account;
        }
        return false;
    }


    public function postSaveBankAccount(){

    }

} //end class
