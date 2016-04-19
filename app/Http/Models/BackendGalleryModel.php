<?php

namespace App\Http\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class BackendGalleryModel extends Model
{
    protected $table = 'tbl_gallery';

    static function getAllGallery($limit=null, $offset=null)
    {
    	if(!empty($offset)):
	    	$image = DB::table('tbl_gallery')
	    				->select('gal_id', 'gal_title', 'gal_status', 'created_at')
	    				->skip($offset)
	    				->take($limit)
	    				->orderBy('gal_id', 'desc')
	    				->get();
	    else:
	    	$image = DB::table('tbl_gallery')
	    				->select('gal_id', 'gal_title', 'gal_status', 'created_at')
	    				->orderBy('gal_id', 'desc')
	    				->paginate($limit);

	    endif;

	    return $image;
    }

    static function getGalleryTitle($gal_id=null)
    {
        if(!empty($gal_id)){
            $gallery = DB::table('tbl_gallery')
                        ->select('gal_id', 'gal_title')
                        ->where('gal_id', '=', $gal_id)
                        ->first();

            return $gallery;
        }
    }

    static function insertGallery($gal_name=null)
    {
        if(!empty($gal_name)){
            $gallery = DB::table('tbl_gallery')
                            ->insert(['gal_title' => $gal_name, 'created_at' => date('Y-m-d H:i:s')]);
            if($gallery == 1)
                return true;                
            else
                return false;
        }
    }

    static function updateGallery($gal_id=null, $gal_name=null)
    {
        if(!empty($gal_id)){
            $gallery = DB::table('tbl_gallery')
                            ->where('gal_id', '=', $gal_id)
                            ->update(['gal_title' => $gal_name]);
            if($gallery == 1)
                return true;                
            else
                return false;
        }
    }

    static function getAllImages($gal_id=null)
    {
        $photo = DB::table('tbl_image')
                    ->select('img_id', 'img_name')
                    ->where('conditional_id', '=', $gal_id)
                    ->orderBy('img_id', 'desc')
                    ->get();

        return $photo;
    }

    static function insertImage($gal_id=null, $img_name=null)
    {
    	if(!empty($img_name)){

    		$image = DB::table('tbl_image')
    					->insert(['img_name' => $img_name, 
                                  'conditional_id' => $gal_id,
    							  'conditional_type' => 3,
    							  'created_at' => date('Y-m-d H:i:s')]);
    		if($image == 1)
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

            $image_path = 'public/gallery/'.$image->img_name;
            $thumb_path = 'public/gallery/thumb/'.$image->img_name;

            @unlink($image_path);
            @unlink($thumb_path);

            $destroy    = DB::table('tbl_image')
                            ->where('img_id', '=', $img_id)
                            ->delete();
            return $destroy;
        }
    }

    static function removeImageGroup($gal_id=null)
    {
        $img_group = DB::table('tbl_image')
                        ->select('img_id')
                        ->where('conditional_id', '=', $gal_id)
                        ->where('conditional_type', '=', 3)
                        ->get();

        if(!empty($img_group)){
            foreach ($img_group as $img) {
                BackendGalleryModel::removeImage($img->img_id);
            }
        }
    }

    static function findGallery($val_find=null)
    {
        if(!empty($val_find)){
            $find_gallery = DB::table('tbl_gallery')
                                ->where('gal_title', 'like', '%'. $val_find .'%')
                                ->orderBy('gal_id', 'desc')
                                ->get();
            if(!empty($find_gallery)){
                return $find_gallery;
            }
        }
    }

    static function uploadPhoto($photo=null, $pathPhoto=null, $pathPhotoThumb=null)
    {
        if(!empty($photo)){
            $image_name = time().".".$photo->getClientOriginalExtension();
            $photo->move($pathPhoto, $image_name);

            $gallery_name = 'g_'.$image_name;

            $origin = Image::make($pathPhoto.'/'.$image_name);
            $origin->resize(900, 900, function ($o){
                $o->aspectRatio();
                $o->upsize();
            });
            $origin->save($pathPhoto.'/'.$gallery_name);

            $thumb  = Image::make($pathPhoto.'/'.$image_name);
            $thumb->resize(400, 400, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            //$image->insert('public/watermark.png');
            $thumb->save($pathPhotoThumb.'/'.$gallery_name);
            @unlink($pathPhoto.'/'.$image_name);

            return $gallery_name;
        }
    }

    static function getLastId()
    {
        $lastid  = DB::table('tbl_image')->max('img_id');

        return $lastid;
    }
}
