<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/LOGO.png') }}" type="image/x-icon">
    <title>GYAN BHARTI SANSTHA (NGO)</title>
    <title>{{ $title ?? 'Gyan Bharti Sanstha | NGO in India' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Gyan Bharti Sanstha is a non-profit organization working across multiple Indian states to support education, women empowerment, healthcare, help poor person.' }}">
    <meta name="keywords"
        content="{{ $keywords ?? 'NGO, Non-profit, Charity, Gyan Bharti Sanstha, Education NGO, Women Empowerment NGO, NGO in India, NGO in Uttar Pradesh' }}">
    <meta name="author" content="Gyan Bharti Sanstha">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Optional social meta -->
    <meta property="og:title" content="{{ $title ?? 'Gyan Bharti Sanstha' }}">
    <meta property="og:description" content="{{ $description ?? 'Non-profit working across India' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;family=Outfit:wght@100..900&amp;display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .wrapper {
        flex: 1;
        /* This makes content take up remaining space */
        display: flex;
        flex-direction: column;
        padding-bottom: 80px;
    }

    /* Ensure the footer is always at the bottom */
    .footer {
        background-color: #343a40;
        /* Dark footer background */
        color: white;
        text-align: center;
        padding: 15px 0;
        width: 100%;
    }

    .header {
        padding: 15px 0;
    }

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

    @include('home.header.header')



    <!-- Sidebar Section -->

    @include('home.sidebar.sidebar')


    <!-- Main Content Section -->

    @yield('content') <!-- Body content goes here -->

    <!-- Fotter section -->
    @include('home.footer.footer')

    <!-- Add your scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.6.0/dist/countUp.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
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
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Here",
                allowClear: true
            });
        });
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NGO",
            "name": "Gyan Bharti Sanstha",
            "url": "https://gyanbhartingo.org",
            "description": "Gyan Bharti Sanstha is a non-profit organization working across India to support education, healthcare, and community development."
}
</script>

</body>

</html>
