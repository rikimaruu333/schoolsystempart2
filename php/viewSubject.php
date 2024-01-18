<?php

function getRemarks($finalGradePercentage) {
    // Round the final grade to the nearest 0.1
    $roundedGrade = round($finalGradePercentage * 10) / 10;

    // Grade scale and remarks
    $gradeScale = [
        ['grade' => '1.0', 'range' => [99.0, 100], 'remark' => 'Excellent'],
        ['grade' => '1.1', 'range' => [97.0, 99.0], 'remark' => 'Superior'],
        ['grade' => '1.2', 'range' => [95.0, 97.0], 'remark' => 'Superior'],
        ['grade' => '1.3', 'range' => [93.0, 95.0], 'remark' => 'Very Satisfactory'],
        ['grade' => '1.4', 'range' => [91.0, 93.0], 'remark' => 'Very Satisfactory'],
        ['grade' => '1.5', 'range' => [90.0, 91.0], 'remark' => 'Satisfactory'],
        ['grade' => '1.6', 'range' => [89.0, 90.0], 'remark' => 'Satisfactory'],
        ['grade' => '1.7', 'range' => [88.0, 89.0], 'remark' => 'Fairly Satisfactory'],
        ['grade' => '1.8', 'range' => [87.0, 88.0], 'remark' => 'Fairly Satisfactory'],
        ['grade' => '1.9', 'range' => [86.0, 87.0], 'remark' => 'Barely Satisfactory'],
        ['grade' => '2.0', 'range' => [85.0, 86.0], 'remark' => 'Barely Satisfactory'],
        ['grade' => '2.1', 'range' => [84.0, 85.0], 'remark' => 'Poor Satisfactory'],
        ['grade' => '2.2', 'range' => [83.0, 84.0], 'remark' => 'Poor Satisfactory'],
        ['grade' => '2.3', 'range' => [82.0, 83.0], 'remark' => 'Poor Satisfactory'],
        ['grade' => '2.4', 'range' => [81.0, 82.0], 'remark' => 'Poor Satisfactory'],
        ['grade' => '2.5', 'range' => [80.0, 81.0], 'remark' => 'Unsatisfactory'],
        ['grade' => '2.6', 'range' => [79.0, 80.0], 'remark' => 'Unsatisfactory'],
        ['grade' => '2.7', 'range' => [78.0, 79.0], 'remark' => 'Unsatisfactory'],
        ['grade' => '2.8', 'range' => [77.0, 78.0], 'remark' => 'Unsatisfactory'],
        ['grade' => '2.9', 'range' => [76.0, 77.0], 'remark' => 'Unsatisfactory'],
        ['grade' => '3.0', 'range' => [75.0, 76.0], 'remark' => 'Unsatisfactory'],
        ['grade' => 'Below 3.0', 'range' => [60.0, 74.99], 'remark' => 'Failed'],
        ['grade' => 'No Grade', 'range' => [0, 59.99], 'remark' => 'No Grade'],
    ];

    foreach ($gradeScale as $gradeInfo) {
        $minRange = $gradeInfo['range'][0];
        $maxRange = $gradeInfo['range'][1];

        if ($roundedGrade >= $minRange && $roundedGrade <= $maxRange) {
            return ($roundedGrade < 75.0) ? $gradeInfo['remark'] : $gradeInfo['grade'];
        }
    }

    return 'Remark not found';
}



require "formfunctions.php";
usercheck_login();

require_once('userconnection.php'); 


$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['addGrade'])) {
        $errors = addGrade($_POST);
    }
}

if (isset($_GET['subject_id'])) {
    $subjectId = $_GET['subject_id'];
    
    $newconnection = new Connection();
    $connection = $newconnection->openConnection();
    $stmt = $connection->prepare("SELECT * FROM subjects WHERE subject_id = :subject_id");
    $stmt->bindParam(':subject_id', $subjectId);
    $stmt->execute();
    $subject = $stmt->fetch(PDO::FETCH_OBJ);

    $subjectLevelId = $subject->yearlevel_id;
    $subjectCourseId = $subject->course_id;
    $subjectId = $subject->subject_id;
}


$teacherId = $_SESSION['USER']->teacher_id;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.1.135/jspdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../css/viewSubject.css">
    <title>Document</title>
</head>
<body>
    <div class="sidebar"> 
        <div class="top">
            <div class="logo">
                <img src="../images/crmclogo.png" alt="">
                <span>CRMC SCHOOL SYSTEM</span>
            </div>
            <i class="bx bx-menu" id="sidebarbtn"></i>
        </div>
        <div class="user">
            <img src="<?= $_SESSION['USER']->teacher_profile?>" alt="">
            <div>
                <p class="name"><?= $_SESSION['USER']->teacher_name?></p>
                <p class="rank">Teacher</p>
            </div>
        </div>
        <ul>
            <li class="dashboard_btn">
                <a href="teacherdashboard.php">
                    <i class="bx bxs-grid-alt"></i>
                </a>
            </li>
            <li class="dashboard_btn">
                <a href="allstudents.php">
                    <i class="bx bxs-user"></i>
                </a>
            </li>
            <li class="logout_btn">
                <a href="logout.php" onclick="return confirm('Log out account?');">
                    <i class="bx bx-log-out"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="maincontainer">
            <?php
                require_once('userconnection.php'); 

                $departmentId = $_SESSION['USER']->department_id;

                $newconnection = new Connection();
                $connection = $newconnection->openConnection();

                $stmt = $connection->prepare("SELECT * FROM department WHERE department_id = :department_id");
                $stmt->bindParam(':department_id', $departmentId);
                $stmt->execute();
                
                $department = $stmt->fetch(PDO::FETCH_OBJ);
            ?>
            <div class="container">
                <div class="profilebox">
                    <div class="profile">
                        <img src="<?= $department->department_logo ?>" alt="">
                    </div>
                    <div class="namebox">
                        <div class="txtbox1"><?= strtoupper($department->department_name) ?></div>
                    </div>
                </div>
            </div>
            <div class="studentboxcontainer">
                <div class="createbtncontainer">
                    <button class="viewGradesBtn" id="viewAllGrades" onclick="openGradesModal()">View all grades</button>
                </div>
                <div class="studentcontainer">
                    <div class="studenttxt">Student List :</div>
                    <div class="student-box">
                        <?php
                        require_once("userconnection.php");

                        $departmentId = $_SESSION['USER']->department_id;

                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        $sql = "SELECT * FROM students WHERE yearlevel_id = :yearlevel_id AND department_id = :department_id AND course_id = :course_id ORDER BY department_id";
                        $stmt = $connection->prepare($sql);
                        $stmt->bindParam(':department_id', $departmentId);
                        $stmt->bindParam(':yearlevel_id', $subjectLevelId);
                        $stmt->bindParam(':course_id', $subjectCourseId);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $department = $row['department_id'];

                            $stmtdepartment = $connection->prepare("SELECT * FROM department WHERE department_id = $department");
                            $stmtdepartment->execute();
                            $departments = $stmtdepartment->fetch(PDO::FETCH_OBJ);

                        ?>
                                <div class="student-card">
                                    <div class="studentprofileinfo">
                                        <div class="student-profile">
                                            <img src="<?= $departments->department_logo?>" alt="">
                                        </div>
                                        <div class="student-info">
                                            <div class="student-nametype">
                                                <div class="student-name">
                                                    <?= $row['student_name'] ?>
                                                </div>
                                                <div class="student-type">
                                                    <?= $row['department_name'] ?>
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="courselevel">
                                        <?= $row['year_level'] ?> - <?= $row['course_name'] ?>
                                    </div>
                                    <div class="buttons">
                                        <button class="view-student-button" id="printButton" onclick="updateStatus(<?= $row['student_id'] ?>, <?= $subjectId ?>)"><img src="../images/print.png" alt=""></button>
                                        
                                        <button class="view-student-button" onclick="openCreateModal(<?= $row['student_id'] ?>, <?= $subjectId ?>, <?= $teacherId ?>)"><img src="../images/search.png" alt=""></button>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="nostudent">No student available.</div>
                        <?php
                        }
                        $newconnection->closeConnection();
                        ?>
                    </div>
                </div>
            </div>
            <div class="gradesModal" id="gradesModal">
                <div class="grades-modal-content">
                    <span class="close" onclick="closeGradesModal()">&times;</span>
                    <h2 id="modalTitle">All Grades</h2>
                    <div class="grades-student-box" id="gradesContainer">
                        <div class="studentboxcontainer">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Final Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once("userconnection.php");

                                    $departmentId = $_SESSION['USER']->department_id;

                                    $newconnection = new Connection();
                                    $connection = $newconnection->openConnection();

                                    $sql = "SELECT * FROM students WHERE yearlevel_id = :yearlevel_id AND department_id = :department_id AND course_id = :course_id ORDER BY department_id";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->bindParam(':department_id', $departmentId);
                                    $stmt->bindParam(':yearlevel_id', $subjectLevelId);
                                    $stmt->bindParam(':course_id', $subjectCourseId);
                                    $stmt->execute();

                                    if ($stmt->rowCount() > 0) {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $department = $row['department_id'];
                                            $student_id = $row['student_id'];

                                            $stmtdepartment = $connection->prepare("SELECT * FROM department WHERE department_id = $department");
                                            $stmtdepartment->execute();
                                            $departments = $stmtdepartment->fetch(PDO::FETCH_OBJ);

                                            $gradestmt = $connection->prepare("SELECT * FROM grades WHERE student_id = :student_id");
                                            $gradestmt->bindParam(':student_id', $student_id);
                                            $gradestmt->execute();

                                            if ($gradestmt->rowCount() > 0) {
                                                while ($grade = $gradestmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                                    <tr>
                                                        <td><?= $row['student_name'] ?></td>
                                                        <td><?= getRemarks($grade['final_grade']) ?></td>
                                                    </tr>
                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='2'>No grade.</td></tr>";
                                            }
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="2">No student available.</td>
                                        </tr>
                                    <?php
                                    }
                                    $newconnection->closeConnection();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <button class="printgradesbutton" id="PrintGrades">Print Grades</button>
                    
                </div>
            </div>
            
            <?php
                require_once('userconnection.php');

                $newconnection = new Connection();
                $connection = $newconnection->openConnection();

                $stmt = $connection->prepare("SELECT * FROM department WHERE department_id = :department_id");
                $stmt->bindParam(':department_id', $departmentId);
                $stmt->execute();
                
                $department = $stmt->fetch(PDO::FETCH_OBJ);

            ?>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle"><?=$subject->subject_name?> | <?=$subject->descriptive_title?></h2>
                    <label id="studentName"></label>
                    <form method="POST" enctype="multipart/form-data" id="semesterForm" class="createModal">
                        <div class="namedepartment">
                            <div class="name">
                                <label>Prelim :</label>
                                <input type="text" name="prelimScore" id="prelimScore" placeholder="Enter prelim score (100 maximum)">
                            </div>
                            <div class="department">
                                <label>Midterm :</label>
                                <input type="text" name="midtermScore" id="midtermScore" placeholder="Enter midterm score (100 maximum)">
                            </div>
                        </div>
                        <div class="namedepartment">
                            <div class="name">
                                <label>Semi-Final :</label>
                                <input type="text" name="semifinalScore" id="semifinalScore" placeholder="Enter semifinal score (100 maximum)">
                            </div>
                            <div class="department">
                                <label>Final :</label>
                                <input type="text" name="finalScore" id="finalScore" placeholder="Enter final score (100 maximum)">
                            </div>
                        </div>
                        <br><h1>FINAL GRADE :</h1>
                        <h2 id="finalGrade" name="finalGrade"></h2>
                        <p id="remarks"></p>
                        <input type="hidden" name="studentId" id="studentId">
                        <input type="hidden" name="subjectId" id="subjectId">
                        <input type="hidden" name="teacherId" id="teacherId">
                        <input type="hidden" name="semesterName" value="<?= $subject->semester?>">
                        <button class="submitbtn" name="addGrade" onclick="submitForm()">Done</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/viewSubject.js"></script>
    <script>
        $(document).ready(function(){


        var specialElementHandlers = {
            "#editor": function (element,renderer){
                return true;
            }
        };

        $("#PrintGrades").click(function(){

            var doc = new jsPDF();

            doc.fromHTML($("#gradesContainer").html(), 15, 15, {
                "width": 170,
                "elementHandlers": specialElementHandlers
            });
            doc.save("grades-file.pdf");
        });
        });
    </script>
</body>
</html>