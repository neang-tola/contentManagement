<?php

namespace App\Http\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class BackendArticleModel extends Model
{
    protected $table = 'tbl_content';

    static function getAllArticle($limit=null, $offset=null)
    {
    	if(!empty($offset)):
	    	$article = DB::table('tbl_content')
	    				->select('con_id', 'con_title', 'con_front', 'created_at')
	    				->where('cnt_id', '=', 4)
	    				->skip($offset)
	    				->take($limit)
	    				->orderBy('con_id', 'desc')
	    				->get();
	    else:
	    	$article = DB::table('tbl_content')
	    				->select('con_id', 'con_title', 'con_front', 'created_at')
	    				->where('cnt_id', '=', 4)
	    				->orderBy('con_id', 'desc')
	    				->paginate($limit);

	    endif;

	    return $article;
    }

    static function findArticle($keyword=null)
    {
	    $article = DB::table('tbl_content')
	    				->select('con_id', 'con_title', 'con_front', 'created_at')
	    				->where('cnt_id', '=', 4)
	    				->where('con_title', 'like', '%'.$keyword.'%')
	    				->orderBy('con_id', 'desc')
	    				->get();

	    return $article;
    }

    static function getArticleTitle($aid=null)
    {
		if(!empty($aid)){
			$title_article = DB::table('tbl_language as lng')
							->leftJoin('tbl_content_translate as ct', function($join) use ($aid)
							{
								$join->on('lng.lang_id', '=', 'ct.lang_id');
								$join->on('ct.con_id', '=', DB::raw($aid));
							})
							->select('lng.lang_id', 'ct.ctt_id', 'ct.ctt_title', 'ct.ctt_des', 'lng.lang_title')
							->where('lng.lang_status', '=', 1)
							->get();

		}else{
			$title_article = DB::table('tbl_language')
							->select('lang_id', 'lang_title')
							->where('lang_status', '=', 1)
							->get();
		}
		return array('lang_count' => count($title_article), 'lang_info' => $title_article);
    }

    static function deleteArticle($did=null)
    {
    	DB::table('tbl_content_translate')->where('con_id', '=', $did)->delete();

    	$delete = DB::table('tbl_content')->where('con_id', '=', $did)->delete();
    	return $delete;
    }

    static function getOneRow($aid=null)
    {
    	if(!empty($aid)){
    		$article = DB::table('tbl_content')
    					   ->where('cnt_id', '=', 4)
    					   ->where('con_id', '=', $aid)
    					   ->first();

    		return $article;
    	}
    }

    static function getContact()
    {
    	$contact = DB::table('tbl_content')
    				->where('cnt_id', '=', 5)
    				->first();

    	return $contact;
    }

}
