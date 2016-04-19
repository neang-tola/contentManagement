<?php

namespace App\Http\Models;

use Hash;
use Session;
use Illuminate\Database\Eloquent\Model;

class AuthModel extends Model
{
    protected $table = 'tbl_backend_user';

    public static function checkUser($user_name=null, $pass=null)
    {
    	$msg_status = '';
    	$user = AuthModel::where('user_name', $user_name)->first();
    	
		if(!empty($user)){
			if(Hash::check($pass, $user->user_pwd)):
				$user_ses   = array('id'=>$user->user_id,'name'=>$user_name, 'position' => $user->user_status, 'bknUser' => 'logged_bkn');
				Session::put($user_ses);
				$msg_status = 'logged';
			else:
				$msg_status = 'Your password incorrect';
			endif;
		}else{
			$msg_status     = 'Your account is not member';
		}

		return $msg_status;
    }
}
