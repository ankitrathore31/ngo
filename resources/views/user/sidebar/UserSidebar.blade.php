<style>
    .navv ul li a {
           color: white;
       }
      

       .social-icons i {
           margin-right: 10px;
           font-size: 24px;
       }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-primary ">
   <div class="container-fluid">

       <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
           aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse   navv" id="navbarNav">
           <ul class="navbar-nav">
               <li class="nav-item">
                   <a class="nav-link" aria-current="page" href="{{ 'AdminDashboard'}}">Dashboard</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#">Help me</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="#">Publicity</a>
               </li>
               <li class="nav-item dropdown bg-primary">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Activity
                </a>
                <ul class="dropdown-menu bg-primary" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('activitylist') }}">Activity List</a></li>
                    <li><a class="dropdown-item" href="{{ route('addactivity') }}">Add Activity</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
            </li>
       </div>
   </div>
</nav>