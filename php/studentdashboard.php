<?php
require "formfunctions.php";
usercheck_login();



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
    <link rel="stylesheet" href="../css/studentdashboard.css">
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
            <img src="../images/user.jpg" alt="">
            <div>
                <p class="name"><?= $_SESSION['USER']->student_name?></p>
                <p class="rank">Student</p>
            </div>
        </div>
        <ul>
            <li class="dashboard_btn">
                <a href="" class="admindashboard_btn">
                    <i class="bx bxs-grid-alt"></i>
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
                <div class="studentcontainer">
                    <div class="studenttxt"><?=$_SESSION['USER']->course_name?></div>
                    <div class="studenttxt">Subjects :</div>
                    <div class="student-box">
                        <?php
                            require_once("userconnection.php");

                            $departmentId = $_SESSION['USER']->department_id;
                            $yearlevelId = $_SESSION['USER']->yearlevel_id;
                            $courseId = $_SESSION['USER']->course_id;
                            $studentId = $_SESSION['USER']->student_id;

                            $newconnection = new Connection();
                            $connection = $newconnection->openConnection();

                            $sql = "SELECT * FROM subjects WHERE yearlevel_id = :yearlevel_id AND course_id = :course_id AND department_id = :department_id ORDER BY subject_id";
                            $stmt = $connection->prepare($sql);
                            $stmt->bindParam(':department_id', $departmentId, PDO::PARAM_INT);
                            $stmt->bindParam(':yearlevel_id', $yearlevelId, PDO::PARAM_INT);
                            $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $subjectId = $row['subject_id'];
                                    ?>
                                    <div class="student-card">
                                        <div class="studentprofileinfo">
                                            <div class="student-profile">
                                            </div>
                                            <div class="student-info">
                                                <div class="student-nametype">
                                                    <div class="student-name">
                                                        <?= $row['subject_name'] ?>
                                                    </div>
                                                    <div class="student-type">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="courselevel">
                                            <?= $row['descriptive_title'] ?>
                                        </div>
                                        <div class="courselevel">
                                            Instructor : <?= $row['teacher_name'] ?>
                                        </div>
                                        <div class="buttons">
                                            <button class="view-student-button" onclick="openCreateModal(<?= $row['subject_id'] ?>,<?= $studentId ?>)"><img src="../images/search.png" alt=""></button>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="nostudent">No subject available.</div>
                                <?php
                            }

                            $newconnection->closeConnection();
                        ?>
                    </div>
                </div>
            </div>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <label id="studentName"></label>
                    <form method="POST" enctype="multipart/form-data" id="semesterForm" class="createModal">
                        <div class="namedepartment">
                            <div class="name">
                                <label>Prelim :</label>
                                <label for="" id="prelimScore"></label>
                            </div>
                            <div class="department">
                                <label>Midterm :</label>
                                <label for="" id="midtermScore"></label>
                            </div>
                        </div>
                        <div class="namedepartment">
                            <div class="name">
                                <label>Semi-Final :</label>
                                <label for="" id="semifinalScore"></label>
                            </div>
                            <div class="department">
                                <label>Final :</label>
                                <label for="" id="finalScore"></label>
                            </div>
                        </div>
                        <br><h1>FINAL GRADE :</h1>
                        <h2 id="finalGrade" name="finalGrade"></h2>
                        <p id="remarks"></p>
                        <input type="hidden" name="studentId" id="studentId">
                        <input type="hidden" name="subjectId" id="subjectId">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/studentdashboard.js"></script>
</body>
</html>