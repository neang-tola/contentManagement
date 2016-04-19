<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Models\BackendGalleryModel as Gallery;
use App\Http\Requests;
use AdminHelper;
use Validator;
use Session;

class BackendGalleryController extends Controller
{
    public function index()
    {
        $data['title']          = 'Manage Gallery list';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.gallery.list') => 'Manage Gallery']);

        $data['ind']            = 1;
        $data['gallery_info']   = Gallery::getAllGallery(20);
        $data['gallery_info']->setPath('internal-bkn/loading-gallery-list');

        return view('admin.gallery_list')->with($data);
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

        $gallery_info       = Gallery::getAllGallery($perpage, $offset);

        if(!empty($gallery_info)):
            foreach($gallery_info as $gal):
                if($gal->gal_status == 0){
                    $status = '<span class="status-g" id="status-'. $gal->gal_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-g" id="status-'. $gal->gal_id .'-0"><i class="active-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td><span class="gallery-title">'. $gal->gal_title .'</span></td>
                                  <td>'. date('d F, Y', strtotime($gal->created_at)) .'</td>
                                  <td>'. $status .'</td>
                                  <td><i class="gallery-add-button" id="gallery-'. $gal->gal_id .'"></i></td>
                                  <td><i class="edit-button" id="edit-'. $gal->gal_id .'"></i></td>
                                  <td><i class="del-button" id="del-'. $gal->gal_id .'"></i></td>
                                </tr>
                            ';
            endforeach;
        endif;

        echo $print_result;
    }

    public function store()
    {
        $gallery_val  = Input::get('int_title');
        $gallery_id   = Input::get('gid');
        
        $print_result = '';
        $ind = 0;

        if(!empty($gallery_val)){

            if(is_numeric($gallery_id)){ // update gallery
                $my_gallery = Gallery::updateGallery($gallery_id, $gallery_val);
            }else{
                $my_gallery = Gallery::insertGallery($gallery_val);
            }

            if($my_gallery == true)
            {
                $gallery_info = Gallery::getAllGallery(20);
                foreach($gallery_info as $gal):
                    if($gal->gal_status == 0){
                        $status = '<span class="status-g" id="status-'. $gal->gal_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-s" id="status-'. $gal->gal_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="gallery-title">'. $gal->gal_title .'</span></td>
                                      <td>'. date('d F, Y', strtotime($gal->created_at)) .'</td>
                                      <td>'. $status .'</td>
                                      <td><i class="gallery-add-button" id="gallery-'. $gal->gal_id .'"></i></td>
                                      <td><i class="edit-button" id="edit-'. $gal->gal_id .'"></i></td>
                                      <td><i class="del-button" id="del-'. $gal->gal_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            }
        }
        echo $print_result;
    }

    public function search(Request $request)
    {
        $search_val   = $request->input('search');
        $print_result = '';
        $ind = 0;

        if(!empty($search_val)){
            $result_search = Gallery::findGallery($search_val);

            if(!empty($result_search)):
                foreach($result_search as $gal):
                    if($gal->gal_status == 0){
                        $status = '<span class="status-g" id="status-'. $gal->gal_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-s" id="status-'. $gal->gal_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="gallery-title">'. $gal->gal_title .'</span></td>
                                      <td>'. date('d F, Y', strtotime($gal->created_at)) .'</td>
                                      <td>'. $status .'</td>
                                      <td><i class="gallery-add-button" id="gallery-'. $gal->gal_id .'"></i></td>
                                      <td><i class="edit-button" id="edit-'. $gal->gal_id .'"></i></td>
                                      <td><i class="del-button" id="del-'. $gal->gal_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
            else:
                $print_result .= '<tr><td colspan="7">
                                    <div class="alert alert-info"><strong>Not found</strong> your key word search not match to Gallery title.</div>
                                 </td></tr>';
            endif;
        }else{

                $gallery_info = Gallery::getAllGallery(20);

                foreach($gallery_info as $gal):
                    if($gal->gal_status == 0){
                        $status = '<span class="status-g" id="status-'. $gal->gal_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-s" id="status-'. $gal->gal_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td><span class="gallery-title">'. $gal->gal_title .'</span></td>
                                      <td>'. date('d F, Y', strtotime($gal->created_at)) .'</td>
                                      <td>'. $status .'</td>
                                      <td><i class="gallery-add-button" id="gallery-'. $gal->gal_id .'"></i></td>
                                      <td><i class="edit-button" id="edit-'. $gal->gal_id .'"></i></td>
                                      <td><i class="del-button" id="del-'. $gal->gal_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;     
        }

        echo $print_result;
    }

    public function destroy()
    {
        $gal_delete     = Input::get('did');

        if(is_numeric($gal_delete)){
            // Remove group of image in this gallery
            Gallery::removeImageGroup($gal_delete);
            $destroy    = Gallery::where('gal_id', '=', $gal_delete)->delete();

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }
    }

    public function updateStatus()
    {
        $gal_status  = explode('-', Input::get('gid'));
   
        if(count($gal_status) == 2){
            $gallery = Gallery::where('gal_id', '=', $gal_status[0])
                       ->update(['gal_status' => $gal_status[1]]);

            if(!empty($gallery)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }

    public function addPhoto($id)
    {
        if(!empty($id)){
            $data['title']         = "Add Photo to Gallery";
            $data['breadcrumb']    = AdminHelper::breadcrumb([route('admin.gallery.list') => 'Manage Gallery', route('admin.gallery.addphoto', $id) => 'Add Items']);
            $data['gallery_title'] = Gallery::getGalleryTitle($id);
            $data['photos']        = Gallery::getAllImages($id);

            return view('admin.gallery_info_detail')->with($data);
        }
    }

    public function insertPhoto()
    {
        $msg       = '';
        $jdata     = array();
        $gallery_id= Input::get('gallery_id');
        $file_img  = Input::file('photo');

        $rules     = array('gallery' => 'required|mimes:png,gif,jpeg');
        $validator = Validator::make(array('gallery'=> $file_img), $rules);

          if ($validator->fails()) {
            // send back to the page with the input data and errors
            $msg = 'Your Photo gallery uploaded fail';
          }else {
            // checking file is valid.
            if ($file_img->isValid()) {
              $img_photo = Gallery::uploadPhoto($file_img, 'public/gallery', 'public/gallery/thumb');
              
              if(empty($img_photo)){
                $msg = 'Your Photo gallery uploaded fail';
              }else{ 
                // sending back with message
                Gallery::insertImage($gallery_id, $img_photo);
              }
            }
            else {
              // sending back with error message.
              $msg = 'Your Photo gallery image is not valid.';
            }
          }

        if($msg == ''){
            $html  = '<div class="col-lg-3 col-md-4 col-xs-6 thumb">';
            $html .= '<div class="thumbnail">';
            $html .= '<img class="img-responsive" src="'.url('public/gallery/thumb/'.$img_photo).'" id="photo-'. Gallery::getLastId() .'"/>';
            $html .= '</div>';
            $html .= '</div>';

            $jdata = ['status' => 'success', 'response' => $html];
        }else{
            $jdata = ['status' => 'error', 'response' => $msg];
        }

        echo json_encode($jdata);
    }

    public function removePhoto()
    {
        $photo_delete   = Input::get('did');

        if(is_numeric($photo_delete)){
            $destroy    = Gallery::removeImage($photo_delete);

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }  
    }
}
