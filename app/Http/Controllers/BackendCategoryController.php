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

class BackendCategoryController extends Controller
{
    public function index()
    {
        $data['title']          = 'Manage Category list';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category']);
        $data['ind']            = 1;
        $data['category_info']  = Category::getAllCategory(20);
        $data['category_info']->setPath('internal-bkn/loading-category-list');

        return view('admin.category_list')->with($data);
    }

    public function pagination()
    {
        $print_result       = '';
        $num_currentpage    = Input::get('page');
    
        $perpage            = 20;
        if(empty($num_currentpage)){
            $offset         = 0;
        }else{
            $offset         = $perpage * ($num_currentpage - 1);
        }

        $category_info       = Category::getAllCategory($perpage, $offset);

        if(!empty($category_info)):
            foreach($category_info as $cat):
                if($cat->cat_status == 0){
                    $status = '<span class="status-c" id="status-'. $cat->cat_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-c" id="status-'. $cat->cat_id .'-0"><i class="active-button"></i></span>';
                }

                if($cat->cat_front == 0){
                    $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-1"><i class="no-button"></i>';
                }else{
                    $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-0"><i class="yes-button"></i>';
                }

                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td><span class="category-title">'. $cat->cat_title .'</span></td>
                                  <td><a href="'. route('admin.subcategory.list') .'?main_cat='.$cat->cat_id.'" title="Add Sub category"><i class="category-add-button"></i></a></td>
                                  <td>'. $front .'</td>
                                  <td>'. $status .'</td>
                                  <td><a href="'. route('admin.category.edit') .'?cid='. $cat->cat_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $cat->cat_id .'"></i></td>
                                </tr>
                            ';
            endforeach;
        endif;

        echo $print_result;
    }

    public function create()
    {
        $data['title']          = 'Manage Category : New record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category', 
                                                           route('admin.category.create') => 'New Category']);
        $data['heading_title']  = 'New Category information';
        $data['info_translate'] = Category::getCategoryTitle();
        $data['max_order']      = Category::max('cat_sequense') + 1;

        return view('admin.category_create_form')->with($data);
    }

    public function store(Request $request)
    {
        extract($request->input());

        $arr_image  = array();
        $count_lang = count(array_filter($langId));
        $image      = Input::file('categoryImage');

        $cat_image  = Category::uploadPhoto($image, 200, 200, 'public/categories');

        if(!empty($cat_image))  $arr_image = array('cat_image' => $cat_image);

        $val_update = array('cat_title'    => $categoryTitle[0],
                            'cat_front'    => $categoryShowFront,
                            'cat_status'   => $categoryStatus,
                            'cat_sequense' => $categoryOrder,
                            'created_at'   => date('Y-m-d H:i:s'));

        $add_category= DB::table('tbl_category')->insert(array_merge($val_update, $arr_image));

        $last_id     = Category::max('cat_id');
        if($add_category == 1){
                
            for($i=0; $i<count($langId); $i++){

                if(empty($categoryTitle[$i]))  $title = 'No Translate';
                else                           $title = $categoryTitle[$i]; 

                if(empty($categoryDes[$i]))    $des   = 'No Translate';
                else                           $des   = $categoryDes[$i]; 

                DB::table('tbl_category_translate')
                    ->insert(['cat_id' => $last_id, 'catt_title' => $title, 'catt_des' => $des, 'lang_id' => $langId[$i]]);

            }
            
            Session::flash('msg', '<div class="alert alert-success" role="alert">Category information have been added <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Category information was added <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search_val   = $request->input('search');
        $print_result = '';
        $ind = 0;

        if(!empty($search_val)){
            $result_search = Category::findCategory($search_val);

            if(!empty($result_search)):
                foreach($result_search as $cat):
                    if($cat->cat_status == 0){
                        $status = '<span class="status-c" id="status-'. $cat->cat_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-c" id="status-'. $cat->cat_id .'-0"><i class="active-button"></i></span>';
                    }

                    if($cat->cat_front == 0){
                        $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-1"><i class="no-button"></i>';
                    }else{
                        $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-0"><i class="yes-button"></i>';
                    }

                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="category-title">'. $cat->cat_title .'</span></td>
                                      <td><a href="'. route('admin.subcategory.list') .'?main_cat='.$cat->cat_id.'" title="Add Sub category"><i class="category-add-button"></i></a></td>
                                      <td>'. $front .'</td>
                                      <td>'. $status .'</td>
                                      <td><a href="'. route('admin.category.edit') .'?cid='. $cat->cat_id .'"><i class="edit-button"></i></a></td>
                                      <td><i class="del-button" id="del-'. $cat->cat_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            else:
                $print_result .= '<tr><td colspan="7">
                                    <div class="alert alert-info"><strong>Not found</strong> your key word search not match to Category title.</div>
                                 </td></tr>';
            endif;
        }else{
            $category_info     = Category::getAllCategory(20);

            foreach($category_info as $cat):
                if($cat->cat_status == 0){
                    $status = '<span class="status-c" id="status-'. $cat->cat_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-c" id="status-'. $cat->cat_id .'-0"><i class="active-button"></i></span>';
                }

                if($cat->cat_front == 0){
                    $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-1"><i class="no-button"></i>';
                }else{
                    $front  = '<span class="show-f" id="showf-'. $cat->cat_id .'-0"><i class="yes-button"></i>';
                }

                $print_result .= '
                                <tr>
                                  <td>'. ++$ind .'</td>
                                  <td><span class="category-title">'. $cat->cat_title .'</span></td>
                                  <td><a href="'. route('admin.subcategory.list') .'?main_cat='.$cat->cat_id.'" title="Add Sub category"><i class="category-add-button"></i></a></td>
                                  <td>'. $front .'</td>
                                  <td>'. $status .'</td>
                                  <td><a href="'. route('admin.category.edit') .'?cid='. $cat->cat_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $cat->cat_id .'"></i></td>
                                </tr>
                            ';
            endforeach;         
        }

        echo $print_result;
    }

    public function edit()
    {
        $category_id  = Input::get('cid');

        $data['title']          = 'Manage Category : Edit record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.category.list') => 'Manage Category', 
                                                           route('admin.category.edit') => 'Edit Category']);
        $data['heading_title']  = 'Edit Category information';
        $data['info_translate'] = Category::getCategoryTitle($category_id);
        $data['info']           = Category::getOneRow($category_id);

        return view('admin.category_edit_form')->with($data);
    }

    public function update(Request $request)
    {
        extract($request->input());

        $arr_image  = array();
        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($categoryTId));
        $image      = Input::file('categoryImage');

        $cat_image  = Category::uploadPhoto($image, 200, 200, 'public/categories', null, $categoryId);

        if(!empty($cat_image))  $arr_image = array('cat_image' => $cat_image);

        $val_update = array('cat_title'    => $categoryTitle[0],
                            'cat_front'    => $categoryShowFront,
                            'cat_status'   => $categoryStatus,
                            'cat_sequense' => $categoryOrder,
                            'updated_at'   => date('Y-m-d H:i:s'));

        $up_category= DB::table('tbl_category')->where('cat_id', '=', $categoryId)->update(array_merge($val_update, $arr_image));

        if($up_category == 1){
            //dd($count_lang .' <= '. $count_tran);
            if($count_lang <= $count_tran):
                
                for($i=0; $i<count($langId); $i++){
                    if(empty($categoryTitle[$i]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$i];

                    if(empty($categoryDes[$i]))    $des   = 'No Translate';
                    else                           $des   = $categoryDes[$i]; 

                    DB::table('tbl_category_translate')
                        ->where('catt_id', '=', $categoryTId[$i])
                        ->update(['catt_title' => $title, 'catt_des' => $des]);
                }

            else:

                for($i=0; $i<$count_tran; $i++){

                    if(empty($categoryTitle[$i]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$i]; 

                    if(empty($categoryDes[$i]))    $des   = 'No Translate';
                    else                           $des   = $categoryDes[$i]; 

                    DB::table('tbl_category_translate')
                        ->where('catt_id', '=', $categoryTId[$i])
                        ->update(['catt_title' => $title, 'ctt_des' => $des]);
                        
                }
                // Language more than title
                for($k=$count_tran; $k<$count_lang; $k++){

                    if(empty($categoryTitle[$k]))  $title = 'No Translate';
                    else                           $title = $categoryTitle[$k]; 

                    if(empty($categoryeDes[$k]))   $des   = 'No Translate';
                    else                           $des   = $categoryDes[$k];

                    DB::table('tbl_category_translate')
                        ->insert(['cat_id' => $categoryId, 'catt_title' => $title, 'catt_des' => $des, 'lang_id' => $langId[$k]]);
                } 
            endif;
            Session::flash('msg', '<div class="alert alert-success" role="alert">Category information have been updated <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Category information was updated <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function destroy()
    {
        $cat_delete     = Input::get('did');
        $path_image     = 'public/categories';
        $path_image_sub = 'public/categories/sub';

        if(is_numeric($cat_delete)){
            $destroy    = Category::removeCategoryById($cat_delete, $path_image, $path_image_sub);

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
            $category = Category::where('cat_id', '=', $cat_status[0])
                       ->update(['cat_status' => $cat_status[1]]);

            if(!empty($category)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }

    public function updateFront()
    {
        $cat_status   = explode('-', Input::get('cid'));
   
        if(count($cat_status) == 2){
            $category = Category::where('cat_id', '=', $cat_status[0])
                       ->update(['cat_front' => $cat_status[1]]);

            if(!empty($category)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }
}
