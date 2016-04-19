@extends('layouts.master_admin')
@section('main_content')
             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.gallery.search'), 'class' => 'navbar-form', 'id' => 'find_gallery']) !!}
                              {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'key_word']) !!}
                            {!! Form::close() !!}
                            <div class="pull-right">
                              <button class="btn btn-primary" id="new-button">New Gallery</button>
                            </div>
                            <div class="clearfix"></div>
                          </header>
                    
                          <div class="table-responsive">
                            <div class="loading"></div>
                            <table class="table" id="result_output">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="40%">Title</th>
                                  <th width="15%">Created Date</th>
                                  <th width="10%">Status</th>
                                  <th width="10%">Add Item</th>
                                  <th width="10%">Edit</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                            @foreach($gallery_info as $gal)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td><span class="gallery-title">{{ $gal->gal_title }}</span></td>
                                  <td>{{ date('d F, Y', strtotime($gal->created_at)) }}</td>
                              @if($gal->gal_status == 0)
                                  <td><span class="status-g" id="status-{{ $gal->gal_id }}-1"><i class="inactive-button"></i></span></td>
                              @else
                                  <td><span class="status-g" id="status-{{ $gal->gal_id }}-0"><i class="active-button"></i></span></td>
                              @endif
                                  <td><i class="gallery-add-button" id="gallery-{{ $gal->gal_id }}"></i></td>
                                  <td><i class="edit-button" id="edit-{{ $gal->gal_id }}"></i></td>
                                  <td><i class="del-button" id="del-{{ $gal->gal_id }}"></i></td>
                                </tr>  
                            @endforeach
                                <tr><td colspan="7">&nbsp;</td></tr>
                              </tbody>
                            </table>
                          </div>
                      
                      </section>

                      <nav id="list-pagin">
                      {!! @$gallery_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? The gallery "<span></span>", you will remove from article list.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirm-ok">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-gallery.js') }}"></script>
@endsection