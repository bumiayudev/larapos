<!DOCTYPE html>
<html lang="{{ str_replace('__', '-', app()->getLocale())}}">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    
    <!-- Icon Font Stylesheet -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/regular.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/solid.min.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" /> -->

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">

    <!-- Jquery UI -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <!-- jquery -->
    <script src="{{ asset('lib/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <style type="text/css">

        .ui-menu{
            list-style: none;
            margin-top: 10px;
            width: 400px;
        
        }
      .ui-autocomplete-row
      {
        padding:4px;
        background-color: #f4f4f4;
        border-bottom:1px solid #ccc;
        font-weight:bold;
      }
      .ui-autocomplete-row:hover
      {
        background-color: #ddd;
        cursor: pointer;
      }
    </style>
</head>