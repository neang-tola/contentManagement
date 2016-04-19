<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Models\BackendCategoryModel as Category;
use App\Http\Requests;
use AdminHelper;
use Validator;
use Session;
use DB;

class BackendCategorySubController extends Controller
{
    public function index()
    {
        $category_id            = Input::get('main_cat');
        $category_info          = Category::getOneRow($category_id);

        if(!empty($category_info)){
            Session::put('category', ['cid' => $category_info->cat_id, 'ctitle' => $category_info->cat_title]);

            $data['title']          = Session::get('category')['ctitle'] . ' :: Manage Sub-category list';
            $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category', 
                                                               route('admin.subcategory.list').'?main_cat='.$category_id => Session::get('category')['ctitle']]);
            $data['ind']            = 1;
            $data['sub_category_info']  = Category::getAllSubCategory($category_id, 20);
            $data['sub_category_info']->setPath('internal-bkn/loading-sub-category-list');

            return view('admin.category_sub_list')->with($data);
        }else{
            return redirect()->route('admin.category.list');
        }
    }

    public function pagination()
    {
        $print_result       = '';
        $num_currentpage    = Input::get('page');
        $main_category      = Session::get('category')['cid'];

        $perpage            = 20;
        if(empty($num_currentpage)){
            $offset         = 0;
        }else{
            $offset         = $perpage * ($num_currentpage - 1);
        }

        $category_info       = Category::getAllSubCategory($main_category, $perpage, $offset);

        if(!empty($category_info)):
            foreach($category_info as $cat):
                if($cat->ctd_status == 0){
                    $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-0"><i class="active-button"></i></span>';
                }

                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td>|&rarr; <span class="category-title">'. $cat->ctd_title .'</span></td>
                                  <td>'. date('d F, Y', strtotime($cat->created_at)) .'</td>
                                  <td>'. $status .'</td>
                                  <td><a href="'. route('admin.subcategory.edit') .'?cid='. $cat->ctd_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $cat->ctd_id .'"></i></td>
                                </tr>
                            ';
            endforeach;
        endif;

        echo $print_result;
    }

    public function create()
    {
        $data['title']          = Session::get('category')['ctitle'].' :: New Sub Category';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category', 
                                                           route('admin.subcategory.list').'?main_cat='.Session::get('category')['cid'] => Session::get('category')['ctitle'], 
                                                           route('admin.subcategory.create') => 'New sub-category']);
        $data['heading_title']  = strtoupper(Session::get('category')['ctitle']).' :: New Sub Category information';
        $data['info_translate'] = Category::getCategoryTitle();
        $data['max_order']      = Category::max('cat_sequense') + 1;

        return view('admin.category_sub_create_form')->with($data);
    }

    public function store(Request $request)
    {
        extract($request->input());

        $main_category = Session::get('category')['cid'];
        $arr_image  = array();
        $count_lang = count(array_filter($langId));
        $image      = Input::file('categoryImage');

        $cat_image  = Category::uploadPhoto($image, 900, 900, 'public/categories/sub', 'public/categories/sub/thumb');

        if(!empty($cat_image))  $arr_image = array('ctd_image' => $cat_image);

        $val_update = array('ctd_title'    => $categoryTitle[0],
                            'cat_id'       => $main_category,
                            'ctd_status'   => $categoryStatus,
                            'ctd_sequense' => $categoryOrder,
                            'created_at'   => date('Y-m-d H:i:s'));

        $add_category= DB::table('tbl_category_detail')->insert(array_merge($val_update, $arr_image));

        $last_id     = Category::lastIdSubCategory();
        if($add_category == 1){
                
            for($i=0; $i<count($langId); $i++){

                if(empty($categoryTitle[$i]))  $title = 'No Translate';
                else                           $title = $categoryTitle[$i]; 

                if(empty($categoryDes[$i]))    $des   = 'No Translate';
                else                           $des   = $categoryDes[$i]; 

                DB::table('tbl_category_detail_translate')
                    ->insert(['ctd_id' => $last_id, 'ctdt_title' => $title, 'ctdt_des' => $des, 'lang_id' => $langId[$i]]);

            }
            
            Session::flash('msg', '<div class="alert alert-success" role="alert">Sub Category information have been added <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Sub Category information was added <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $main_category  = Session::get('category')['cid'];
        $search_val     = $request->input('search');
        $print_result   = '';
        $ind = 0;

        if(!empty($search_val)){
            $result_search = Category::findSubCategory($main_category, $search_val);

            if(!empty($result_search)):
                foreach($result_search as $cat):
                    if($cat->ctd_status == 0){
                        $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-0"><i class="active-button"></i></span>';
                    }

                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td>|&rarr; <span class="category-title">'. $cat->ctd_title .'</span></td>
                                      <td>'. date('d F, Y', strtotime($cat->created_at)) .'</td>
                                      <td>'. $status .'</td>
                                      <td><a href="'. route('admin.subcategory.edit') .'?cid='. $cat->ctd_id .'"><i class="edit-button"></i></a></td>
                                      <td><i class="del-button" id="del-'. $cat->ctd_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            else:
                $print_result .= '<tr><td colspan="6">
                                    <div class="alert alert-info"><strong>Not found</strong> your key word search not match to Sub Category title.</div>
                                 </td></tr>';
            endif;
        }else{
            $category_info     = Category::getAllSubCategory($main_category, 20);

            foreach($category_info as $cat):
                if($cat->ctd_status == 0){
                    $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-c" id="status-'. $cat->ctd_id .'-0"><i class="active-button"></i></span>';
                }

                $print_result .= '
                                <tr>
                                  <td>'. ++$ind .'</td>
                                  <td>|&rarr; <span class="category-title">'. $cat->ctd_title .'</span></td>
                                  <td>'. date('d F, Y', strtotime($cat->created_at)) .'</td>
                                  <td>'. $status .'</td>
                                  <td><a href="'. route('admin.subcategory.edit') .'?cid='. $cat->ctd_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $cat->ctd_id .'"></i></td>
                                </tr>
                            ';
            endforeach;     
        }

        echo $print_result;
    }

    public function edit()
    {
        $category_id  = Input::get('cid');

        $data['title']          = Session::get('category')['ctitle'] . ' :: Edit sub category';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category', 
                                                           route('admin.subcategory.list').'?main_cat='.Session::get('category')['cid'] => Session::get('category')['ctitle'], 
                                                           route('admin.subcategory.edit') => 'Edit sub-category']);
        $data['heading_title']  = strtoupper(Session::get('category')['ctitle']) . ' :: Edit Sub-category information';
        $data['info_translate'] = Category::getSubCategoryTitle($category_id);
        $data['info']           = Category::getSubOneRow($category_id);

        return view('admin.category_sub_edit_form')->with($data);
    }

    public function update(Request $request)
    {
        extract($request->input());

        $arr_image  = array();
        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($categoryTId));
        $image      = Input::file('categoryImage');

        $cat_image  = Category::uploadPhoto($image, 900, 900, 'public/categories/sub', 'public/categories/sub/thumb', $categoryId);

        if(!empty($cat_image))  $arr_image = array('ctd_image' => $cat_image);

        $val_update = array('ctd_title'    => $categoryTitle[0],
                            'ctd_status'   => $categoryStatus,                            
                            'ctd_sequense' => $categoryOrder,
                            'updated_at'   => date('Y-m-d H:i:s'));

        $up_category= DB::table('tbl_category_detail')->where('ctd_id', '=', $categoryId)->update(array_merge($val_update, $arr_image));

        if($up_category == 1){
            //dd($count_lang .' <= '. $count_tran);
            if($count_lang <= $count_tran):
                
                for($i=0; $i<count($langId); $i++){
                    if(empty($categoryTitle[$i]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$i];

                    if(empty($categoryDes[$i]))    $des   = 'No Translate';
                    else                           $des   = $categoryDes[$i]; 

                    DB::table('tbl_category_detail_translate')
                        ->where('ctdt_id', '=', $categoryTId[$i])
                        ->update(['ctdt_title' => $title, 'ctdt_des' => $des]);
                }

            else:

                for($i=0; $i<$count_tran; $i++){

                    if(empty($categoryTitle[$i]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$i]; 

                    if(empty($categoryDes[$i]))    $des   = 'No Translate';
                    else                           $des   = $categoryDes[$i]; 

                    DB::table('tbl_category_detail_translate')
                        ->where('ctdt_id', '=', $categoryTId[$i])
                        ->update(['ctdt_title' => $title, 'ctdt_des' => $des]);
                        
                }
                // Language more than title
                for($k=$count_tran; $k<$count_lang; $k++){

                    if(empty($categoryTitle[$k]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$k]; 

                    if(empty($categoryeDes[$k]))   $des   = 'No Translate';
                    else                           $des   = $categoryDes[$k];

                    DB::table('tbl_category_detail_translate')
                        ->insert(['ctd_id' => $categoryId, 'ctdt_title' => $title, 'ctdt_des' => $des, 'lang_id' => $langId[$i]]);
                } 
            endif;
            Session::flash('msg', '<div class="alert alert-success" role="alert">Sub Category information have been updated <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Sub Category information was updated <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function destroy()
    {
        $cat_delete     = Input::get('did');
        $path_image     = 'public/categories/sub';
        $path_image_thum= 'public/categories/sub/thumb';

        if(is_numeric($cat_delete)){
            $destroy    = Category::removeSubCategory($cat_delete, $path_image, $path_image_thum);

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }
    }

    public function updateStatus()
    {
        $cat_status   = explode('-', Input::get('cid'));
   
        if(count($cat_status) == 2){
            $category = DB::table('tbl_category_detail')
                       ->where('ctd_id', '=', $cat_status[0])
                       ->update(['ctd_status' => $cat_status[1]]);

            if(!empty($category)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }

}
