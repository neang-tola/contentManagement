@extends('layouts.master_admin')
@section('main_content')

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <section class="panel">
                  <header class="panel-heading">{{ @$heading_title }}</header>
                  <div class="panel-body">
                    <div class="form">
                        {!! Session::get('msg') !!}
                        {!! Form::open(['url' => route('admin.menu.insert'), 'class' => 'form-validate form-horizontal', 'id' => 'form_menu',  'onsubmit' => 'return isValidate_form_menu()']) !!}
                          @if($title_lang['lang_count'] == 1)
                              <div class="form-group">
                                  <label for="menuTitle" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Title <span class="required">*</span></label>
                                  <div class="col-lg-6 col-md-4 col-sm-4">
                                  @foreach($title_lang['lang_info'] as $lang_val)
                                      <input type="hidden" name="langId" value="{{ $lang_val->lang_id }}" />
                                  @endforeach
                                      <input class="form-control" id="menuTitle" name="menuTitle[]" type="text"  />
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
                                                      <input type="hidden" name="langId[]" value="'. @$lang_val->lang_id .'"/>
                                                      <input class=" form-control" id="menuTitle" name="menuTitle[]" type="text" />
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
                                                      <input class="form-control" id="menuTitle-'.@$lang_val->lang_id.'" name="menuTitle[]" type="text" />
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
                                              {!! Form::select('menuParent', AdminHelper::controlParent(), null, ['class' => 'form-control', 'id' => 'menuParent']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuTypeLink" class="control-label col-lg-2 col-md-4 col-sm-4">Type of Link <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuTypeLink', AdminHelper::controlTypeLink(), null, ['class' => 'form-control', 'id' => 'menuTypeLink']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuLink" class="control-label col-lg-2 col-md-4 col-sm-4 internal">Menu Link <span class="required">*</span></label>
                                          <label for="menuLink" class="control-label col-lg-2 col-md-4 col-sm-4 external">External URL <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              <input type="hidden" id="menuId" name="menuId" />
                                              <input class=" form-control" id="menuLink" name="menuLink" type="text" />
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                            <span class="error" id="err_link"></span>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuPosition" class="control-label col-lg-2 col-md-4 col-sm-4">Position <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuPosition', AdminHelper::controlPosition(), 1, ['class' => 'form-control', 'id' => 'menuPosition']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuStatus" class="control-label col-lg-2 col-md-4 col-sm-4">Menu Status <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuStatus', AdminHelper::controlStatus(), 0, ['class' => 'form-control', 'id' => 'menuStatus']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group internal">
                                          <label for="menuContentType" class="control-label col-lg-2 col-md-4 col-sm-4">Content Type <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuContentType', AdminHelper::controlContentType(), 4, ['class' => 'form-control', 'id' => 'menuContentType']) !!}
                                          </div>
                                      </div>
                                      <div class="form-group internal">
                                          <label for="menuContent" class="control-label col-lg-2 col-md-4 col-sm-4">Content <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              {!! Form::select('menuContent', $content_info, null, ['class' => 'form-control', 'id' => 'menuContent']) !!}
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                            <span class="error" id="err_content"></span>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="menuOrder" class="control-label col-lg-2 col-md-4 col-sm-6">Menu Order <span class="required">*</span></label>
                                          <div class="col-lg-6 col-md-4 col-sm-4">
                                              <input type="text" class="form-control" name="menuOrder" id="menuOrder" value="{{ $max_order }}" />
                                          </div>
                                          <div class="col-lg-4 col-md-4 col-sm-4 padtop">
                                              <span class="error" id="err_order"></span>
                                          </div>
                                      </div>                                  
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <button class="btn btn-primary" type="submit">Save New</button>
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