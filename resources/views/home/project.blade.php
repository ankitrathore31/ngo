@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Project Image</th>
                            <th>Project Name</th>
                            <th>Project Category</th>
                            <th>About Us</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1</td>
                            <td><img src="assets/images/sewing.jpg" alt="Service Image" class="img-fluid" style="max-width: 130px;"></td>
                            <td>Sewing</td>
                            <td>Skill Development</td>
                            <td class="text-wrap">Empowering individuals through hands-on skill training for self-sufficiency.</td>
                        </tr> -->
                        <tr>
                            <td>1</td>
                            <td><img src="assets/images/education.jpg" alt="Service Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Free Education</td>
                            <td>Education</td>
                            <td>Providing free education to underprivileged children for a brighter future.</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img src="assets/images/peace-talk.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 150px;"></td>
                            <td>Peace Talk Meeting</td>
                            <td>Peace Talk</td>
                            <td>
                                A peace talk meeting fosters dialogue and understanding to resolve conflicts and promote
                                harmony.</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <!-- <td>16</td> -->
                            <td><img src="assets/images/enviroment.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Environment Protection</td>
                            <td>Environment</td>
                            <td>Protecting the environment is essential for a sustainable and healthy future.</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><img src="assets/images/food.jpg" alt="Service Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Free Food</td>
                            <td>Food</td>
                            <td>Providing nutritious meals to those in need, ensuring no one goes hungry </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <!-- <td>16</td> -->
                            <td><img src="assets/images/silai.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Skill Development & Training Centre</td>
                            <td>Skill Development</td>
                            <td>Skill development enhances abilities and knowledge, empowering individuals for better
                                opportunities and growth.</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><img src="assets/images/woman.jpg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Save The Women</td>
                            <td>Women Empowerment</td>
                            <td>Empowering and protecting women through support, education, and safety initiatives. </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><img src="assets/images/peace.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Social Awareness Program</td>
                            <td>Awareness</td>
                            <td>A Social Awareness Project on the environment can focus on educating and encouraging people
                                to
                                adopt eco-friendly habits. Here’s a simple project idea:</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><img src="assets/images/ind.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Cultural Project</td>
                            <td>Cultural Program</td>
                            <td>To promote awareness, appreciation, and preservation of diverse cultural traditions and
                                heritage</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><img src="assets/images/sanitation.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Sanitation Project</td>
                            <td>Clean Campaign</td>
                            <td>A sanitation project promotes hygiene, waste management, and clean environments for
                                healthier communities.</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><img src="assets/images/health.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Health Program</td>
                            <td>Health Mission</td>
                            <td>A health program promotes awareness, prevention, and access to healthcare for a healthier
                                community.</td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td><img src="assets/images/blanket.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Help The Poor</td>
                            <td>Poor Alleviation</td>
                            <td>Helping the poor means providing support, resources, and opportunities for a better quality
                                of life.</td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td><img src="assets/images/peace.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Social Problem</td>
                            <td>Peace Talk</td>
                            <td>A social problem is an issue that affects society, such as poverty, unemployment, or
                                discrimination, requiring collective solutions.</td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td><img src="assets/images/hari-naam.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Hari Naam Mission & Mukesh</td>
                            <td>Religious Program</td>
                            <td>A religious program fosters spiritual growth, community bonding, and faith-based learning
                                through prayers, teachings, and rituals.</td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td><img src="assets/images/farmer.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Farmer Club</td>
                            <td>Agriculture Program</td>
                            <td>An agriculture program promotes sustainable farming practices, innovation,
                                and farmer empowerment for better productivity and food security.</td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td><img src="assets/images/labour.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Labour Tools Distribution</td>
                            <td>Poor Alleviation</td>
                            <td>Helping the poor means providing support, resources, and opportunities for a better quality
                                of life.</td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td><img src="assets/images/drink.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Drinking Water</td>
                            <td>Drinking Water</td>
                            <td>Access to clean drinking water is essential for health and well-being in every community.
                            </td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td><img src="assets/images/ration.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Ration Distribution</td>
                            <td>Poor Alleviation</td>
                            <td>Helping the poor means providing support, resources, and opportunities for a better quality
                                of life.</td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td><img src="assets/images/diaster.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Disaster Management</td>
                            <td>Natural Disaster</td>
                            <td>Helping the poor means providing support, resources, and opportunities for a better quality
                                of life.</td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td><img src="assets/images/economic.jpeg" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Economic Help</td>
                            <td>Poor Alleviation</td>
                            <td>Helping the poor means providing support, resources, and opportunities for a better quality
                                of life.</td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td><img src="assets/images/cow.PNG" alt=" Image" class="img-fluid" style="max-width: 130px;">
                            </td>
                            <td>Cow Service</td>
                            <td>Animal Service</td>
                            <td>Cow service promotes care, protection, and well-being of cows for a sustainable environment.
                            </td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td><img src="assets/images/animal-food.PNG" alt=" Image" class="img-fluid"
                                    style="max-width: 130px;"></td>
                            <td>Animal Food</td>
                            <td>Animal Service</td>
                            <td>
                                Animal food provides essential nutrients for the health and well-being of animals.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
