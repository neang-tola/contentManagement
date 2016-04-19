<?php
namespace App\Http\Helpers;
use DB;

class AdminHelper{
	public static function Position($post_id=null)
	{
		if(!empty($post_id)){
			
			switch($post_id):
				case 1:
					$post_title = 'Top';
					break;
				case 2:
					$post_title = 'Right';
					break;
				case 3:
					$post_title = 'Bottom';
					break;
				case 4:
					$post_title = 'Left';
					break;
				default:
					$post_title = '';
					break;
			endswitch;
			return $post_title;
		}
	}
	
	public static function getSubMenu($parent_id=1)
	{
		$print_submenu = '';

    	$lang_id = DB::table('tbl_language')
    				   ->select('lang_id')
    				   ->where('lang_status', '=', 1)
    				   ->first();

		if($parent_id > 1){
			$sub_menu = DB::table('tbl_menu as m')
	    				->join('tbl_content as c', 'c.con_id', '=', 'm.con_id')
	    				->select('m_id', 'm.m_title', 'm.m_link_type', 'm.m_post', 'm.m_status', 'c.con_title')
	    				->where('m.m_parent', '=', $parent_id)
	    				->get();
		}

		if(!empty($sub_menu)){
			foreach($sub_menu as $menu):
                if($menu->m_status == 0){
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-0"><i class="active-button"></i></span>';
                }
				
				$print_submenu .= '
                                <tr>
                                  <td class="none-border">&nbsp;</td>
                                  <td class="sub-border">-- <span class="menu-title">'. $menu->m_title .'</span></td>
                                  <td class="sub-border">'. AdminHelper::Position($menu->m_post) .'</td>
                                  <td class="sub-border">'. $menu->m_link_type .'</td>
                                  <td class="sub-border">'. $menu->con_title .'</td>
                                  <td class="sub-border">'.$status.'</td>
                                  <td class="sub-border"><a href="'. route('admin.menu.edit') .'?mid='. $menu->m_id .'"><i class="edit-button"></i></a></td>
                                  <td class="sub-border"><i class="del-button" id="del-'. $menu->m_id .'"></i></td>
                                </tr>
							';
			endforeach;
		}

		return $print_submenu;
	}

	public static function getActiveLanguage()
	{	
		$my_lang     = array();
    	$my_language = DB::table('tbl_language')
    				   ->select('lang_id', 'lang_title')
    				   ->where('lang_status', '=', 1)
    				   ->get();

    	foreach($my_language as $lng){
    		$my_lang[$lng->lang_id] = $lng->lang_title; 
    	}
    	$return = array('lang_count' => count($my_language), 'lang_info' => $my_lang);
    	return  $return;
	}

	public static function controlStatus()
	{
		$control = array(0 => 'Inactive', 1 => 'Active');
		return $control;
	}

	public static function controlYesNo()
	{
		$control = array(0 => 'No', 1 => 'Yes');
		return $control;
	}

	public static function controlTypeLink()
	{
		$control = array('internal' => 'Internal Link', 'external' => 'External Link');
		return $control;
	}

	public static function controlContentType()
	{
		$return  = array();
		$control = DB::table('tbl_content_type')
					   ->select('cnt_id', 'cnt_title')
					   ->orderBy('cnt_title')
					   ->where('cnt_status', '=', 1)
					   ->get();

		foreach($control as $ctrl):
			$return[$ctrl->cnt_id] = $ctrl->cnt_title;
		endforeach;

		return $return;
	}

	public static function controlPosition()
	{
		$control = array(1 => 'Top', 2 => 'Right', 3 => 'Bottom', 4 => 'Left');

		return $control;
	}

	public static function controlParent($selected=null, $mid=null)
	{
		$return  = array();
		if(empty($selected)){
			$control = DB::table('tbl_menu')
						   ->select('m_id', 'm_title')
						   ->where('m_parent', '=', 0)
						   ->where('m_id', '>', 1)
						   ->get();
		}else{
			$control = DB::table('tbl_menu')
						   ->select('m_id', 'm_title')
						   ->where('m_parent', '=', 0)
						   ->where('m_id', '>', 1)
						   ->where('m_id', '<>', $mid) 
						   ->get();
		}
		
		$return[0]	= 'Parent';
		foreach($control as $row):
			$return[$row->m_id] = $row->m_title;
		endforeach;

		return $return;
	}

	public static function encode_title($title=null)
	{
		$str		 = str_ireplace(' ', '-', $title);
		$form_format = array('(', ')', '!', '?', '|', '/','&','+');
		$url_format  = str_ireplace($form_format, '', $str); 

		return strtolower($url_format);
	}
	
	public static function breadcrumb($url=array())
	{
		$list_url = '';
		$i = 0;
		$dashboard = array(route('admin.dashboard') => 'Dashboard');

		$breadcrumb= array_merge($dashboard, $url);

		$last_breadcrumb = count($breadcrumb);

		foreach ($breadcrumb as $key => $value) {
			if(++$i == $last_breadcrumb):
				$list_url .= '<li>'.$value.'</li>';
			else:
				$list_url .= '<li><a href="'.$key.'">'.$value.'</a></li>';
			endif;
		}

		$str_breadcrumb = '
	                           <ol class="breadcrumb">
	                              '.$list_url.'
	                           </ol>
		';
		return $str_breadcrumb;
	}
}