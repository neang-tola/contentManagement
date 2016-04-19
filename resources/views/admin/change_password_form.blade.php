@extends('layouts.master_admin')
@section('main_content')
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <section class="panel">
                  <header class="panel-heading">{{ @$heading_title }}</header>
                  <div class="panel-body">
                    <div class="form">
                        {!! Session::get('msg') !!} 

                        {!! Form::open(['url' => route('admin.update.password'), 'class' => 'form-validate form-horizontal', 'id' => 'form_password', 'onsubmit' => 'return isValidate_form_password()']) !!}

                            <div class="form-group">
                                <label for="currentPassword" class="control-label col-lg-2 col-md-4 col-sm-4">Your Current Password </label>
                                <div class="col-lg-6 col-md-4 col-sm-4">
                                    <input type="password" name="currentPassword" id="currentPassword" class="form-control" />
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <span class="error" id="err_current"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newPassword" class="control-label col-lg-2 col-md-4 col-sm-4">New Password </label>
                                <div class="col-lg-6 col-md-4 col-sm-4">
                                    <input type="password" name="newPassword" class="form-control" id="newPassword" />
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <span class="error" id="err_new"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword" class="control-label col-lg-2 col-md-4 col-sm-4">Confirm Password</label>
                                <div class="col-lg-6 col-md-4 col-sm-4">
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control"/>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <span class="error" id="err_confirm"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-primary" type="submit">Update</button>
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
<script src="{{ URL::asset('public/backend/js/component/form-validation-changepwd.js') }}"></script>
@endsection