@extends('layouts.master_admin')
@section('main_content')
             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                            {!! Form::open(['url' => route('admin.article.search'), 'class' => 'navbar-form', 'id' => 'find_article']) !!}
                              {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'key_word']) !!}
                            {!! Form::close() !!}
                            <div class="pull-right">
                              <a href="{{ route('admin.article.create') }}" class="btn btn-primary">New Article</a>
                            </div>
                            <div class="clearfix"></div>
                          </header>
                          <div class="table-responsive">
                            <div class="loading"></div>
                            <table class="table" id="result_output">
                              <thead>
                                <tr>
                                  <th width="5%">#</th>
                                  <th width="45%">Title</th>
                                  <th width="20%">Created Date</th>
                                  <th width="10%">Show Front</th>
                                  <th width="10%">Edit</th>
                                  <th width="10%">Delete</th>
                                </tr>
                              </thead>
                              <tbody>

                            @foreach($article_info as $art)
                                <tr>
                                  <td>{{ $ind++ }}</td>
                                  <td><span class="article-title">{{ $art->con_title }}</span></td>
                                  <td>{{ date('d F, Y', strtotime($art->created_at)) }}</td>
                              @if($art->con_front == 0)
                                  <td><span class="status-a" id="status-{{ $art->con_id }}-1"><i class="no-button"></i></span></td>
                              @else
                                  <td><span class="status-a" id="status-{{ $art->con_id }}-0"><i class="yes-button"></i></span></td>
                              @endif
                                  <td><a href="{{ route('admin.article.edit') }}?aid={{ $art->con_id }}"><i class="edit-button"></i></a></td>
                                  <td><i class="del-button" id="del-{{ $art->con_id }}"></i></td>
                                </tr>  
                            @endforeach
                              </tbody>
                            </table>
                          </div>

                      </section>

                      <nav id="list-pagin">
                      {!! @$article_info->render() !!}
                      </nav>                      
                  </div>
              </div>

<div class="modal fade modal-custom" id="confirm-msg-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmMsgModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <h4 class="modal-title">Delete Confirmation</h4>
      <div class="modal-body">
        <p>Are you sure? The article "<span></span>", you will remove from article list.</p>
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
<script type="text/javascript" src="{{ URL::asset('public/backend/js/component/scripts-article.js') }}"></script>
@endsection