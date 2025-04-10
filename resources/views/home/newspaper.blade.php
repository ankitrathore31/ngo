@extends('home.layout.MasterLayout')
@Section('content')

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                    <h4>Sanstha Newspaper Cutting</h4>
            </div>
        </div>
        <div class="mt-5">
        <div class="row">
            <?php 
            $query = mysqli_query($db, "SELECT * FROM newspaper order by id desc");
            if(mysqli_num_rows($query)>0){
                while($data = mysqli_fetch_assoc($query)){

            ?>
                <div class="col-md-4 col-sm-6 mb-3 border m-2">
                    <img src="Admin/assets/images/gallery/<?php echo $data['image']; ?>" class="img-fluid p-2" alt="">
                </div>
            <?php 
                }
            }
            ?>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-3 border m-2">
                    <img src="assets/images/news1.jpeg" class="img-fluid p-2" alt="">
                </div>
                <div class="col-md-4 col-sm-6 mb-3 border m-2">
                    <img src="assets/images/news2.jpeg" class="img-fluid p-2" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection