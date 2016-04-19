@extends('layouts.master_admin')

@section('main_content')
            <div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box blue-bg">
						<i class="fa fa-file"></i>
						<div class="count">{{ $num_article }}</div>
						<div class="title">Articles</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box brown-bg">
						<i class="fa fa-laptop"></i>
						<div class="count">{{ $num_slideshow }}</div>
						<div class="title">Slideshow</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->	
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box dark-bg">
						<i class="fa fa-folder-open"></i>
						<div class="count">{{ $num_category }}</div>
						<div class="title">Category</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">
						<i class="fa fa-picture-o"></i>
						<div class="count">{{ $num_gallery }}</div>
						<div class="title">Gallery</div>						
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
			</div><!--/.row-->
@endsection