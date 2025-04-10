<?php include("common/layout.php");
// include("common/header.php");
// include("common/sidebar.php");

?>
<div class="wrapper">
    <!-- <div class="row mt-5">
        <div class="col">
            <div class="table-responsive">
                <table class="table border">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Date/Time</th>
                            <th scope="col">Event Image</th>
                            <th scope="col">Event Name</th>
                            <th scope="col">Event Category</th>
                            <th scope="col">Event Address</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $query = mysqli_query($db, "select * from events order by id desc");
                        if (mysqli_num_rows($query) > 0) {
                            $sr_no = 1; // Initialize serial number
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td><?php echo $sr_no++; ?></td>
                                    <td><?php echo $data['event_date']; ?>
                                        <br><?php echo $data['start_time']; ?> - <?php echo $data['end_time']; ?></td>
                                    <td>
                                        <img src="assets/images/activity_images/<?php echo $data['event_image']; ?>" width="200px" height="100px" alt="Event Image">
                                    </td>
                                    <td><?php echo $data['event_name']; ?></td>
                                    <td><?php echo $data['event_category']; ?></td>
                                    <td><?php echo $data['event_address']; ?></td>
                                    <td>
                                        <a href="" class="btn btn-sm bg-success me-2">
                                            <i class="fa-regular fa-eye"></i></a>
                                        <a href="" class="btn btn-sm bg-primary me-2">
                                            <i class="fa-regular fa-edit"></i></a>
                                        <a href="" class="btn btn-sm bg-danger me-2">
                                            <i class="fa-regular fa-trash"></i></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

    <!-- Gallery Section -->
    <div class="mt-5">
        <h3 class="text-center">Events</h3>
        <div class="row mt-2">
            <div class="col-md-4">
                <img src="assets/images/enviroment.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
            </div>
            <!--<div class="col-md-4">-->
            <!--    <img src="assets/images/event1.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">-->
            <!--</div>-->
            <!--<div class="col-md-4">-->
            <!-- <img src="aassets/images/event2.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">-->
            <!--</div>-->
            <div class="col-md-4">
                <img src="assets/images/ii.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
            </div>
           
        </div>
    </div>
</div>

<!-- Modal for Enlarged Image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" class="img-fluid" alt="Enlarged Award">
            </div>
        </div>
    </div>
</div>
<script>
    function showImage(src) {
        document.getElementById("modalImage").src = src;
    }
</script>



<?php include("common/footer.php"); ?>