<?php
    include("../assets/connection/connection.php"); 
    session_start();

    //view first grading
    if(isset($_GET['StudentGrades1'])){
        $id = $_GET['StudentGrades1'];
        $_SESSION['StudentGrades1'] =$id;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `first_grading` ON `students`.`student_id`=`first_grading`.`student_id` WHERE `students`.`student_id`=$id;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">First Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['english']?>" readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['filipino']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['math']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['science']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['ap']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['esp']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text"  id="myInput" value="<?php echo $rows['tle']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text"  id="myInput" placeholder="Music"value="<?php echo $rows['music']?>" readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text"  id="myInput" placeholder="Arts" value="<?php echo $rows['art']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text"  id="myInput" placeholder="Pe" value="<?php echo $rows['pe']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text"  id="myInput" placeholder="Health" value="<?php echo $rows['health']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //view second grading
    if(isset($_GET['StudentGrades2'])){
        $gradeId2 = $_GET['StudentGrades2'];
        $_SESSION['StudentGrades2'] =$gradeId2;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `second_grading` ON `students`.`student_id`=`second_grading`.`student_id` WHERE `students`.`student_id`=$gradeId2;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Second Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['english2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['filipino2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['math2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['science2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['ap2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['esp2']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['tle2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" id="myInput" placeholder="Music"value="<?php echo $rows['music2']?>" readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" id="myInput" placeholder="Arts" value="<?php echo $rows['art2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" id="myInput" placeholder="Pe" value="<?php echo $rows['pe2']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" id="myInput" placeholder="Health" value="<?php echo $rows['health2']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //view third grading
    if(isset($_GET['StudentGrades3'])){
        $gradeId3 = $_GET['StudentGrades3'];
        $_SESSION['StudentGrades3'] =$gradeId3;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `third_grading` ON `students`.`student_id`=`third_grading`.`student_id` WHERE `students`.`student_id`=$gradeId3;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>

                <h4 class="title">Third Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['english3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['filipino3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['math3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" id="myInputupdateSubjectScience3" value="<?php echo $rows['science3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['ap3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['esp3']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['tle3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" id="myInput" placeholder="Music"value="<?php echo $rows['music3']?>"readonly >
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" id="myInput" placeholder="Arts" value="<?php echo $rows['art3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" id="myInput" placeholder="Pe" value="<?php echo $rows['pe3']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" id="myInput" placeholder="Health" value="<?php echo $rows['health3']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
    //update fourth grading
    if(isset($_GET['StudentGrades4'])){
        $gradeId4 = $_GET['StudentGrades4'];
        $_SESSION['StudentGrades4'] =$gradeId4;
        $query = mysqli_query($conn, "SELECT * FROM `students` INNER JOIN `fourth_grading` ON `students`.`student_id`=`fourth_grading`.`student_id` WHERE `students`.`student_id`=$gradeId4;");

        if(mysqli_num_rows($query)>0){
            $rows = mysqli_fetch_assoc($query);?>
                <h4 class="title">Fourth Grading</h4>
                <hr>
                <div class="details">
                    <section class="column">
                        <div>
                            <label for="updateSubjectEnglish">English:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['english4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectFilipino">Filipino:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['filipino4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMath">Math:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['math4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectScience">Science:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['science4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectAP">Araling Panlipunan:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['ap4']?>"readonly>
                        </div>
                    </section>
                    <section class="column">
                        <div>
                            <label for="updateSubjectEsp">Edukasyon sa Pagpapakatao:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['esp4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectTle">Technology and Livelihood Education:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['tle4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectMusic">Music:</label>
                            <input type="text" id="myInput" placeholder="Music"value="<?php echo $rows['music4']?>"readonly >
                        </div>
                        <div>
                            <label for="updateSubjectArts">Arts:</label>
                            <input type="text" id="myInput" placeholder="Arts" value="<?php echo $rows['art4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">PE:</label>
                            <input type="text" id="myInput" placeholder="Pe" value="<?php echo $rows['pe4']?>"readonly>
                        </div>
                        <div>
                            <label for="updateSubjectArts">Health:</label>
                            <input type="text" id="myInput" placeholder="Health" value="<?php echo $rows['health4']?>"readonly>
                        </div>
                        <div>
                            <label for="average">Average:</label>
                            <input type="text" id="myInput" value="<?php echo $rows['avg']?>" disabled>
                        </div>
                    </section>
                </div><?php
        }

    }
?>