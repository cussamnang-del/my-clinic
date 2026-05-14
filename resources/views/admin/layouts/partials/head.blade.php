<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-theme">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ assetUrl() }}/images/favicon-32x32.png" type="image/png" />
  <title>{{ config('app.name')}}-@yield('pagetitle','Admin Dashboard')</title>
  <!--font-->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <!--plugins-->
  <link href="{{ assetUrl() }}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  @stack('select2')
  <!-- Bootstrap CSS -->
  <link href="{{ assetUrl() }}/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link href="{{ assetUrl() }}/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/style.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ assetUrl() }}/plugins//bootstrap-icons1.5.0/font/bootstrap-icons.css">
  <!-- loader-->
	<link href="{{ assetUrl() }}/css/pace.min.css" rel="stylesheet" />
  <!--Theme Styles-->
  <link href="{{ assetUrl() }}/css/dark-theme.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/light-theme.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/semi-dark.css" rel="stylesheet" />
  <link href="{{ assetUrl() }}/css/header-colors.css" rel="stylesheet" />

  @stack('styles')
</head>
