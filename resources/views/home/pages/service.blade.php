@extends('home.layout.MasterLayout')
@Section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-info text-white">
                    <tr>
                        <th>Sr. No.</th>
                        <th>By-Laws Code</th>
                        <th>Image</th>
                        <th>Service Name</th>
                        <th>Service Category</th>
                        <th>About Us</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>16</td>
                        <td><img src="assets/images/sewing.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                        <td>Sewing</td>
                        <td>Skill Development</td>
                        <td class="text-wrap">Empowering individuals through hands-on skill training for self-sufficiency.</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>1</td>
                        <td><img src="assets/images/education.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                        <td>Free Education</td>
                        <td>Education</td>
                        <td>Providing free education to underprivileged children for a brighter future.</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>16</td>
                        <td><img src="assets/images/parlour.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                        <td>Beauty Parlour</td>
                        <td>Skill Development</td>
                        <td>Training women in beauty services to promote financial independence.</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>3</td>
                        <td><img src="assets/images/food.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                        <td>Free Food</td>
                        <td>Social Service</td>
                        <td>Providing nutritious meals to those in need, ensuring no one goes hungry </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>13</td>
                        <td><img src="assets/images/woman.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                        <td>Save The Women</td>
                        <td>Women Empowerment</td>
                        <td>Empowering and protecting women through support, education, and safety initiatives. </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
