@extends('layouts.master_admin')
@section('main_content')
 
             <div class="row">
                  <div class="col-lg-12">
                    
                      <section class="panel">
                          <header class="panel-heading">
                              <h3>Add Photo to gallery <b>{{ $gallery_title->gal_title }}</b></h3>
                          </header>

                          <div class="panel-body"> 
                            {!! Form::open(['url' => route('admin.gallery.insert.photo'), 'class' => 'navbar-form-image', 'id' => 'photo_gallery', 'files'=>true]) !!}
                              <label>Add Image Gallery </label>
                              <input id="uploadFile" class="form-control" placeholder="Choose your photo" disabled="disabled" />
                              <span class="btn btn-default btn-file">
                                  <input type="hidden" value="{{ $gallery_title->gal_id }}" name="gallery_id" />
                                  Browse Photo <input type="file" class="upload" name="photo" id="photo_upload" />
                              </span>
                              <button type="submit" class="btn btn-primary" id="btn-upload">Upload</button>
                            {!! Form::close() !!}

                            <div class="row" id="gallery-list">
                            @if(!empty($photos))
                              @foreach($photos as $photo)
                                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                    <div class="thumbnail">
                                        <img class="img-responsive" src="/public/gallery/thumb/{{ $photo->img_name }}" id="photo-{{ $photo->img_id }}">
                                    </div>
                                </div>
                              @endforeach
                            @else
                              <div></div>
                            @endif
                            </div>
                          </div>
                      </section>
                    
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? You want remove this photo from your gallery.</p>
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
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-upload-gallery.js') }}"></script>
@endsection