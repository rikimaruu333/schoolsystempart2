<?php
require_once "userconnection.php";
require "formfunctions.php";
usercheck_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['createSubject'])) {
        $errors = createSubject($_POST);
    } elseif (isset($_POST['updateSubject'])) {
        $errors = updateSubject($_POST);
    } elseif (isset($_POST['assignTeacherToSubject'])) {
        $errors = assignTeacherToSubject($_POST);
    }
}

if (isset($_GET['department_id']) && isset($_GET['course_id']) && isset($_GET['yearlevel_id'])) {
    $departmentId = $_GET['department_id'];
    $courseId = $_GET['course_id'];
    $yearlevelId = $_GET['yearlevel_id'];
    
    $newconnection = new Connection();
    $connection = $newconnection->openConnection();

    $stmt = $connection->prepare("SELECT * FROM course WHERE department_id = :department_id AND course_id = :course_id");
    $stmt->bindParam(':department_id', $departmentId);
    $stmt->bindParam(':course_id', $courseId);
    $stmt->execute();
    $course = $stmt->fetch(PDO::FETCH_OBJ);

    $stmtDepartment = $connection->prepare("SELECT * FROM department WHERE department_id = :department_id");
    $stmtDepartment->bindParam(':department_id', $departmentId);
    $stmtDepartment->execute();
    $department = $stmtDepartment->fetch(PDO::FETCH_OBJ);
    
    $stmtyearlevel = $connection->prepare("SELECT * FROM yearlevels WHERE yearlevel_id = :yearlevel_id");
    $stmtyearlevel->bindParam(':yearlevel_id', $yearlevelId);
    $stmtyearlevel->execute();
    $yearlevel = $stmtyearlevel->fetch(PDO::FETCH_OBJ);


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
    <link rel="stylesheet" href="../css/yearLevelPage.css">
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
            <div class="txtbox2">Subjects for <?=$yearlevel->year_level?> students taking the <?= $course->course_name ?>.</div>
            <div class="createbtncontainer">
                <button class="create_btn" id="createSubject" onclick="openCreateModal()">Create Subject</button>
            </div>
            <div class="courseboxcontainer">
                <?php
                $newconnection = new Connection();
                $connection = $newconnection->openConnection();

                $stmt = $connection->prepare("SELECT * FROM semester");
                $stmt->execute();
                $semesters = $stmt->fetchAll(PDO::FETCH_OBJ);

                foreach($semesters as $semester){
                    
                
                $sem = $semester->semester_id;
                ?>
                <div class="coursecontainer">
                    <div class="semestertxt"><?=$semester->semester?></div>
                    <div class="container1">
                        <?php
                            $newconnection = new Connection();
                            $connection = $newconnection->openConnection();

                            $stmt = $connection->prepare("SELECT * FROM subjects WHERE department_id = :department_id AND course_id = :course_id AND yearlevel_id = :yearlevel_id AND semester_id = :sem");
                            $stmt->bindParam(':department_id', $departmentId);
                            $stmt->bindParam(':course_id', $courseId);
                            $stmt->bindParam(':yearlevel_id', $yearlevelId);
                            $stmt->bindParam(':sem', $sem);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                            if (empty($result)) {
                                // Handle case where no subjects are found
                                echo "<div class='nosubject'>No subject found.</div>";
                            } else {
                        ?>  
                        <div class="tablecontainer">
                            <table class="course-table">
                                <thead>
                                    <tr>
                                        <th id="tableheadersubject">Subject No.</th>
                                        <th id="tableheadersubjectname">Descriptive Title</th>
                                        <th id="tableheaderinstructor">Instructor</th>
                                        <th id="tableheaderaction">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $subject) : ?>
                                        <tr>
                                            <td><?= $subject->subject_name ?></td>
                                            <td><?= $subject->descriptive_title ?></td>
                                            <td><?= $subject->teacher_name ?></td>
                                            <td>
                                                <div class="buttons">
                                                    <button class="assign-teacher-button" id="assignTeacherButton" onclick="openAssignModal(<?=$subject->subject_id?>)"><img src="../images/assignteacher.png" alt=""></button>

                                                    <button class="update-subject-button" id="updateSubjectButton" onclick="openUpdateModal(<?= $subject->subject_id ?>)"><img src="../images/update.png" alt=""></button>

                                                    <a href="deleteSubject.php?
                                                    subjectId=<?= $subject->subject_id ?>
                                                    &departmentId=<?= $subject->department_id ?>
                                                    &courseId=<?= $subject->course_id ?>
                                                    &yearlevelId=<?= $subject->yearlevel_id ?>" 
                                                    onclick="return confirm('Are you sure you want to delete this subject?');">
                                                        <button class="delete-subject-button"><img src="../images/delete_review.png" alt=""></button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            require_once('userconnection.php');

            $newconnection = new Connection();
            $connection = $newconnection->openConnection();

            $stmt = $connection->prepare("SELECT * FROM semester");
            $stmt->execute();
            $semesters = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Create subject</h2>
                    <form method="POST" enctype="multipart/form-data" id="subjectForm" class="createModal">
                        <label>Subject No:</label>
                        <input type="text" name="subjectName" id="subjectName" placeholder="Enter subject no." required>
                        <label>Descriptive Title:</label>
                        <input type="text" name="descriptiveTitle" id="subjectName" placeholder="Enter desciptive title" required>
                        <label>Semester:</label>
                        <select name="semester" id="subjectSemester" required>
                            <option></option>
                            <?php
                            foreach ($semesters as $semester) { 
                            ?>
                                <option value="<?=$semester->semester_id?>|<?=$semester->semester?>"><?=$semester->semester?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" name="departmentId" id="departmentId" value="<?= $department->department_id?>">
                        <input type="hidden" name="courseId" id="courseId" value="<?= $course->course_id?>">
                        <input type="hidden" name="yearlevelId" id="yearlevelId" value="<?= $yearlevel->yearlevel_id?>">
                        <button class="submitbtn" name="createSubject" onclick="submitForm()">Create</button>
                    </form>
                </div>
            </div>
            <div id="updateModal" class="modal">
                <div class="modal-content">
                    <span class="closeupdate" onclick="closeUpdateModal()">&times;</span>
                    <h2 id="modalTitle">Update Subject</h2>
                    <form method="POST" enctype="multipart/form-data" id="updateForm" class="updateModal">
                        <label>Subject No:</label>
                        <input type="text" name="subjectName" id="updateSubjectName" placeholder="Enter subject no." required>
                        <label>Descriptive Title:</label>
                        <input type="text" name="descriptiveTitle" id="updateDescriptiveTitle" placeholder="Enter descriptive title" required>
                        <label>Semester:</label>
                        <select name="semester" id="updateSubjectSemester" required>
                            <option></option>
                            <option value="First Semester" <?= $subject->semester === 'First Semester' ? 'selected' : '' ?>>First Semester</option>
                            <option value="Second Semester" <?= $subject->semester === 'Second Semester' ? 'selected' : '' ?>>Second Semester</option>
                        </select>
                        <input type="hidden" name="subjectId" id="updateSubjectId">
                        <button class="submitbtn" name="updateSubject" onclick="submitUpdateForm()">Update</button>
                    </form>
                </div>
            </div>
            <?php
                require_once('userconnection.php');

                $newconnection = new Connection();
                $connection = $newconnection->openConnection();

                $stmt = $connection->prepare("SELECT * FROM teachers WHERE department_id = :department_id");
                $stmt->bindParam(':department_id', $departmentId);
                $stmt->execute();
                $teachers = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
            <div id="assignModal" class="modal">
                <div class="modal-content">
                    <span class="closeassign" onclick="closeAssignModal()">&times;</span>
                    <h2 id="modalTitle">Assign a Teacher</h2>
                    <form method="POST" enctype="multipart/form-data" id="assignForm" class="assignModal">
                        <label>Department teachers:</label>
                        <select name="departmentTeacher" id="departmentTeacher" required>
                            <option></option>
                            <?php
                            foreach ($teachers as $teacher) { 
                            ?>
                                <option value="<?=$teacher->teacher_id?>|<?=$teacher->teacher_name?>"><?=$teacher->teacher_name?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" name="subjectId" id="assignSubjectId">
                        <button class="submitbtn" name="assignTeacherToSubject" onclick="submitAssignForm()">Assign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/yearLevelPage.js"></script>
</body>
</html>