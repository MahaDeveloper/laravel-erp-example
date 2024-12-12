<!DOCTYPE html>
<html lang="en">
    
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Skydash Admin</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('admin-template/assets/vendors/feather/feather.css') }}">
       
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      

        <link rel="stylesheet" href="{{ asset('admin-template/assets/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-template/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <!-- End plugin css for this page -->
        <link rel="shortcut icon" href="{{ asset('admin-template/assets/images/favicon.png') }}" />
        <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin-template/assets/datatables-bs5/datatables.bootstrap5.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-template/assets/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
        @vite(['resources/scss/style.scss', 'resources/js/app.js'])
        <style>
            .is-invalid {
                border-color: red;
              
            }
            .is-invalid::placeholder {
                color: red; 
                opacity: 1; 
            }
            /* Default styling for pagination buttons */
            /* .dataTables_paginate .page-link {
                background-color: white !important; 
                color: #000 !important; 
                border: 1px solid #ddd;
            } */

            /* Highlight active page button */
            .dataTables_paginate .page-item.active .page-link {
                background-color: #4B49AC !important; 
                color: white !important; 
                border-color: #4B49AC !important;
            }

            /* Hover effect for all buttons */
            .dataTables_paginate .page-link:hover {
                background-color: #4B49AC !important; /* Hover color */
                color: white !important;
            }
        </style>
      </head>
  <body>
    
  
   