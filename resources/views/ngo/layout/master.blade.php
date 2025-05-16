<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logo.png" type="image/png">
    <title>Gyan Bharti Sanstha (NGO) </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>
<style>
    
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

    @include('ngo.header.NgoHeader')



    <!-- Sidebar Section -->

    @include('ngo.sidebar.NgoSidebar')


    <!-- Main Content Section -->

    @yield('content') <!-- Body content goes here -->


<script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.0/dist/countUp.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Add your scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>
     <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Here",
                allowClear: true
            });
        });
    </script>
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
        flatpickr("#", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // 12-hour format with AM/PM
            time_24hr: false
        });
    </script>
</body>

</html>
