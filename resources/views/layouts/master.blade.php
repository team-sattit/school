<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ isset($title) ? $title .' | '. config('app.name', 'Laravel') :  config('app.name', 'Laravel')}}</title>
		<link rel="icon" href="{{asset('asset/favicon.png')}}" type="image/icon">
		@include('_partials.admin.stylesheet')
		<style type="text/css" media="print">
			.noprint{
				display: none;
		}
		</style>
		<script>
			const Base_url = '{{ config('app.url') }}/';
		</script>
	</head>
	<body class="navbar-top">
		@auth()
		<!-- Main navbar -->
		@include('_partials.admin.main_navbar')
		<!-- /main navbar -->
		@endauth
		<!-- Page content -->
		<div class="page-content ">
			@auth()
			<!-- Main sidebar -->
			<div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md noprint">
				<!-- Sidebar mobile toggler -->
				@include('_partials.admin.sidebar_mobile_content')
				<!-- /sidebar mobile toggler -->
				<!-- Sidebar content -->
				<div class="sidebar-content noprint">
					<!-- Main navigation -->
					@include('_partials.admin.main_navigation')
					<!-- /main navigation -->
				</div>
				<!-- /sidebar content -->
			</div>
			<!-- /main sidebar -->
			@endauth
			<!-- Main content -->
			<div class="content-wrapper">
				@auth()
				<!-- Page header -->
				@section('page.header')
				@show
				<!-- /page header -->
				@endauth
				<!-- Content area -->
				<div class="content">
					@section('content')
					@show
				</div>
				<!-- /content area -->
				@auth()
				<!-- Footer -->
				@include('_partials.admin.footer')
				<!-- /footer -->
				@endauth
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
		@if(isset($modal) && $modal)
		<!-- Remote source -->
		<div id="modal_remote" class="modal" tabindex="-1"  data-backdrop="static">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{$title}}</h5>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div id="modal-loader" style="display: none; text-align: center;"> <img src="{{ asset('asset/preloader.gif') }}"> </div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<!-- /remote source -->
		@endif
		@include('_partials.admin.scripts')
	</body>
</html>