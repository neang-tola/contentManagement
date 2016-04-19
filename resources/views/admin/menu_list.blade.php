@extends('layouts.master_admin')
@section('main_content')

             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.menu.search'), 'class' => 'navbar-form', 'id' => 'find_menu']) !!}
                              {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'key_word']) !!}
                            {!! Form::close() !!}
                            <div class="pull-right">
                              <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">New Menu</a>
                            </div>
                            <div class="clearfix"></div>
                          </header>

                          <div class="table-responsive">
                            <div class="loading"></div>
                            <table class="table" id="result_output">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="20%">Title</th>
                                  <th width="10%">Position</th>
                                  <th width="10%">Link Type</th>
                                  <th width="25%">Content</th>
                                  <th width="10%">Status</th>
                                  <th width="10%">Edit</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                        @foreach($menu_info as $menu)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td><span class="menu-title">{{ $menu->m_title }}</span></td>
                                  <td>{{ AdminHelper::Position($menu->m_post) }}</td>
                                  <td>{{ $menu->m_link_type }}</td>
                                  <td>{{ $menu->con_title }}</td>
                              @if($menu->m_status == 0)
                                  <td><span class="status-m" id="status-{{ $menu->m_id }}-1"><i class="inactive-button"></i></span></td>
                              @else
                                  <td><span class="status-m" id="status-{{ $menu->m_id }}-0"><i class="active-button"></i></span></td>
                              @endif
                                  <td><a href="{{ route('admin.menu.edit') }}?mid={{ $menu->m_id }}"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-{{ $menu->m_id }}"></i></td>
                                </tr>
                              {!! AdminHelper::getSubMenu($menu->m_id) !!}  
                        @endforeach
                              </tbody>
                            </table>
                          </div>
           
                      </section>

                      <nav id="list-pagin">
                      {!! @$menu_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? The menu "<span></span>", you will remove from menu list.</p>
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
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-menu.js') }}"></script>
@endsection