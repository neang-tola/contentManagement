<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AdminHelper;
use App\Http\Requests;
use App\Http\Models\BackendArticleModel as Article;
use App\Http\Models\BackendCategoryModel as Category;
use App\Http\Models\BackendSlideModel as Slide;
use App\Http\Models\BackendGalleryModel as Gallery;
use Illuminate\Support\Facades\Input;
use Session;
use DB;
use Auth;
use Hash;

class BackendController extends Controller
{
    protected function getDashboard()
    {
        $data['breadcrumb']     = AdminHelper::breadcrumb();
        $data['num_article']    = Article::where('cnt_id', '=', 4)->count();
        $data['num_slideshow']  = Slide::where('conditional_type', '=', 6)->count();
        $data['num_gallery']    = Gallery::count();
        $data['num_category']   = Category::count();

    	$data['title'] = 'Dashbaord for internal user';

    	return view('admin.dashboard')->with($data);
    }

    public function changePassword()
    {
        $data['title']          = 'Change Password';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.change.password') => 'Change User Password']);
        $data['heading_title']  = 'Change Password Login';

        return view('admin.change_password_form')->with($data);
    }

    public function updatePassword(Request $request)
    {
    	$new_pwd = $request->input('newPassword');
    	if(strlen($new_pwd) >= 6){
    		$reset_pwd = DB::table('users')
    						->where('id', '=', Auth::user()->id)
    						->update(['password' => bcrypt($new_pwd)]);

    		Session::flash('msg', '<div class="alert alert-success" role="alert"><b>Success</b> Change Password have been updated.</div>');
    	}else{
    		Session::flash('msg', '<div class="alert alert-danger" role="alert">Minimum charachtors length 6 for your new password.</div>');
    	}
    	return redirect()->back();
    }

    public function checkCurrentPassword()
    {
    	$current_pwd = Input::get('cur_password');
    	if(Hash::check($current_pwd, Auth::user()->password))
    	{
    		echo 'done';
    	}else{
    		echo 'fail';
    	}
    	
    }
}
