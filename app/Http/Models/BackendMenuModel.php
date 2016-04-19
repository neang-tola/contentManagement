<?php

namespace App\Http\Models;

use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use AdminHelper;

class BackendMenuModel extends Model
{
    protected $table = 'tbl_menu';

    static function getAllMenu($limit=null, $offset=null)
    {
    	if(!empty($offset)):
	    	$menu = DB::table('tbl_menu as m')
	    				->join('tbl_content as c', 'c.con_id', '=', 'm.con_id')
	    				->select('m_id', 'm.m_title', 'm.m_link_type', 'm.m_post', 'm.m_status', 'c.con_title')
	    				->where('m.m_parent', '=', 0)
	    				->skip($offset)
	    				->take($limit)
	    				->orderBy('m.m_sequense')
	    				->get();
	    else:
	    	$menu = DB::table('tbl_menu as m')
	    				->join('tbl_content as c', 'c.con_id', '=', 'm.con_id')
	    				->select('m.m_id', 'm.m_title', 'm.m_post', 'm.m_link_type', 'm.m_status', 'c.con_title')
	    				->where('m.m_parent', '=', 0)
	    				->orderBy('m.m_sequense')
	    				->paginate($limit);

	    endif;

	    return $menu;
    }

    static function findMenu($key_find=null)
    {
	    $menu    = DB::table('tbl_menu as m')
	    				->join('tbl_content as c', 'c.con_id', '=', 'm.con_id')
	    				->select('m_id', 'm.m_title', 'm.m_link_type', 'm.m_post', 'm.m_status', 'c.con_title')
	    				->where('m.m_title', 'like', '%'.$key_find.'%')
	    				->get();

	    return $menu;
    }

	static function getMenuTitle($mid=null)
	{
		if(!empty($mid)){
			$title_menu = DB::table('tbl_language as lng')
							->leftJoin('tbl_menu_translate as mt', function($join) use ($mid)
							{
								$join->on('lng.lang_id', '=', 'mt.lang_id');
								$join->on('mt.m_id', '=', DB::raw($mid));
							})
							->select('lng.lang_id', 'mt.mnt_id', 'mt.mnt_title', 'lng.lang_title')
							->where('lng.lang_status', '=', 1)
							->get();

		}else{
			$title_menu = DB::table('tbl_language')
							->select('lang_id', 'lang_title')
							->where('lang_status', '=', 1)
							->get();
		}
		return array('lang_count' => count($title_menu), 'lang_info' => $title_menu);
	}

	static function getOneRow($mid=null)
	{
		if(!empty($mid)){
			$one_menu = DB::table('tbl_menu')
							->where('m_id', '=', $mid)
							->first();

			return $one_menu;
		}
	}

	static function getContent($con_type=null)
	{
		$control = array();
		if(empty($con_type)){
			$content = DB::table('tbl_content')
						   ->select('con_id', 'con_title')
						   ->where('cnt_id', '=', 4)
						   ->get();
		}else{
			$content = DB::table('tbl_content')
						   ->select('con_id', 'con_title')
						   ->where('cnt_id', '=', $con_type)
						   ->get();
		}

		foreach($content as $con):
			$control[$con->con_id] = $con->con_title;
		endforeach;

		return $control;
	}

	static function controlContentType($con_type=null)
	{
		$control_opt = '';
		if(!empty($con_type)){
            switch ($con_type) {
                case 2: // Category
                    $content_type = DB::table('tbl_category')
                                        ->select('cat_id as id', 'cat_title as title')
                                        ->get();
                    break;
                
                case 3: // Gallery
                    $content_type = DB::table('tbl_gallery')
                                        ->select('gal_id as id', 'gal_title as title')
                                        ->get();
                    break;
                case 4: // Article
                    $content_type = DB::table('tbl_content')
                                        ->select('con_id as id', 'con_title as title')
                                        ->where('cnt_id', '=', 4)
                                        ->get();
                    break;
                case 5: // Contact
                    $content_type = DB::table('tbl_content')
                                        ->select('con_id as id', 'con_title as title')
                                        ->where('cnt_id', '=', 5)
                                        ->get();
                    break;
                default:
                    # code...
                    break;
            }

            if(!empty(@$content_type)):
                if(!empty($content_type)){
                    foreach($content_type as $ct):
                        $control_opt .= '<option value="'. $ct->id .'">'. $ct->title .'</option>';
                    endforeach;  
                }
            endif;
		}

		return $control_opt;
	}

	static function checkAliasMenu($val=null, $mid=null)
	{
		$alias_val  = AdminHelper::encode_title($val);
		if(empty($mid)){
			$menu_alias = DB::table('tbl_menu') 
							  ->select('m_link')
							  ->where('m_link', '=', $alias_val)
							  ->first();
		}else{
			$menu_alias = DB::table('tbl_menu')
							  ->select('m_link')
							  ->where('m_link', '=', $alias_val)
							  ->where('m_id', '<>', $mid)
							  ->first();
		}

		if(empty($menu_alias)){
			$status 	= true;
		}else{
			$status 	= false;
		}
		
		return $status;
	}

	static function findMaxOrder()
	{
		$max_val = BackendMenuModel::max('m_sequense');

		return $max_val + 1;
	}

	static function deleteMenu($del=null)
	{
		if(!empty($del)){
			DB::table('tbl_menu_translate')->where('m_id', '=', $del)->delete();

			$delete = DB::table('tbl_menu')->where('m_id', '=', $del)->delete();

			return $delete;
		}
	}
}
