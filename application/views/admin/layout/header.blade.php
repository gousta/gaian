<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <title>{{ $title }}</title>
  
  <link rel="shortcut icon" href="{{ URL::base() }}/assets/img/favicon.png">
  
  <meta name="viewport" content="width=device-width, initial-scale=0.65, maximum-scale=0.65">
  
  {{ HTML::style('assets/admin/css/app.css') }}
  {{ HTML::style('assets/admin/css/font-awesome.css') }}
</head>

<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand" href="/admin" style="padding: 7px 20px 9px"><img src="/assets/img/logo-light.small.png"></a>
	      <ul class="nav">
	        <li {{ ($page == 'dashboard') ? 'class="active"':'' }}><a href="/admin/dashboard">Dashboard</a></li>
	        <li {{ ($page == 'contributions') ? 'class="active"':'' }}><a href="/admin/contributions">Contributions</a></li>
	        <li {{ ($page == 'passports') ? 'class="active"':'' }}><a href="/admin/passports">Passports</a></li>
	        <li {{ ($page == 'forums') ? 'class="active"':'' }}><a href="/admin/forums">Forums</a></li>
	      </ul>
	      <ul class="nav pull-right">
	      	<li><a href="/"><i class="icon-share-alt"></i> to Gaian.me</a>
	        <li><a href="/sign-out"><i class="icon-signout"></i> Sign out</a></li>
	      </ul>
	    </div>
	  </div>
	</div>