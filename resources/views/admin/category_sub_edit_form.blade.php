@extends('layouts.master_admin')
@section('main_content')
          <!--overview start-->
              
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <section class="panel">
                  <header class="panel-heading">{{ @$heading_title }}</header>
                  <div class="panel-body">
                    <div class="form">
                        {!! Session::get('msg') !!} 

                        {!! Form::open(['url' => route('admin.subcategory.update'), 'class' => 'form-validate form-horizontal', 'id' => 'form_sub_category',  'onsubmit' => 'return isValidate_form_category()', 'files' => true]) !!}
                          @if($info_translate['lang_count'] == 1)
                              <div class="form-group">
                                  <label for="categoryTitle" class="control-label col-lg-2 col-md-4 col-sm-4">Category Title <span class="required">*</span></label>
                                  <div class="col-lg-6 col-md-4 col-sm-4">
                                  @foreach($info_translate['lang_info'] as $lang_val)
                                      <input type="hidden" name="langId[]" value="{{ $lang_val->lang_id }}" />
                                      <input type="hidden" name="categoryTId[]" value="{{ $lang_val->ctdt_id }}" />
                                      <input class="form-control" id="categoryTitle" name="categoryTitle[]" type="text" value="{{ $lang_val->ctdt_title }}" />
                                  @endforeach
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                    <span class="error" id="err_title"></span>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="categoryDes" class="control-label col-lg-2 col-md-4 col-sm-4"> 
                                    Description <span class="required">*</span>
                                    <div><span class="error" id="err_des"></span></div>
                                  </label>
                                  <div class="col-lg-10 col-md-8 col-sm-8">
                                      <textarea class="form-control categoryDes" id="categoryDes" name="categoryDes[]" >{{ @$lang_val->ctdt_des }}</textarea>
                                  </div>
                              </div>
                          @else
                              <div class="form-tab">
                              <?php
                                $i  = 1;
                                $print_li      = '';
                                $print_content = '';

                                foreach($info_translate['lang_info'] as $lang_val){

                                  if($i == 1){
                                    $print_li .= '
                                                <li class="active">
                                                  <a href="#tab-'. strtolower(@$lang_val->lang_title) .'" data-toggle="tab">'. @$lang_val->lang_title .'</a>
                                                </li>';
                                    $print_content .= '
                                                <div id="tab-'. strtolower(@$lang_val->lang_title) .'" class="tab-pane active">
                                                  <div class="form-group">
                                                    <label for="categoryDes" class="control-label col-lg-2 col-md-4 col-sm-4"> 
                                                      Category Title <span class="required">*</span>
                                                    </label>
                                                    <div class="col-lg-6 col-md-4 col-sm-4">
                                                        <input type="hidden" name="langId[]" value="'. @$lang_val->lang_id .'" />
                                                        <input type="hidden" name="categoryTId[]" value="'. @$lang_val->ctdt_id .'" />
                                                        <input class=" form-control" id="categoryTitle" name="categoryTitle[]" type="text" value="'.@$lang_val->ctdt_title.'" />
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                                      <span class="error" id="err_title"></span>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="categoryDes" class="control-label col-lg-2 col-md-4 col-sm-4"> 
                                                      Description <span class="required">*</span>
                                                      <div><span class="error" id="err_des"></span></div>
                                                    </label>
                                                    <div class="col-lg-10 col-md-8 col-sm-8">
                                                        <textarea class="form-control categoryDes" id="categoryDes" name="categoryDes[]">' .@$lang_val->ctdt_des .'</textarea>
                                                    </div>
                                                  </div>
                                                </div>';
                                  }else{
                                    $print_li .= '
                                                <li class="">
                                                  <a href="#tab-'. strtolower(@$lang_val->lang_title) .'" data-toggle="tab">'. @$lang_val->lang_title .'</a>
                                                </li>';
                                    $print_content .= '
                                                <div id="tab-'. strtolower(@$lang_val->lang_title) .'" class="tab-pane">
                                                  <div class="form-group">
                                                    <label for="categoryTitle" class="control-label col-lg-2 col-md-4 col-sm-4">Category Title </label>
                                                    <div class="col-lg-6 col-md-4 col-sm-4">
                                                        <input type="hidden" name="langId[]" value="'. @$lang_val->lang_id .'" />
                                                        <input type="hidden" name="categoryTId[]" value="'. @$lang_val->ctdt_id .'" />
                                                        <input class="form-control" name="categoryTitle[]" type="text" value="'.@$lang_val->ctdt_title.'" />
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="categoryDes" class="control-label col-lg-2 col-md-4 col-sm-4"> Description </label>
                                                    <div class="col-lg-10 col-md-8 col-sm-8">
                                                        <textarea class="form-control categoryDes" name="categoryDes[]" >' .@$lang_val->ctdt_des .'</textarea>
                                                    </div>
                                                  </div>
                                                </div>';
                                  }
                                  $i++;
                                }
                              ?>
                                <!--start tab-->
                                <section class="panel">
                                    <header class="panel-heading tab-bg-primary ">
                                        <ul class="nav nav-tabs">
                                          {!! $print_li !!}
                                        </ul>
                                      </header>
                                      <div class="panel-body">
                                        <div class="tab-content">
                                          {!! $print_content !!}
                                        </div>
                                      </div>
                                  </section>
                                  <!-- end tab -->
                                </div>
                          @endif
                                      <div class="form-group">
                                          <label for="categoryImage" class="control-label col-lg-2 col-md-4 col-sm-4">Category Image </label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                            <div class="btn-file-image">
                                              <span class="btn btn-default col-lg-2 col-md-4 col-sm-4">
                                                  Browse <input type="file" class="upload" name="categoryImage" id="categoryImage" />
                                              </span>
                                              <span class="col-lg-10 col-md-8 col-sm-8 padding-none">
                                                  <input id="uploadFile" class="form-control" placeholder="Choose image" disabled="disabled" />
                                              </span>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4">
                                              <input type="hidden" name="categoryId" value="{{ $info->ctd_id }}" /> 
                                              @if(!empty($info->ctd_image))
                                                <img src="/public/categories/sub/thumb/{{ $info->ctd_image }}" height="35px" />
                                              @endif
                                          </div>
                                      </div>                          
                                      <div class="form-group">
                                          <label for="categoryStatus" class="control-label col-lg-2 col-md-4 col-sm-4">Category Status </label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('categoryStatus', AdminHelper::controlStatus(), $info->ctd_status, ['class' => 'form-control', 'id' => 'categoryStatus']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="categoryOrder" class="control-label col-lg-2 col-md-4 col-sm-4">Order <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::text('categoryOrder', $info->ctd_sequense, ['class' => 'form-control', 'id' => 'categoryOrder']) !!}
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4">
                                              <span class="error" id="err_order"></span>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-8">
                                              <button class="btn btn-primary" type="submit">Save Change</button>
                                              <button class="btn btn-default" type="reset">Cancel</button>
                                          </div>
                                      </div>
                                  {!! Form::close() !!}
                              </div>
                          </div>
                      </section>
                  </div>
          </div> <!-- End Row  -->

<div class="modal fade modal-custom" id="modal-message" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Image Category error</h4>
      <div class="modal-body">
        <p>Image allow only extension JPG, PNG and GIF, with maximum file size 2MB.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('public/backend/js/component/form-validation-category.js') }}"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

<script>
  $('textarea.categoryDes').ckeditor({
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
  });
</script>
@endsection