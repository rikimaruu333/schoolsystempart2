<?php
require_once "userconnection.php";
require "formfunctions.php";
usercheck_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['createSemester'])) {
        $errors = createSemester($_POST);
    } elseif (isset($_POST['updateSemester'])) {
        $errors = updateSemester($_POST);
    }
}

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
    <link rel="stylesheet" href="../css/semesters.css">
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
                <p class="name">Administrator</p>
                <p class="rank">Admin</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="admindashboard.php">
                    <i class="bx bxs-flag"></i>
                    <span class="nav-item">Departments</span>
                </a>
            </li>
            <li>
                <a href="" class="admindashboard_btn">
                    <i class="bx bx-sitemap"></i>
                    <span class="nav-item">Semesters</span>
                </a>
            </li>
            <li>
                <a href="teachers.php">
                    <i class="bx bx-user"></i>
                    <span class="nav-item">Teachers</span>
                </a>
            </li>
            <li>
                <a href="students.php">
                    <i class="bx bxs-user"></i>
                    <span class="nav-item">Students</span>
                </a>
            </li>
            <li>
                <a href="logout.php"onclick="return confirm('Log out account?');">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="maincontainer">
            <div class="semesterboxcontainer">
                <div class="createbtncontainer">
                    <button class="create_btn" id="createsemesterAccount" onclick="openCreateModal()">Create semester</button>
                </div>
                <div class="container">
                    <div class="semestertxt">Semester List :</div>
                    <div class="semester-box">
                        <?php
                        require_once("userconnection.php");
                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        $sql = "SELECT * FROM semester";
                        $result = $connection->query($sql);

                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <div class="semester-card">
                                    <div class="semester-info">
                                        <?= $row['semester'] ?>
                                    </div>
                                    <div class="buttons">
                                        <button class="update-semester-button" id="updateSemesterButton" onclick="openUpdateSemesterModal(<?= $row['semester_id'] ?>)"><img src="../images/update.png" alt=""></button>

                                        <a href="deleteSemester.php?semesterId=<?= $row['semester_id'] ?>" onclick="return confirm('Are you sure you want to delete this semester?');"><button class="delete-semester-button"><img src="../images/delete_review.png" alt=""></button></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="nosemester">No semester available.</div>
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
                    <h2 id="modalTitle">Create Semester</h2>
                    <form method="POST" enctype="multipart/form-data" id="semesterForm" class="createModal">
                        <div class="namedepartment">
                            <div class="name">
                                <label for="semesterName">Semester :</label>
                                <input type="text" name="semesterName" id="semesterName" placeholder="Enter semester" required>
                            </div>
                        </div>
                        <button class="submitbtn" name="createSemester" onclick="submitForm()">Create</button>
                    </form>
                </div>
            </div>
            <div id="updateModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeUpdateModal()">&times;</span>
                    <h2 id="modalTitle">Update Semester</h2>
                    <form method="POST" enctype="multipart/form-data" id="updateSemesterForm" class="createModal">
                        <input type="hidden" name="semesterId" id="updateSemesterId">
                        <div class="namedepartment">
                            <div class="name">
                                <label for="updateSemesterName">Semester :</label>
                                <input type="text" name="updateSemesterName" id="updateSemesterName" placeholder="Enter semester" required>
                            </div>
                        </div>
                        <button class="submitbtn" name="updateSemester" onclick="submitUpdateForm()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/semesters.js"></script>
</body>
</html>