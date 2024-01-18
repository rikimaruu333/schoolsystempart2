<?php
require_once "userconnection.php";
require "formfunctions.php";
usercheck_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['createCourse'])) {
        $errors = createCourse($_POST);
    } elseif (isset($_POST['updateCourse'])) {
        $errors = updateCourse($_POST);
    }
}


if (isset($_GET['department_id'])) {
    $departmentId = $_GET['department_id'];
    
    $newconnection = new Connection();
    $connection = $newconnection->openConnection();
    $stmt = $connection->prepare("SELECT * FROM department WHERE department_id = :department_id");
    $stmt->bindParam(':department_id', $departmentId);
    $stmt->execute();
    $department = $stmt->fetch(PDO::FETCH_OBJ);

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
    <link rel="stylesheet" href="../css/viewdepartment.css">
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
                <a href="semesters.php">
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
            <div class="txtbox2">Welcome to the <?= $department->department_acronym ?> department ! <br> Here are some of our available courses.</div>
            <div class="createbtncontainer">
                <button class="create_btn" id="createCourse" onclick="openCreateModal()">Create course</button>
            </div>
            <div class="courseboxcontainer">
                <div class="coursecontainer">
                    <div class="container1">
                        <div class="course-box">
                            <?php
                            require_once("userconnection.php");
                            $newconnection = new Connection();
                            $connection = $newconnection->openConnection();

                            $sql = "SELECT * FROM course WHERE department_id = $departmentId";
                            $result = $connection->query($sql);

                            if ($result->rowCount() > 0) {
                                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                            ?>
                                    <div class="course-card">
                                        <div class="course-profile">
                                            <img src="<?= $department->department_logo?>" alt="">
                                        </div>
                                        <div class="course-info">
                                            <div class="course-nametype">
                                                <div class="course-name">
                                                    <?= $row->course_acronym ?>
                                                </div>
                                                <div class="course-type">
                                                    <?= $row->course_name ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons">
                                            <button class="view-course-button" onclick="openCourseModal(<?= $row->course_id ?>)"><img src="../images/search.png" alt=""></button>
                                            
                                            <button class="update-course-button" id="updateCourseButton" onclick="openUpdateModal(<?= $row->course_id ?>)"><img src="../images/update.png" alt=""></button>

                                            <a href="deleteCourse.php?courseId=<?= $row->course_id?>&departmentId=<?= $row->department_id?>" onclick="return confirm('Are you sure you want to delete this course?');"><button class="delete-course-button"><img src="../images/delete_review.png" alt=""></button></a>

                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                            ?>
                                <div class="nocourse">No courses available.</div>
                            <?php
                            }
                            $newconnection->closeConnection();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Create Course</h2>
                    <form method="POST" enctype="multipart/form-data" id="courseForm" class="createModal">
                        <label for="courseName">Course Name:</label>
                        <input type="text" name="courseName" id="courseName" placeholder="Enter course name" required>
                        <label for="courseAcronym">Course Acronym:</label>
                        <input type="text" name="courseAcronym" id="courseAcronym" placeholder="Enter course acronym" required>
                        <input type="hidden" name="courseId" id="courseId">
                        <input type="hidden" name="departmentId" id="departmentId" value="<?= $department->department_id?>">
                        <button class="submitbtn" name="createCourse" onclick="submitForm()">Create</button>
                    </form>
                </div>
            </div>
            <div id="updateModal" class="modal">
                <div class="modal-content">
                    <span class="closeupdate" onclick="closeUpdateModal()">&times;</span>
                    <h2 id="updateModalTitle">Update Course</h2>
                    <form method="POST" enctype="multipart/form-data" id="updateForm" class="updateModal">
                        <label for="updateCourseName">Course Name:</label>
                        <input type="text" name="courseName" id="updateCourseName" placeholder="Enter course name" required>
                        <label for="updateCourseAcronym">Course Acronym:</label>
                        <input type="text" name="courseAcronym" id="updateCourseAcronym" placeholder="Enter course acronym" required>
                        <input type="hidden" name="courseId" id="updateCourseId">
                        <input type="hidden" name="departmentId" id="departmentId" value="<?= $department->department_id?>">
                        <button class="submitbtn" name="updateCourse" onclick="submitUpdateForm()">Update</button>
                    </form>
                </div>
            </div>

            <div id="openCourseModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeCourseModal()">&times;</span>
                    <h2 id="modalTitle">Year Levels</h2>
                    
                    <div class="year-level-type" id="CourseName"></div>

                    <?php
                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        $stmt = $connection->prepare("SELECT * FROM yearlevels");
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

                        // Define arrays
                        $var = 1;
                        foreach ($results as $yearLevel) {
                            // Loop through indices
                                ?>
                                <div class="year-level-card">
                                    <div class="year-level-profile">
                                        <img src="<?= $department->department_logo ?>" alt="">
                                    </div>
                                    <div class="year-level-info">
                                        <div class="year-level-nametype">
                                            <div class="year-level-name">
                                                <div class="year-level"><?= $yearLevel->year_level ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="yearLevelpage.php" method="get">
                                        <input type="hidden" name="department_id" value="<?= $departmentId ?>">
                                        <input type="hidden" name="yearlevel_id" value="<?= $yearLevel->yearlevel_id ?>">
                                        <input type="hidden" name="course_id" id="<?= 'CourseId' . $var ?>">
                                        <div class="buttons">
                                            <button type="submit" class="view-course-button">
                                                <img src="../images/search.png" alt="">
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                $var++;
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <script src="../js/viewdepartment.js"></script>
</body>
</html>