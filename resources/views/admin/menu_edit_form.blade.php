@extends('layouts.master_admin')
@section('main_content')
<?php 
    // Check External Link condition
    if($info->m_link_type == 'internal'){
        $in_block = 'style="display: block;"';
        $ex_block = 'style="display: none;"';
    }else{
        $in_block = 'style="display: none;"';
        $ex_block = 'style="display: block;"';
    }
?>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <section class="panel">
                  <header class="panel-heading">{{ @$heading_title }}</header>
                  <div class="panel-body">
                    <div class="form">
                        {!! Session::get('msg') !!} 

                        {!! Form::open(['url' => route('admin.menu.update'), 'class' => 'form-validate form-horizontal', 'id' => 'form_menu',  'onsubmit' => 'return isValidate_form_menu()']) !!}
                          @if($title_lang['lang_count'] == 1)
                              <div class="form-group">
                                  <label for="menuTitle" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Title <span class="required">*</span></label>
                                  <div class="col-lg-6 col-md-4 col-sm-4">
                                  @foreach($title_lang['lang_info'] as $lang_val)
                                      <input type="hidden" name="langId[]" value="{{ $lang_val->lang_id }}" />
                                      <input type="hidden" name="menuTId[]" value="{{ $lang_val->mnt_id }}" />
                                      <input class="form-control" id="menuTitle" name="menuTitle[]" type="text" value="{{ $lang_val->mnt_title }}" />
                                  @endforeach
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                    <span class="error" id="err_title"></span>
                                  </div>
                              </div>
                          @else
                              <div class="form-tab">
                              <?php
                                $i  = 1;
                                $print_li      = '';
                                $print_content = '';

                                foreach($title_lang['lang_info'] as $lang_val){

                                  if($i == 1){
                                    $print_li .= '
                                                <li class="active">
                                                  <a href="#tab-'. strtolower(@$lang_val->lang_title) .'" data-toggle="tab">'. @$lang_val->lang_title .'</a>
                                                </li>';
                                    $print_content .= '
                                                <div id="tab-'. strtolower(@$lang_val->lang_title) .'" class="tab-pane active">
                                                  <label for="menuTitle" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Title <span class="required">*</span></label>
                                                  <div class="col-lg-6 col-md-4 col-sm-4">
                                                      <input type="hidden" name="langId[]" value="'. @$lang_val->lang_id .'" />
                                                      <input type="hidden" name="menuTId[]" value="'. @$lang_val->mnt_id .'" />
                                                      <input class=" form-control" id="menuTitle" name="menuTitle[]" type="text" value="'.@$lang_val->mnt_title.'" />
                                                  </div>
                                                  <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                                    <span class="error" id="err_title"></span>
                                                  </div>
                                                </div>';
                                  }else{
                                    $print_li .= '
                                                <li class="">
                                                  <a href="#tab-'. strtolower(@$lang_val->lang_title) .'" data-toggle="tab">'. @$lang_val->lang_title .'</a>
                                                </li>';
                                    $print_content .= '
                                                <div id="tab-'. strtolower(@$lang_val->lang_title) .'" class="tab-pane">
                                                  <label for="menuTitle-'.@$lang_val->lang_id.'" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Title</label>
                                                  <div class="col-lg-6 col-md-4 col-sm-4">
                                                      <input type="hidden" name="langId[]" value="'. @$lang_val->lang_id .'" />
                                                      <input type="hidden" name="menuTId[]" value="'. @$lang_val->mnt_id .'" />
                                                      <input class="form-control" id="menuTitle-'.@$lang_val->lang_id.'" name="menuTitle[]" type="text" value="'.@$lang_val->mnt_title.'" />
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
                                          <label for="menuParent" class="control-label col-lg-2 col-md-4 col-sm-4">Parent Menu <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuParent', AdminHelper::controlParent($info->m_parent, $info->m_id), $info->m_parent, ['class' => 'form-control', 'id' => 'menuParent']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuTypeLink" class="control-label col-lg-2 col-md-4 col-sm-4">Type of Link <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuTypeLink', AdminHelper::controlTypeLink(), $info->m_link_type, ['class' => 'form-control', 'id' => 'menuTypeLink']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuLink" class="control-label col-lg-2 col-md-4 col-sm-4 internal" {!! $in_block !!}>Menu Link <span class="required">*</span></label>
                                          <label for="menuLink" class="control-label col-lg-2 col-md-4 col-sm-4 external" {!! $ex_block !!}>External URL <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              <input type="hidden" id="menuId" name="menuId" value="{{ $info->m_id }}" />
                                              <input class=" form-control" id="menuLink" name="menuLink" type="text" value="{{ $info->m_link }}" />
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                            <span class="error" id="err_link"></span>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuPosition" class="control-label col-lg-2 col-md-4 col-sm-4">Position <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuPosition', AdminHelper::controlPosition(), $info->m_post, ['class' => 'form-control', 'id' => 'menuPosition']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuStatus" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Status <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuStatus', AdminHelper::controlStatus(), $info->m_status, ['class' => 'form-control', 'id' => 'menuStatus']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group internal" {!! $in_block !!}>
                                          <label for="menuContentType" class="control-label col-lg-2 col-md-4 col-sm-4">Content Type <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuContentType', AdminHelper::controlContentType(), $info->cnt_id, ['class' => 'form-control', 'id' => 'menuContentType']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group internal" {!! $in_block !!}>
                                          <label for="menuContent" class="control-label col-lg-2 col-md-4 col-sm-4">Content <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              <div class="loading-bar"></div>
                                              {!! Form::select('menuContent', $content_info, $info->con_id, ['class' => 'form-control', 'id' => 'menuContent']) !!}
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                            <span class="error" id="err_content"></span>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuOrder" class="control-label col-lg-2 col-md-4 col-sm-6">Menu Order <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              <input type="text" class="form-control" name="menuOrder" id="menuOrder" value="{{ @$info->m_sequense }}" />
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                              <span class="error" id="err_order"></span>
                                          </div>
                                      </div> 
                                                                     
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
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
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/form-validation-menu.js') }}"></script>
@endsection