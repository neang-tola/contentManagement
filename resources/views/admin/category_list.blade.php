@extends('layouts.master_admin')
@section('main_content')
             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.category.search'), 'class' => 'navbar-form', 'id' => 'find_category']) !!}
                              {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'key_word']) !!}
                            {!! Form::close() !!}
                            <div class="pull-right">
                              <a href="{{ route('admin.category.create') }}" class="btn btn-primary">New Category</a>
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
                                  <th width="10%">Additional Sub</th>
                                  <th width="10%">Show front</th>
                                  <th width="10%">Status</th>
                                  <th width="10%">Edit</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                            @foreach($category_info as $cat)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td><span class="category-title">{{ $cat->cat_title }}</span></td>
                                  <td><a href="{{ route('admin.subcategory.list') }}?main_cat={{ $cat->cat_id }}" title="Add Sub category"><i class="category-add-button"></i></a></td>
                              @if($cat->cat_front == 0)
                                  <td><span class="show-f" id="showf-{{ $cat->cat_id }}-1"><i class="no-button"></i></span></td>
                              @else
                                  <td><span class="show-f" id="showf-{{ $cat->cat_id }}-0"><i class="yes-button"></i></span></td>
                              @endif
                              @if($cat->cat_status == 0)
                                  <td><span class="status-c" id="status-{{ $cat->cat_id }}-1"><i class="inactive-button"></i></span></td>
                              @else
                                  <td><span class="status-c" id="status-{{ $cat->cat_id }}-0"><i class="active-button"></i></span></td>
                              @endif
                                  <td><a href="{{ route('admin.category.edit') }}?cid={{ $cat->cat_id }}"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-{{ $cat->cat_id }}"></i></td>
                                </tr>  
                            @endforeach
                    
                              </tbody>
                            </table>
                          </div>
                      
                      </section>

                      <nav id="list-pagin">
                      {!! @$category_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? The category "<span></span>", you will remove from category list.</p>
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
<script type="text/javascript" src="{{ URL::asset('publich/backend/js/component/scripts-category.js') }}"></script>
@endsection