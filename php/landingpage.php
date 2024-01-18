<?php
require "formfunctions.php";

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['studentLogin'])) {
        $errors = studentLogin($_POST);
    } elseif (isset($_POST['teacherLogin'])) {
        $errors = teacherLogin($_POST);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/landingpage.css">
</head>
<body>
    <div class="screencontainer">
        <div class="daddycontainer">
            <div class="headcontainer" id="head">
                <img src="../images/crmclogo.png" alt="" class = "logo">
                <div class="header-buttons">
                </div>
            </div>
            <div class="pagecontainer">
                <div class="textcontainer">
                    <div class="hellotxt"><font class="hello">HELLO</font> <font color="#251a9e" class="user">USERS</font><br></div>
                    <div class="welcome">
                        Welcome to Cebu Roosevelt Memorial Colleges! <br>
                        Explore your educational journey with us.
                    </div>
                    <br><br><br><br>
                </div>
                <div class="signup-buttons">
                        <button class="clientsignup_btn" onclick="openStudentLoginModal()">STUDENT ACCOUNT LOGIN</button>
                        <button class="freelancersignup_btn" onclick="openTeacherLoginModal()">TEACHER ACCOUNT LOGIN</button>
                </div>
            </div>
            <div id="studentModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeStudentModal()">&times;</span>
                    <h2 id="modalTitle">Student Login</h2>
                    <form method="POST" enctype="multipart/form-data" class="createModal">
                        <label for="studentEmail">Email:</label>
                        <input type="text" name="studentEmail" id="studentEmail" placeholder="Enter email" required>
                        <label for="studentPassword">Password:</label>
                        <div class="eyebutton"><img src="../images/show.png" alt="" class="icon" id="studenteyeicon"></div>
                        <input type="password" name="studentPassword" id="studentPassword" placeholder="Enter password" required>
                        <button class="login_btn" name="studentLogin" onclick="submitForm()">LOGIN</button>
                    </form>
                </div>
            </div>
            <div id="teacherModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeTeacherModal()">&times;</span>
                    <h2 id="modalTitle">Teacher Login</h2>
                    <form method="POST" enctype="multipart/form-data" class="createModal">
                        <label for="teacherEmail">Email:</label>
                        <input type="text" name="teacherEmail" id="teacherEmail" placeholder="Enter email" required>
                        <label for="teacherPassword">Password:</label>
                        <div class="eyebutton"><img src="../images/show.png" alt="" class="icon" id="teachereyeicon"></div>
                        <input type="password" name="teacherPassword" id="teacherPassword" placeholder="Enter password" required>
                        <button class="login_btn" name="teacherLogin" onclick="submitForm()">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/landingpage.js"></script>
</body>
</html>