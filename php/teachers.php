<?php
require_once "userconnection.php";
require "formfunctions.php";
usercheck_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['createTeacherAccount'])) {
        $errors = createTeacherAccount($_POST);
    } elseif (isset($_POST['updateTeacherAccount'])) {
        $errors = updateTeacherAccount($_POST);
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
    <link rel="stylesheet" href="../css/teachers.css">
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
                <a href="" class="admindashboard_btn">
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
            <div class="teacherboxcontainer">
                <div class="createbtncontainer">
                    <button class="create_btn" id="createTeacherAccount" onclick="openCreateModal()">Create teacher account</button>
                </div>
                <div class="container">
                    <div class="teachertxt">Teacher List :</div>
                    <div class="teacher-box">
                        <?php
                        require_once("userconnection.php");
                        $newconnection = new Connection();
                        $connection = $newconnection->openConnection();

                        $sql = "SELECT * FROM teachers WHERE usertype != 'Admin'";
                        $result = $connection->query($sql);

                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <div class="teacher-card">
                                    <div class="teacher-profile">
                                        <img src="<?= $row['teacher_profile'] ?>" alt="">
                                    </div>
                                    <div class="teacher-info">
                                        <div class="teacher-nametype">
                                            <div class="teacher-name">
                                                <?= $row['teacher_name'] ?>
                                            </div>
                                            <div class="teacher-type">
                                                <?= $row['department_name'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <button class="update-teacher-button" id="updateTeacherButton" onclick="openUpdateModal(<?= $row['teacher_id'] ?>)"><img src="../images/update.png" alt=""></button>

                                        <a href="deleteTeacher.php?teacherId=<?= $row['teacher_id']?>" onclick="return confirm('Are you sure you want to delete this teacher?');"><button class="delete-teacher-button"><img src="../images/delete_review.png" alt=""></button></a>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="noteacher">No teacher available.</div>
                        <?php
                        }
                        $newconnection->closeConnection();
                        ?>
                    </div>
                </div>
            </div>
            <?php
                require_once('userconnection.php');

                $newconnection = new Connection();
                $connection = $newconnection->openConnection();

                $stmt = $connection->prepare("SELECT * FROM department");
                $stmt->execute();
                $departments = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Create teacher's account</h2>
                    <form method="POST" enctype="multipart/form-data" id="teacherForm" class="createModal">
                        <div class="namedepartment">
                            <div class="name">
                                <label for="teacherName">Name:</label>
                                <input type="text" name="teacherName" id="teacherName" placeholder="Enter name" required>
                            </div>
                            <div class="department">
                                <label for="teacherDepartment">Department:</label>
                                <select name="teacherDepartment" id="teacherDepartment" required>
                                    <option></option>
                                    <?php
                                    foreach ($departments as $department) { 
                                    ?>
                                        <option value="<?=$department->department_id?>|<?=$department->department_name?>"><?=$department->department_name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <label for="teacherEmail">Email:</label>
                        <input type="text" name="teacherEmail" id="teacherEmail" placeholder="Enter email" required>
                        <label for="teacherPassword">Password:</label>
                        <div class="eyebutton"><img src="../images/show.png" alt="" class="icon" id="eyeicon"></div>
                        <input type="password" name="teacherPassword" id="teacherPassword" placeholder="Enter password" required>
                        <div class="container2">
                            <label for="profile" class="custom-file-input">Teacher Profile:</label>
                            <div class="profile_img" style="background-image: url('<?php echo $uploadedFilePath; ?>');"></div>
                            <div class="profile_input">
                                <div class="file-input-container">
                                    <input type="file" class="profile" id="profile" name="teacherProfile" onchange="handleFileSelect(this)" required>
                                    <div class="file-name"></div>
                                </div>
                            </div>
                        </div>
                        <button class="submitbtn" name="createTeacherAccount" onclick="submitForm()">Create</button>
                    </form>
                </div>
            </div>
            <div id="updateModal" class="modal">
                <div class="modal-content">
                    <span class="closeupdate" onclick="closeUpdateModal()">&times;</span>
                    <h2 id="modalTitle">Update Teacher's Account</h2>
                    <form method="POST" enctype="multipart/form-data" id="updateForm" class="updateModal">
                        <div class="namedepartment">
                            <div class="name">
                                <label for="updateTeacherName">Name:</label>
                                <input type="text" name="updateTeacherName" id="updateTeacherName" placeholder="Enter name" required>
                            </div>
                            <div class="department">
                                <label for="updateTeacherDepartment">Department:</label>
                                <select name="updateTeacherDepartment" id="updateTeacherDepartment" required>
                                    <option></option>
                                    <?php
                                    foreach ($departments as $department) { 
                                    ?>
                                        <option value="<?=$department->department_id?>|<?=$department->department_name?>"><?=$department->department_name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <label for="updateTeacherEmail">Email:</label>
                        <input type="text" name="updateTeacherEmail" id="updateTeacherEmail" placeholder="Enter email" required>
                        <label for="updateTeacherPassword">Password:</label>
                        <div class="eyebutton"><img src="../images/show.png" alt="" class="icon" id="updateEyeIcon"></div>
                        <input type="password" name="updateTeacherPassword" id="updateTeacherPassword" placeholder="Enter password" required>
                        <div class="container2">
                            <label for="updateProfile" class="custom-file-input">Teacher Profile:</label>
                            <div class="profile_img" id="updateProfile" style="background-image: url('<?php echo $uploadedFilePath; ?>');"></div>
                            <div class="profile_input">
                                <div class="file-input-container">
                                    <input type="file" class="profile" name="updateTeacherProfile" onchange="handleFileSelectUpdate(this)" required>
                                    <div class="file-name"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="updateTeacherId" id="updateTeacherId">
                        <button class="submitbtn" name="updateTeacherAccount" onclick="submitUpdateForm()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/teachers.js"></script>
</body>
</html>