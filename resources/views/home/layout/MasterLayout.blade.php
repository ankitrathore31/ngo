<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/LOGO.png" type="image/x-icon">
    <title>GYAN BHARTI SANSTHA (NGO)</title>
    <meta name="keywords" content="charity, nonprofit, fundraising, donation, html, bootstrap, scss">
    <meta name="description" content="Nonprofit NGO Fundraising HTML5 Template">
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
</body>

</html>
