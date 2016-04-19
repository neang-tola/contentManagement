@extends('layouts.master_admin')
@section('main_content')
             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.subcategory.search'), 'class' => 'navbar-form', 'id' => 'find_sub_category']) !!}
                              {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'key_word']) !!}
                            {!! Form::close() !!}
                            <div class="pull-right">
                              <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">New Sub Category</a>
                            </div>
                            <div class="clearfix"></div>
                          </header>
                    
                          <div class="table-responsive">
                            <div class="loading"></div>
                            <table class="table" id="result_output">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="50%">{{ strtoupper(Session::get('category')['ctitle']) }}</th>
                                  <th width="15%">Created at</th>
                                  <th width="10%">Status</th>
                                  <th width="10%">Edit</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                            @foreach($sub_category_info as $cat)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td>|&rarr; <span class="category-title">{{ $cat->ctd_title }}</span></td>
                                  <td>{{ date('d F, Y', strtotime($cat->created_at)) }}</td>
                              @if($cat->ctd_status == 0)
                                  <td><span class="status-c" id="status-{{ $cat->ctd_id }}-1"><i class="inactive-button"></i></span></td>
                              @else
                                  <td><span class="status-c" id="status-{{ $cat->ctd_id }}-0"><i class="active-button"></i></span></td>
                              @endif
                                  <td><a href="{{ route('admin.subcategory.edit') }}?cid={{ $cat->ctd_id }}"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-{{ $cat->ctd_id }}"></i></td>
                                </tr>  
                            @endforeach
                    
                              </tbody>
                            </table>
                          </div>
                      
                      </section>

                      <nav id="list-pagin">
                      {!! @$sub_category_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? The sub category "<span></span>", you will remove from sub category list.</p>
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
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-sub-category.js') }}"></script>
@endsection