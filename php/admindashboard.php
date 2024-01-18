<?php
require "formfunctions.php";
usercheck_login();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['createDepartment'])) {
        $errors = createDepartment($_POST);
    } elseif (isset($_POST['updateDepartment'])) {
        $errors = updateDepartment($_POST);
    }

    if (count($errors) == 0) {
        header("Location: admindashboard.php");
        die;
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
    <link rel="stylesheet" href="../css/admindashboard.css">
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
                <a href="" class="admindashboard_btn">
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
        <div class="maincontainer1">
            <div class="profilebox">
                <div class="profile">
                    <img src="../images/crmclogo.png" alt="">
                </div>
            </div>
            <button class="create_btn" id="createDepartment" onclick="openCreateModal()">Create new department</button>
        </div>
        <div class="maincontainer2">
            <div class="container">
                <div class="department-box">
                    <?php
                    require_once("userconnection.php");
                    $newconnection = new Connection();
                    $connection = $newconnection->openConnection();

                    $sql = "SELECT * FROM department";
                    $result = $connection->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <div class="department-card">
                                <div class="department-profile">
                                    <img src="<?= $row['department_logo'] ?>" alt="">
                                </div>
                                <div class="department-info">
                                    <div class="department-nametype">
                                        <div class="department-name">
                                            <?= $row['department_acronym'] ?>
                                        </div>
                                        <div class="department-type">
                                            <?= $row['department_name'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <a href="viewdepartment.php?department_id=<?= $row['department_id']?>"><button class="view-department-button"><img src="../images/search.png" alt=""></button></a>
                                    
                                    <button class="update-department-button" id="updateDepartmentButton" onclick="openUpdateModal(<?= $row['department_id'] ?>)"><img src="../images/update.png" alt=""></button>

                                    <a href="deleteDepartment.php?departmentId=<?= $row['department_id']?>" onclick="return confirm('Are you sure you want to delete this department?');"><button class="delete-department-button"><img src="../images/delete_review.png" alt=""></button></a>

                                </div>
                            </div>
                    <?php
                        }
                    } else {
                    ?>
                        <div class="nodepartment">No departments available.</div>
                    <?php
                    }
                    $newconnection->closeConnection();
                    ?>
                </div>
            </div>

            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 id="modalTitle">Create Department</h2>
                    <form method="POST" enctype="multipart/form-data" id="departmentForm" class="createModal">
                        <!-- Department Name input -->
                        <label for="departmentName">Department Name:</label>
                        <input type="text" name="departmentName" id="departmentName" placeholder="Enter department name" required>

                        <label for="departmentAcronym">Department Acronym:</label>
                        <input type="text" name="departmentAcronym" id="departmentAcronym" placeholder="Enter department acronym" required>
                        <!-- Department Logo input -->
                        <div class="container2">
                            <label for="logo" class="custom-file-input">Departent Logo:</label>
                            <div class="profile_img" style="background-image: url('<?php echo $uploadedFilePath; ?>');"></div>
                            <div class="profile_input">
                                <div class="file-input-container">
                                    <input type="file" class="logo" id="logo" name="departmentLogo" onchange="handleFileSelect(this)" required>
                                    <div class="file-name"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="departmentId" id="departmentId">
                        <button class="submitbtn" name="createDepartment" onclick="submitForm()">Create</button>
                    </form>
                </div>
            </div>

            <div id="updateModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="closeupdate" onclick="closeUpdateModal()">&times;</span>
                    <h2 id="updateModalTitle">Update Department</h2>
                    <form method="POST" enctype="multipart/form-data" id="updateForm" class="updateModal">
                        <!-- Department Name input -->
                        <label for="updateDepartmentName">Department Name:</label>
                        <input type="text" name="departmentName" id="updateDepartmentName" placeholder="Enter department name" required>

                        <label for="updateDepartmentAcronym">Department Acronym:</label>
                        <input type="text" name="departmentAcronym" id="updateDepartmentAcronym" placeholder="Enter department acronym" required>
                        <!-- Department Logo input -->
                        <div class="container2">
                            <label for="logo" class="custom-file-input">Department Logo:</label>
                            <div class="profile_img2" id="updateLogo2" style="background-image: url('<?php echo $uploadedFilePath; ?>');"></div>
                            <div class="profile_input">
                                <div class="file-input-container">
                                    <input type="file" class="logo" id="updateLogo" name="departmentLogo" onchange="handleFileSelect2(this)" required>
                                    <div class="file-name" id="updateFileName"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="departmentId" id="updateDepartmentId">
                        <button class="submitbtn" name="updateDepartment" onclick="submitUpdateForm()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/admindashboard.js"></script>
</body>
</html>