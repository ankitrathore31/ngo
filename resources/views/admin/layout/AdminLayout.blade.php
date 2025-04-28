<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logo.png" type="image/png">
    <title>Gyan Bharti Sanstha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- Font Awesome CDN (make sure it's included in your layout if not already) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>
<style>
    /* .wrapper{
        background-color: whitesmoke;
    } */
    /* Optional: style dropdowns for better visibility */
    .ui-datepicker select.ui-datepicker-month,
    .ui-datepicker select.ui-datepicker-year {
        font-size: 14px;
        padding: 4px;
    }

    .ui-datepicker-title {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    /* Optional: style the calendar */
    .ui-datepicker {
        background: #fff;
        border: 1px solid #ccc;
        padding: 10px;
        font-family: 'Segoe UI', sans-serif;
    }

    .ui-datepicker th {
        color: #fff;
        background-color: #607d8b;
        padding: 5px;
    }

    .ui-datepicker td {
        text-align: center;
        padding: 5px;
    }

    .ui-datepicker td a {
        text-decoration: none;
        color: #000;
    }
</style>

<body>

    <!-- Header Section -->

    @include('admin.header.AdminHeader')



    <!-- Sidebar Section -->

    @include('admin.sidebar.AdminSidebar')


    <!-- Main Content Section -->

    @yield('content') <!-- Body content goes here -->



    <!-- Add your scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+10",
                dateFormat: "dd-mm-yy"
            });
        });
    </script>
     <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select Here",
                allowClear: true
            });
        });
    </script>
</body>

</html>
