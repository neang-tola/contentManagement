@extends('layouts.master_admin')
@section('main_content')

             <div class="row">
                  <div class="col-lg-12">
                      {!! Session::get('msg') !!}
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.slideshow.insert'), 'class' => 'navbar-form-image', 'id' => 'up_slide', 'files'=>true]) !!}
                              <label>Image Slideshow (width: 1200px) </label>
                              <input id="uploadFile" class="form-control" placeholder=" Choose image slideshow" disabled="disabled" />
                              <span class="btn btn-default btn-file">
                                  Browse <input type="file" class="upload" name="slide_upload" id="slide_upload" />
                              </span>
                              <button type="submit" class="btn btn-primary" id="btn-upload">Upload Slideshow</button>
                            {!! Form::close() !!}
                          </header>
                          <div class="table-responsive">
                            <div class="loading"></div>
                            <table class="table" id="result_output">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="45%">Image</th>
                                  <th width="10%">Order</th>
                                  <th width="20%">Create Date</th>
                                  <th width="10%">Status</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                        @foreach($slide_info as $slide)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td class="images"><img src="/public/slideshows/{{ $slide->img_name }}" /></td>
                                  <td><span class="order">{{ $slide->img_sequense }}</span></td>
                                  <td>{{ date('d F, Y', strtotime($slide->created_at)) }}</td>
                              @if($slide->img_status == 0)
                                  <td><span class="status-s" id="status-{{ $slide->img_id }}-1"><i class="inactive-button"></i></span></td>
                              @else
                                  <td><span class="status-s" id="status-{{ $slide->img_id }}-0"><i class="active-button"></i></span></td>
                              @endif
                                  <td><i class="del-button" id="del-{{ $slide->img_id }}"></i></td>
                                </tr>  
                        @endforeach
                              </tbody>
                            </table>
                          </div>
 
                      </section>

                      <nav id="list-pagin">
                      {!! @$slide_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? You want remove this image from slideshow list.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirm-ok">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="view-image" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-show"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="close-img"></i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-slideshow.js') }}"></script>
@endsection