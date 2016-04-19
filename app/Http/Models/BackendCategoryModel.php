<?php

namespace App\Http\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class BackendCategoryModel extends Model
{
    protected $table = 'tbl_category';

    static function getAllCategory($limit=null, $offset=null)
    {
    	if(!empty($offset)):
	    	$category = DB::table('tbl_category')
	    				->select('cat_id', 'cat_title', 'cat_status', 'cat_front')
	    				->skip($offset)
	    				->take($limit)
	    				->orderBy('cat_sequense')
	    				->get();
	    else:
	    	$category = DB::table('tbl_category')
	    				->select('cat_id', 'cat_title', 'cat_status', 'cat_front')
	    				->orderBy('cat_sequense')
	    				->paginate($limit);

	    endif;

	    return $category;
    }

    static function getAllSubCategory($main_id=null, $limit=null, $offset=null)
    {
        if(!empty($main_id))
        {
            if(!empty($offset)):
                $category = DB::table('tbl_category_detail')
                            ->select('ctd_id', 'ctd_title', 'ctd_status', 'created_at')
                            ->where('cat_id', '=', $main_id)
                            ->skip($offset)
                            ->take($limit)
                            ->orderBy('ctd_sequense')
                            ->get();
            else:
                $category = DB::table('tbl_category_detail')
                            ->select('ctd_id', 'ctd_title', 'ctd_status', 'created_at')
                            ->where('cat_id', '=', $main_id)
                            ->orderBy('ctd_sequense')
                            ->paginate($limit);

            endif;

            return $category;
        }
    }

    static function findCategory($keyword=null)
    {
        $category = DB::table('tbl_category')
                        ->select('cat_id', 'cat_title', 'cat_status', 'cat_front')
                        ->where('cat_title', 'like', '%'.$keyword.'%')
                        ->orderBy('cat_sequense')
                        ->get();

        return $category;
    }

    static function findSubCategory($main_id=null, $keyword=null)
    {
        if(!empty($main_id))
        {
            $category = DB::table('tbl_category_detail')
                            ->select('ctd_id', 'ctd_title', 'ctd_status', 'created_at')
                            ->where('cat_id', '=', $main_id)
                            ->where('ctd_title', 'like', '%'.$keyword.'%')
                            ->orderBy('ctd_sequense')
                            ->get();

            return $category;
        }
    }

    static function getCategoryTitle($aid=null)
    {
        if(!empty($aid)){
            $title_cat = DB::table('tbl_language as lng')
                            ->leftJoin('tbl_category_translate as ct', function($join) use ($aid)
                            {
                                $join->on('lng.lang_id', '=', 'ct.lang_id');
                                $join->on('ct.cat_id', '=', DB::raw($aid));
                            })
                            ->select('lng.lang_id', 'ct.catt_id', 'ct.catt_title', 'ct.catt_des', 'lng.lang_title')
                            ->where('lng.lang_status', '=', 1)
                            ->get();

        }else{
            $title_cat = DB::table('tbl_language')
                            ->select('lang_id', 'lang_title')
                            ->where('lang_status', '=', 1)
                            ->get();
        }
        return array('lang_count' => count($title_cat), 'lang_info' => $title_cat);
    }

    static function getSubCategoryTitle($cid=null)
    {
        if(!empty($cid)){
            $title_cat = DB::table('tbl_language as lng')
                            ->leftJoin('tbl_category_detail_translate as ct', function($join) use ($cid)
                            {
                                $join->on('lng.lang_id', '=', 'ct.lang_id');
                                $join->on('ct.ctd_id', '=', DB::raw($cid));
                            })
                            ->select('lng.lang_id', 'ct.ctdt_id', 'ct.ctdt_title', 'ct.ctdt_des', 'lng.lang_title')
                            ->where('lng.lang_status', '=', 1)
                            ->get();

        }else{
            $title_cat = DB::table('tbl_language')
                            ->select('lang_id', 'lang_title')
                            ->where('lang_status', '=', 1)
                            ->get();
        }
        return array('lang_count' => count($title_cat), 'lang_info' => $title_cat);
    }

    static function getOneRow($cid=null)
    {
        if(!empty($cid)){
            $category = DB::table('tbl_category')
                           ->where('cat_id', '=', $cid)
                           ->first();

            return $category;
        }
    }

    static function getSubOneRow($cid=null)
    {
        if(!empty($cid)){
            $category = DB::table('tbl_category_detail')
                           ->where('ctd_id', '=', $cid)
                           ->first();

            return $category;
        }
    }

    static function getMultiRow($cid=null)
    {
        if(!empty($cid)){
            $category = DB::table('tbl_category_detail')
                           ->where('cat_id', '=', $cid)
                           ->get();

            return $category;
        }
    }

    static function uploadPhoto($photo=null, $width=200, $height=200, $pathPhoto=null, $pathPhotoThumb=null, $cat_id=null)
    {
        if(!empty($photo)){

            $image_name = time().".".$photo->getClientOriginalExtension();
            $photo->move($pathPhoto, $image_name);

            $photo_name = 'c_'.$image_name;

            $origin = Image::make($pathPhoto.'/'.$image_name);
            $origin->resize($width, $height, function ($o){
                $o->aspectRatio();
                $o->upsize();
            });
            $origin->save($pathPhoto.'/'.$photo_name);

            if(!empty($pathPhotoThumb)){
                $thumb  = Image::make($pathPhoto.'/'.$image_name);
                $thumb->resize(400, 400, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                //$thumb->insert('public/watermark.png');
                $thumb->save($pathPhotoThumb.'/'.$photo_name);

                if(!empty($cat_id)){
                    $img_cat= BackendCategoryModel::getMultiRow($cat_id);
                    foreach($img_cat as $img){
                        if(!empty($img->ctd_image)){ @unlink($pathPhotoThumb.'/'.$img->ctd_image); }
                    }
                }

            }else{

                if(!empty($cat_id)){
                    $img_cat= BackendCategoryModel::getOneRow($cat_id);
                    if(!empty($img_cat->cat_image)){ @unlink($pathPhoto.'/'.$img_cat->cat_image); }
                }

            }
            @unlink($pathPhoto.'/'.$image_name);

            return $photo_name;
        }
    }

    static function removeCategoryById($cat_id=null, $photoPath=null, $pathPhotoSub=null)
    {
        if(!empty($cat_id)){
            $category     = BackendCategoryModel::getOneRow($cat_id);
            $category_sub = BackendCategoryModel::getMultiRow($cat_id);

            if(!empty($category_sub)){
                foreach($category_sub as $sub){
                    if(!empty($sub->ctd_image)){
                        @unlink($pathPhotoSub.'/'.$sub->ctd_image);
                        @unlink($pathPhotoSub.'/thumb/'.$sub->ctd_image);
                    }
                    // Delete content translate
                    DB::table('tbl_category_detail_translate')->where('ctd_id', '=', $sub->ctd_id)->delete();
                }

                DB::table('tbl_category_detail')->where('cat_id', '=', $cat_id)->delete();

            }

            if(!empty($category)){
                if(!empty($category->cat_image)){
                    @unlink($pathPhoto.'/'.$category->cat_image);
                }
            }

            // Delete content translate
            DB::table('tbl_category_translate')->where('cat_id', '=', $cat_id)->delete();

            $cat_delete  = DB::table('tbl_category')->where('cat_id', '=', $cat_id)->delete();

            return $cat_delete;
        }
    }

    static function lastIdSubCategory()
    {
        $last_val = DB::table('tbl_category_detail')->max('ctd_id');
        return $last_val;
    }

    static function removeSubCategory($cat_id=null, $path=null, $path_thumb=null)
    {
        if(!empty($cat_id)){
            $image = DB::table('tbl_category_detail')
                        ->select('ctd_image')
                        ->where('ctd_id', '=', $cat_id)
                        ->first();

            $image_path = $path.'/'.$image->ctd_image;
            $image_path_thumb = $path_thumb.'/'.$image->ctd_image;
            @unlink($image_path);
            @unlink($image_path_thumb);

            // Delete content translate
            DB::table('tbl_category_detail_translate')->where('ctd_id', '=', $cat_id)->delete();
            // Detele content category
            $sub_category = DB::table('tbl_category_detail')->where('ctd_id', '=', $cat_id)->delete();

            return $sub_category;
        }
    }
}
