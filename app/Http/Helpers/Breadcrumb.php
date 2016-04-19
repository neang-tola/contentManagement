<?php
namespace App\Helpers;

class Breadcrumb{
	public static function create($url=array())
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

