<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Models\BackendArticleModel as Article;
use App\Http\Requests;
use AdminHelper;
use Session;
use DB;

class BackendArticleController extends Controller
{
    public function index()
    {
        $data['title']          = 'Manage Article list';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.article.list') => 'Manage Article']);
        $data['ind']            = 1;
        $data['article_info']   = Article::getAllArticle(20);
        $data['article_info']->setPath('internal-bkn/loading-article-list');

    	return view('admin.article_list')->with($data);
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

        $article_info       = Article::getAllArticle($perpage, $offset);

        if(!empty($article_info)):
            foreach($article_info as $art):
                if($art->con_front == 0){
                    $status = '<span class="status-a" id="status-'. $art->con_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-a" id="status-'. $art->con_id .'-0"><i class="active-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td><span class="article-title">'. $art->con_title .'</span></td>
                                  <td>'. date('d F, Y', strtotime($art->created_at)) .'</td>
                                  <td>'.$status.'</td>
                                  <td><a href="'. route('admin.article.edit') .'?aid='. $art->con_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $art->con_id .'"></i></td>
                                </tr>
                            ';
            endforeach;
        endif;

        echo $print_result;
    }

    public function create()
    {
        $data['title']          = 'Manage Article : New record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.article.list') => 'Manage Article', 
                                                           route('admin.article.create') => 'New Article']);
        $data['heading_title']  = 'New Aritcle information';
        $data['info_translate'] = Article::getArticleTitle();

        return view('admin.article_create_form')->with($data);
    }

    public function store(Request $request)
    {
        extract($request->input());

        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($articleTId));

        $val_insert = array('con_title'  => $articleTitle[0],
                            'con_front'  => $articleShowFront,
                            'cnt_id'     => 4,
                            'meta_key'   => $articleMetakey,
                            'meta_des'   => $articleMetades,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'));

        $add_article = DB::table('tbl_content')->insert($val_insert);

        $last_id  = Article::max('con_id');

        if($add_article == 1){
                
            for($i=0; $i<count($langId); $i++){
                if(empty($articleTitle[$i]))  $title = 'No Translate';
                else                          $title = $articleTitle[$i];

                if(empty($articleDes[$i]))    $des   = 'No Translate';
                else                          $des   = $articleDes[$i]; 

                DB::table('tbl_content_translate')
                    ->insert(['con_id' => $last_id, 'lang_id' => $langId[$i], 'ctt_title' => $title, 'ctt_des' => $des]);
            }

            Session::flash('msg', '<div class="alert alert-success" role="alert">Article information have been inserted <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Article information was inserted <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $search_val   = $request->input('search');
        $print_result = '';
        $ind = 0;

        if(!empty($search_val)){
            $result_search = Article::findArticle($search_val);

            if(!empty($result_search)):
                foreach($result_search as $art):
                    if($art->con_front == 0){
                        $status = '<span class="status-a" id="status-'. $art->con_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-a" id="status-'. $art->con_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="article-title">'. $art->con_title .'</span></td>
                                      <td>'. date('d F, Y', strtotime($art->created_at)) .'</td>
                                      <td>'.$status.'</td>
                                      <td><a href="'. route('admin.article.edit') .'?aid='. $art->con_id .'"><i class="edit-button"></i></a></td>
                                      <td><i class="del-button" id="del-'. $art->con_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            else:
                $print_result .= '<tr><td colspan="6">
                                    <div class="alert alert-info"><strong>Not found</strong> your key word search not match to Article title.</div>
                                 </td></tr>';
            endif;
        }else{
            $article_info      = Article::getAllArticle(20);

            foreach($article_info as $art):
                if($art->con_front == 0){
                    $status = '<span class="status-a" id="status-'. $art->con_id .'-1"><i class="no-button"></i></span>';
                }else{
                    $status = '<span class="status-a" id="status-'. $art->con_id .'-0"><i class="yes-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$ind .'</td>
                                  <td><span class="article-title">'. $art->con_title .'</span></td>
                                  <td>'. date('d F, Y', strtotime($art->created_at)) .'</td>
                                  <td>'.$status.'</td>
                                  <td><a href="'. route('admin.article.edit') .'?aid='. $art->con_id .'"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-'. $art->con_id .'"></i></td>
                                </tr>
                            ';
            endforeach;          
        }

        echo $print_result;
    }

    public function edit()
    {
        $article_id  = Input::get('aid');

        $data['title']          = 'Manage Article : Edit record';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.article.list') => 'Manage Article', 
                                                           route('admin.article.edit') => 'Edit Article']);

        $data['heading_title']  = 'Edit Aritcle information';
        $data['info_translate'] = Article::getArticleTitle($article_id);
        $data['info']           = Article::getOneRow($article_id);

        return view('admin.article_edit_form')->with($data);
    }

    public function update(Request $request)
    {
        extract($request->input());

        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($articleTId));

        $val_update = array('con_title'  => $articleTitle[0],
                            'con_front'  => $articleShowFront,
                            'meta_key'   => $articleMetakey,
                            'meta_des'   => $articleMetades,
                            'updated_at' => date('Y-m-d H:i:s'));

        $up_article = DB::table('tbl_content')->where('con_id', '=', $articleId)->update($val_update);

        if($up_article == 1){
            //dd($count_lang .' <= '. $count_tran);
            if($count_lang <= $count_tran):
                
                for($i=0; $i<count($langId); $i++){
                    if(empty($articleTitle[$i]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$i];

                    if(empty($articleDes[$i]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$i]; 

                    DB::table('tbl_content_translate')
                        ->where('ctt_id', '=', $articleTId[$i])
                        ->update(['ctt_title' => $title, 'ctt_des' => $des]);
                }

            else:

                for($i=0; $i<$count_tran; $i++){

                    if(empty($articleTitle[$i]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$i]; 

                    if(empty($articleDes[$i]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$i]; 

                    DB::table('tbl_content_translate')
                        ->where('cct_id', '=', $articleTId[$i])
                        ->update(['cct_title' => $title, 'ctt_des' => $des]);
                        
                }
                // Language more than title
                for($k=$count_tran; $k<$count_lang; $k++){

                    if(empty($articleTitle[$k]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$k]; 

                    if(empty($articleDes[$k]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$k];

                    DB::table('tbl_content_translate')
                        ->insert(['con_id' => $articleId, 'ctt_title' => $title, 'ctt_des' => $des, 'lang_id' => $langId[$k]]);
                } 
            endif;
            Session::flash('msg', '<div class="alert alert-success" role="alert">Article information have been updated <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Article information was updated <b>fail</b></div>');
        }

        return redirect()->back();
    }

    public function destroy()
    {
        $art_delete    = Input::get('did');

        if(is_numeric($art_delete)){
            $destroy    = Article::deleteArticle($art_delete);

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }
    }

    public function updateStatus()
    {
        $art_status  = explode('-', Input::get('aid'));
   
        if(count($art_status) == 2){
            $article = Article::where('con_id', '=', $art_status[0])
                       ->update(['con_front' => $art_status[1]]);

            if(!empty($article)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }

    public function contact()
    {
        $data['title']          = 'Manage Contact';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.contact.list') => 'Manage Contact']);
        $data['heading_title']  = 'Update contact information';
        $data['info_translate'] = Article::getArticleTitle(2);
        $data['info']           = Article::getContact();

        return view('admin.contact_form')->with($data);       
    }

    public function contactUpdate(Request $request)
    {
        extract($request->input());

        $count_lang = count(array_filter($langId));
        $count_tran = count(array_filter($articleTId));

        $val_update = array('con_title'  => $articleTitle[0],
                            'con_remark' => $articleMap,
                            'meta_key'   => $articleMetakey,
                            'meta_des'   => $articleMetades,
                            'updated_at' => date('Y-m-d H:i:s'));

        $up_article = DB::table('tbl_content')->where('con_id', '=', $articleId)->update($val_update);

        if($up_article == 1){
          
            if($count_lang <= $count_tran):
                
                for($i=0; $i<count($langId); $i++){
                    if(empty($articleTitle[$i]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$i];

                    if(empty($articleDes[$i]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$i]; 

                    DB::table('tbl_content_translate')
                        ->where('ctt_id', '=', $articleTId[$i])
                        ->update(['ctt_title' => $title, 'ctt_des' => $des]);
                }

            else:

                for($i=0; $i<$count_tran; $i++){

                    if(empty($articleTitle[$i]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$i]; 

                    if(empty($articleDes[$i]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$i]; 

                    DB::table('tbl_content_translate')
                        ->where('cct_id', '=', $articleTId[$i])
                        ->update(['cct_title' => $title, 'ctt_des' => $des]);
                        
                }
                // Language more than title
                for($k=$count_tran; $k<$count_lang; $k++){

                    if(empty($articleTitle[$k]))  $title = 'No Translate';
                    else                          $title = $articleTitle[$k]; 

                    if(empty($articleDes[$k]))    $des   = 'No Translate';
                    else                          $des   = $articleDes[$k];

                    DB::table('tbl_content_translate')
                        ->insert(['con_id' => $articleId, 'ctt_title' => $title, 'ctt_des' => $des, 'lang_id' => $langId[$k]]);
                } 
            endif;
            Session::flash('msg', '<div class="alert alert-success" role="alert">Contact information have been updated <b>successful</b></div>');
        }else{
            Session::flash('msg', '<div class="alert alert-danger" role="alert">Contact information was updated <b>fail</b></div>');
        }

        return redirect()->back();
    }
}
