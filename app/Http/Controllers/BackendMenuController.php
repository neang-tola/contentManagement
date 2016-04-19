<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Models\BackendMenuModel as Menu;
use App\Http\Requests;
use AdminHelper;
use Session;
use DB;

class BackendMenuController extends Controller
{
    public function index()
    {
    	$data['title'] 			= 'Manage Menu list';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.menu.list') => 'Manage Menu']);

    	$data['ind']			= 1;
    	$data['menu_info'] 		= Menu::getAllMenu(10);
        $data['menu_info']->setPath('internal-bkn/loading-menu-list');

    	return view('admin.menu_list')->with($data);
    }

    public function pagination()
    {
        $print_result       = '';
        $num_currentpage    = Input::get('page');
    
        $perpage            = 10;
        if(empty($num_currentpage)){
            $offset   = 0;
        }else{
            $offset   = $perpage * ($num_currentpage - 1);
        }

        $menu_info  = Menu::getAllMenu($perpage, $offset);

        if(!empty($menu_info)):
            foreach($menu_info as $menu):
                if($menu->m_status == 0){
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-0"><i class="active-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td><span class="menu-title">'. $menu->m_title .'</span></td>
                                  <td>'. AdminHelper::Position($menu->m_post) .'</td>
                                  <td>'. $menu->m_link_type .'</td>
                                  <td>'. $menu->con_title .'</td>
                                  <td>'.$status.'</td>
                                  <td><a href="'. route('admin.menu.edit') .'?mid='. $menu->m_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $menu->m_id .'"></i></td>
                                </tr>
                            ';
                $print_result .= AdminHelper::getSubMenu($menu->m_id);
            endforeach;
        endif;

        echo $print_result;
    }

    public function create()
    {
        $data['title']          = 'Manage Menu : Create New record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.menu.list') => 'Manage Menu', 
                                                           route('admin.menu.create') => 'New Menu']);

        $data['heading_title']  = 'Create Menu information';
        $data['title_lang']     = Menu::getMenuTitle();
        $data['content_info']   = Menu::getContent();
        $data['max_order']      = Menu::findMaxOrder();

        return view('admin.menu_create_form')->with($data);
    }

    public function store(Request $request)
    {
        extract($request->input());
        if($menuTypeLink == 'external')    $content_id = 3;
        else                               $content_id = @$menuContent;


            $val_insert = array('m_parent'  => $menuParent,
                                'm_title'   => trim($menuTitle[0]),
                                'm_post'    => $menuPosition,
                                'm_sequense'=> $menuOrder,
                                'm_link'    => AdminHelper::encode_title($menuLink),
                                'm_link_type'=> $menuTypeLink,
                                'm_status'  => $menuStatus,
                                'cnt_id'    => $menuContentType,
                                'con_id'    => $content_id,
                                'created_at'=> date('Y-m-d H:i:s'),
                                'updated_at'=> date('Y-m-d H:i:s'));

            $add_menu = DB::table('tbl_menu')->insert($val_insert);

            $last_id  = Menu::max('m_id');

            for($i=0; $i<count($langId); $i++){
                if(empty($menuTitle[$i])){
                    $tran_title = 'No Translate';
                }else{
                    $tran_title = $menuTitle[$i];
                }
                DB::table('tbl_menu_translate')
                    ->insert(['m_id' => $last_id, 'lang_id' => $langId[$i], 'mnt_title' => $tran_title]);
            }
        
        if($add_menu == 1){
            Session::flash('msg', '<div class="alert alert-success" role="alert">Menu information have been inserted <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Menu information was inserted <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search_val   = $request->input('search');
        $print_result = '';
        $ind = 0;

        if(!empty($search_val)){
            $result_search = Menu::findMenu($search_val);

            if(!empty($result_search)):
                foreach($result_search as $menu):
                    if($menu->m_status == 0){
                        $status    = '<span class="status-m" id="status-'. $menu->m_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status    = '<span class="status-m" id="status-'. $menu->m_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="menu-title">'. $menu->m_title .'</span></td>
                                      <td>'. AdminHelper::Position($menu->m_post) .'</td>
                                      <td>'. $menu->m_link_type .'</td>
                                      <td>'. $menu->con_title .'</td>
                                      <td>'. $status .'</td>
                                      <td><a href="'. route('admin.menu.edit') .'?mid='. $menu->m_id .'"><i class="edit-button"></i></a></td>
                                      <td><i class="del-button" id="del-'. $menu->m_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            else:
                $print_result .= '<tr><td colspan="8">
                                    <div class="alert alert-info"><strong>Not found</strong> your key word search not match to Menu title.</div>
                                 </td></tr>';
            endif;
        }else{
            $menu_info      = Menu::getAllMenu(10);

            foreach($menu_info as $menu):
                if($menu->m_status == 0){
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-m" id="status-'. $menu->m_id .'-0"><i class="active-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$ind .'</td>
                                  <td><span class="menu-title">'. $menu->m_title .'</span></td>
                                  <td>'. AdminHelper::Position($menu->m_post) .'</td>
                                  <td>'. $menu->m_link_type .'</td>
                                  <td>'. $menu->con_title .'</td>
                                  <td>'.$status.'</td>
                                  <td><a href="'. route('admin.menu.edit') .'?mid='. $menu->m_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $menu->m_id .'"></i></td>
                                </tr>
                            ';
                $print_result .= AdminHelper::getSubMenu($menu->m_id);
            endforeach;            
        }

        echo $print_result;
    }

    public function edit()
    {
        $menu_id  = Input::get('mid');

        $data['title']          = 'Manage Menu : Edit record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.menu.list') => 'Manage Menu', 
                                                           route('admin.menu.edit') => 'Edit Menu']);
        $data['heading_title']  = 'Edit Menu information';
        $data['title_lang']     = Menu::getMenuTitle($menu_id);
        $data['info']           = Menu::getOneRow($menu_id);
        $data['content_info']   = Menu::getContent($data['info']->cnt_id);

        return view('admin.menu_edit_form')->with($data);
    }

    public function update(Request $request)
    {
        extract($request->input());
        if($menuTypeLink == 'external')    $content_id = 3;
        else                               $content_id = @$menuContent;

        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($menuTId));

            $val_update = array('m_parent'  => $menuParent,
                                'm_title'   => $menuTitle[0],
                                'm_post'    => $menuPosition,
                                'm_sequense'=> $menuOrder,
                                'm_link'    => AdminHelper::encode_title($menuLink),
                                'm_link_type'=> $menuTypeLink,
                                'm_status'  => $menuStatus,
                                'cnt_id'    => $menuContentType,
                                'con_id'    => $content_id,
                                'updated_at'=> date('Y-m-d H:i:s'));

        $up_menu = DB::table('tbl_menu')->where('m_id', '=', $menuId)->update($val_update);

        if($up_menu == 1){
            //dd($count_lang .' <= '. $count_tran);
            if($count_lang <= $count_tran):
                
                for($i=0; $i<count($langId); $i++){
                    if(empty($menuTitle[$i]))  $title = 'No Translate';
                    else                       $title = $menuTitle[$i]; 

                    DB::table('tbl_menu_translate')
                        ->where('mnt_id', '=', $menuTId[$i])
                        ->update(['mnt_title' => $title]);
                }
            else:

                for($i=0; $i<$count_tran; $i++){

                    if(empty($menuTitle[$i]))  $title = 'No Translate';
                    else                       $title = $menuTitle[$i]; 

                    DB::table('tbl_menu_translate')
                        ->where('mnt_id', '=', $menuTId[$i])
                        ->update(['mnt_title' => $title]);
                        
                }
                // Language more than title
                for($k=$count_tran; $k<$count_lang; $k++){

                    if(empty($menuTitle[$k]))  $title = 'No Translate';
                    else                       $title = $menuTitle[$k]; 

                    DB::table('tbl_menu_translate')
                        ->insert(['m_id' => $menuId, 'mnt_title' => $title, 'lang_id' => $langId[$k]]);
                } 
            endif;
            Session::flash('msg', '<div class="alert alert-success" role="alert">Menu information have been updated <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Menu information was updated <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function destroy()
    {
        $menu_delete = Input::get('did');

        if(is_numeric($menu_delete)){
            $destroy    = Menu::deleteMenu($menu_delete);

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }

    }

    public function updateStatus()
    {
        $menu_status = explode('-', Input::get('mid'));
   
        if(count($menu_status) == 2){
            $menu    = Menu::where('m_id', '=', $menu_status[0])
                       ->update(['m_status' => $menu_status[1]]);

            if(!empty($menu)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }

    public function changeContentType()
    {
        $con_type   = Input::get('ct_id');
        $control_opt= '';

        if(!empty($con_type)){
            $control_opt = Menu::controlContentType($con_type);
        }

        echo $control_opt;
    }

    public function checkLink()
    {
        $link = Input::get('m_link');
        $mid  = Input::get('m_id');
        $alias = AdminHelper::encode_title($link);

        $check_link = Menu::checkAliasMenu($alias, $mid);

        if($check_link == true){
            echo 'success';
        }else{
            echo 'error exist';
        }
    }
}
