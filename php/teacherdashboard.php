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
    <link rel="stylesheet" href="../css/teacherdashboard.css">
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
                <a href="" class="admindashboard_btn">
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
                <div class="studentcontainer">
                    <div class="studenttxt">Assigned-subject List :</div>
                    <div class="student-box">
                        <div class="studenttxt">First year subjects :</div>
                        <?php
                        require_once("userconnection.php");

                        $departmentId = $_SESSION['USER']->department_id;
                        $teacherId = $_SESSION['USER']->teacher_id;

                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        // Fetch subjects from the database
                        $sql = "SELECT * FROM subjects WHERE yearlevel_id = '1' AND department_id = :department_id AND teacher_id = :teacher_id ORDER BY subject_id";
                        $stmt = $connection->prepare($sql);
                        $stmt->bindParam(':department_id', $departmentId);
                        $stmt->bindParam(':teacher_id', $teacherId);
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
                                    <div class="buttons">
                                        <a href="viewSubject.php?subject_id=<?= $subjectId ?>"><button class="view-student-button"><img src="../images/search.png" alt=""></button></a>
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
                    <div class="student-box">
                        <div class="studenttxt">Second year subjects :</div>
                        <?php
                        require_once("userconnection.php");

                        $departmentId = $_SESSION['USER']->department_id;
                        $teacherId = $_SESSION['USER']->teacher_id;

                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        // Fetch subjects from the database
                        $sql = "SELECT * FROM subjects WHERE yearlevel_id = '2' AND department_id = :department_id AND teacher_id = :teacher_id ORDER BY subject_id";
                        $stmt = $connection->prepare($sql);
                        $stmt->bindParam(':department_id', $departmentId);
                        $stmt->bindParam(':teacher_id', $teacherId);
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
                                    <div class="buttons">
                                        <a href="viewsubject.php?subject_id=<?= $subjectId ?>"><button class="view-student-button"><img src="../images/search.png" alt=""></button></a>
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
                    <div class="student-box">
                        <div class="studenttxt">Third year subjects :</div>
                        <?php
                        require_once("userconnection.php");

                        $departmentId = $_SESSION['USER']->department_id;
                        $teacherId = $_SESSION['USER']->teacher_id;

                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        // Fetch subjects from the database
                        $sql = "SELECT * FROM subjects WHERE yearlevel_id = '3' AND department_id = :department_id AND teacher_id = :teacher_id ORDER BY subject_id";
                        $stmt = $connection->prepare($sql);
                        $stmt->bindParam(':department_id', $departmentId);
                        $stmt->bindParam(':teacher_id', $teacherId);
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
                                    <div class="buttons">
                                        <a href="viewsubject.php?subject_id=<?= $subjectId ?>"><button class="view-student-button"><img src="../images/search.png" alt=""></button></a>
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
                    <div class="student-box">
                        <div class="studenttxt">Fourth year subjects :</div>
                        <?php
                        require_once("userconnection.php");

                        $departmentId = $_SESSION['USER']->department_id;
                        $teacherId = $_SESSION['USER']->teacher_id;

                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        // Fetch subjects from the database
                        $sql = "SELECT * FROM subjects WHERE yearlevel_id = '4' AND department_id = :department_id AND teacher_id = :teacher_id ORDER BY subject_id";
                        $stmt = $connection->prepare($sql);
                        $stmt->bindParam(':department_id', $departmentId);
                        $stmt->bindParam(':teacher_id', $teacherId);
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
                                    <div class="buttons">
                                        <a href="viewsubject.php?subject_id=<?= $subjectId ?>"><button class="view-student-button"><img src="../images/search.png" alt=""></button></a>
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
        </div>
    </div>
    <script src="../js/teacherdashboard.js"></script>
</body>
</html>