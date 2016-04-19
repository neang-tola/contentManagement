<?php

namespace App\Http\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class BackendSlideModel extends Model
{
    protected $table = 'tbl_image';

    static function getAllSlide($limit=null, $offset=null)
    {
    	if(!empty($offset)):
	    	$image = DB::table('tbl_image')
	    				->select('img_id', 'img_name', 'img_content', 'img_status', 'created_at', 'img_sequense')
	    				->where('conditional_type', '=', 6)
	    				->skip($offset)
	    				->take($limit)
	    				->orderBy('img_sequense')
	    				->get();
	    else:
	    	$image = DB::table('tbl_image')
	    				->select('img_id', 'img_name', 'img_content', 'img_status', 'created_at', 'img_sequense')
	    				->where('conditional_type', '=', 6)
	    				->orderBy('img_sequense')
	    				->paginate($limit);

	    endif;

	    return $image;
    }

    static function insertImage($img_name=null)
    {
    	if(!empty($img_name)){
    		$max_order = BackendSlideModel::max('img_sequense');

    		$slide = DB::table('tbl_image')
    					->insert(['img_name' => $img_name, 
    							  'conditional_type' => 6, 
    							  'img_sequense' => $max_order +1, 
    							  'img_status' => 1,
    							  'created_at' => date('Y-m-d H:i:s')]);
    		if($slide == 1)
    			return true;
    		else
    			return false;
    	}
    }

    static function removeImage($img_id=null)
    {
        if(!empty($img_id)){
            $image = DB::table('tbl_image')
                        ->select('img_name')
                        ->where('img_id', '=', $img_id)
                        ->first();

            $image_path = 'public/slideshows/'.$image->img_name;
            @unlink($image_path);
        }
    }

    static function updateOrder($id=null, $order_val=null)
    {
        if(!empty($id)){
            $update_order = DB::table('tbl_image')
                                ->where('img_id', '=', $id)
                                ->update(['img_sequense' => $order_val]);
            if($update_order == 1){
                return true;
            }else{
                return false;
            }
        }
    }

    static function uploadSlideShow($image=null, $pathImage=null)
    {
        if(!empty($image)){

              $extension = $image->getClientOriginalExtension(); // getting image extension
              $fileName  = rand(11111111, 99999999).'.'.$extension; // renameing image
              $image->move($pathImage, $fileName); // uploading file to given path

              $new_slide = 's_'.$fileName;
              
              $img_slide = Image::make($pathImage.'/'.$fileName);
              $img_slide->resize(1200, 750, function($r){
                    $r->aspectRatio();
                    $r->upsize();
              });
              $img_slide->save($pathImage.'/'.$new_slide);

              @unlink($pathImage.'/'.$fileName);

              return $new_slide;
        }
    }
}
