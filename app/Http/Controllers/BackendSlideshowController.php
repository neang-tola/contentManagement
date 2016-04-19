<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Models\BackendSlideModel as Slide;
use App\Http\Requests;
use AdminHelper;
use Validator;
use Session;

class BackendSlideshowController extends Controller
{
    public function index()
    {
        $data['title']          = 'Manage Slideshow list';
        $data['breadcrumb']     = AdminHelper::breadcrumb([route('admin.slideshow.list') => 'Manage Slideshow']);
        $data['ind']            = 1;
        $data['slide_info']     = Slide::getAllSlide(20);
        //$data['slide_info']->setPath('internal-bkn/loading-slideshow-list');

        return view('admin.slide_list')->with($data);
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

        $slideshow_info     = Slide::getAllSlide($perpage, $offset);

        if(!empty($slideshow_info)):
            foreach($slideshow_info as $slide):
                if($slide->img_status == 0){
                    $status = '<span class="status-s" id="status-'. $slide->img_id .'-1"><i class="inactive-button"></i></span>';
                }else{
                    $status = '<span class="status-s" id="status-'. $slide->img_id .'-0"><i class="active-button"></i></span>';
                }
                $print_result .= '
                                <tr>
                                  <td>'. ++$offset .'</td>
                                  <td class="images"><img src="'. url('public/slideshows/'.$slide->img_name) .'" /></td>
                                  <td>
                                    <span class="order">'. $slide->img_sequense .'</span>
                                  </td>
                                  <td>'. date('d F, Y', strtotime($slide->created_at)) .'</td>
                                  <td>'. $status .'</td>
                                  <td><i class="del-button" id="del-'. $slide->img_id .'"></i></td>
                                </tr>
                            ';
            endforeach;
        endif;

        echo $print_result;
    }

    public function store(Request $request)
    {
        $msg   = '';
        $image = $request->file('slide_upload');

        $rules = array('slide' => 'required|mimes:png,gif,jpeg');
        $validator = Validator::make(array('slide'=> $image), $rules);

          if ($validator->fails()) {
            // send back to the page with the input data and errors
            $msg = '<div class="alert alert-danger" role="alert">Slideshow image upload <b>fail</b></div>';
          }else {
            // checking file is valid.
            if ($image->isValid()) {
              $img_slide = Slide::uploadSlideShow($image, 'public/slideshows');
              
              if(empty($img_slide)){
                $msg = '<div class="alert alert-danger" role="alert">Slideshow image upload <b>fail</b></div>';
              }else{ 
                // sending back with message
                Slide::insertImage($img_slide);
                $msg = '<div class="alert alert-success" role="alert">Slideshow have been uploaded <b>successful</b></div>'; 
              }
            }
            else {
              // sending back with error message.
              $msg = '<div class="alert alert-danger" role="alert">Slideshow uploaded image is not valid <b>error</b></div>';
            }
          }

          Session::flash('msg', $msg);
          return redirect()->back();
    }

    public function reOrder()
    {
        $user_order   = Input::get('up_order');
        $up_order     = explode('-', $user_order);
        $print_result = '';
        $ind  = 0;

        if(count($up_order) == 2){
            $order    = Slide::updateOrder($up_order[1], $up_order[0]);
            if($order == true){
                $slideshow_info     = Slide::getAllSlide(20);
    
                foreach($slideshow_info as $slide):
                    if($slide->img_status == 0){
                        $status = '<span class="status-s" id="status-'. $slide->img_id .'-1"><i class="inactive-button"></i></span>';
                    }else{
                        $status = '<span class="status-s" id="status-'. $slide->img_id .'-0"><i class="active-button"></i></span>';
                    }
                    $print_result .= '
                                    <tr>
                                      <td>'. ++$ind .'</td>
                                      <td class="images"><img src="'. url('public/slideshows/'.$slide->img_name) .'" /></td>
                                      <td>
                                        <span class="order">'. $slide->img_sequense .'</span>
                                      </td>
                                      <td>'. date('d F, Y', strtotime($slide->created_at)) .'</td>
                                      <td>'. $status .'</td>
                                      <td><i class="del-button" id="del-'. $slide->img_id .'"></i></td>
                                    </tr>
                                ';
                endforeach;
       
            }
        } // End count number param past from ajax

        echo $print_result;
    }

    public function destroy()
    {
        $slide_delete    = Input::get('did');

        if(is_numeric($slide_delete)){
            Slide::removeImage($slide_delete);
            $destroy    = Slide::where('img_id', '=', $slide_delete)->delete();

            if($destroy == 1):
                echo 'success';
            else:
                echo 'error';
            endif;     
        }
    }

    public function updateStatus()
    {
        $slide_status  = explode('-', Input::get('sid'));
   
        if(count($slide_status) == 2){
            $slideshow = Slide::where('img_id', '=', $slide_status[0])
                       ->update(['img_status' => $slide_status[1]]);

            if(!empty($slideshow)):
                echo 'success';
            else:
                echo 'error';
            endif;
        }
    }
}
