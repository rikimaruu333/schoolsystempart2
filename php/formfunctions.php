<?php

session_start();

function createDepartment($data)
{
    $errors = array();

    // Check if a file is uploaded
    if (!empty($_FILES["departmentLogo"]["name"])) {
        $uploadedFilePath = null;
        $target_dir = "../profile/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES["departmentLogo"]["name"]);

        // Check if file is an actual image
        $check = getimagesize($_FILES["departmentLogo"]["tmp_name"]);
        if ($check !== false) {
            // Upload the file to the specified directory
            if (move_uploaded_file($_FILES["departmentLogo"]["tmp_name"], $target_file)) {
                $uploadedFilePath = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errors[] = "File is not an image.";
        }
    } else {
        $errors[] = "Please select a file for the department logo.";
    }

    // Insert a new record into the 'department' table only if there are no errors
    if (count($errors) == 0) {
        $query = "INSERT INTO department (department_name, department_acronym, department_logo)
                  VALUES (:departmentName, :departmentAcronym, :departmentLogo)";

        $arr['departmentName'] = $data['departmentName'];
        $arr['departmentAcronym'] = $data['departmentAcronym'];
        $arr['departmentLogo'] = $uploadedFilePath;

        // Assuming userdata function is used for database interaction
        // Make sure to replace it with your actual database interaction function
        userdata($query, $arr);
    }

    return $errors;
}

function updateDepartment($data)
{
    $errors = array();

    // Check if a file is uploaded
    if (!empty($_FILES["departmentLogo"]["name"])) {
        $uploadedFilePath = null;
        $target_dir = "../profile/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES["departmentLogo"]["name"]);

        // Check if file is an actual image
        $check = getimagesize($_FILES["departmentLogo"]["tmp_name"]);
        if ($check !== false) {
            // Upload the file to the specified directory
            if (move_uploaded_file($_FILES["departmentLogo"]["tmp_name"], $target_file)) {
                $uploadedFilePath = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errors[] = "File is not an image.";
        }
    }

    // Update the record in the 'department' table only if there are no errors
    if (count($errors) == 0) {
        $query = "UPDATE department 
                  SET department_name = :departmentName, 
                      department_acronym = :departmentAcronym, 
                      department_logo = :departmentLogo
                  WHERE department_id = :departmentId";

        $arr['departmentName'] = $data['departmentName'];
        $arr['departmentAcronym'] = $data['departmentAcronym'];
        $arr['departmentLogo'] = $uploadedFilePath;
        $arr['departmentId'] = $data['departmentId'];

        // Assuming userdata function is used for database interaction
        // Make sure to replace it with your actual database interaction function
        userdata($query, $arr);
    }

    return $errors;
}

function createCourse($data)
{
    $errors = array();


    if (count($errors) == 0) {
        $query = "INSERT INTO course (department_id, course_name, course_acronym)
                  VALUES (:departmentId, :courseName, :courseAcronym)";

        $arr['departmentId'] = $data['departmentId'];
        $arr['courseName'] = $data['courseName'];
        $arr['courseAcronym'] = $data['courseAcronym'];

        userdata($query, $arr);
        
        $departmentId = $arr['departmentId'];

        header("Location: viewdepartment.php?department_id=$departmentId");
        die;
    }

    return $errors;
}

function updateCourse($data)
{
    $errors = array();


    if (count($errors) == 0) {
        $query = "UPDATE course 
                  SET course_name = :courseName, 
                      course_acronym = :courseAcronym
                  WHERE course_id = :courseId";

        $arr['courseName'] = $data['courseName'];
        $arr['courseAcronym'] = $data['courseAcronym'];
        $arr['courseId'] = $data['courseId'];

        userdata($query, $arr);
    }

    return $errors;
}

function createSemester($data)
{
    $errors = array();

    if (count($errors) == 0) {
        $query = "INSERT INTO semester (semester)
                  VALUES (:semesterName)";

        $arr['semesterName'] = $data['semesterName'];

        userdata($query, $arr);

        header("Location: semesters.php");
        die;
    }

    return $errors;
}

function updateSemester($data)
{
    $errors = array();

    if (count($errors) == 0) {
        $query = "UPDATE semester 
                  SET semester = :semesterName
                  WHERE semester_id = :semesterId";

        $arr['semesterName'] = $data['updateSemesterName'];
        $arr['semesterId'] = $data['semesterId'];

        userdata($query, $arr);
    }

    return $errors;
}

function createSubject($data)
{
    $errors = array();

    if (count($errors) == 0) {
        
        list($semesterId, $semesterName) = explode('|', $data['semester']);

        $query = "INSERT INTO subjects (department_id, course_id, yearlevel_id, semester_id, subject_name, descriptive_title, semester)
                  VALUES (:departmentId, :courseId, :yearlevelId, :semesterId, :subjectName, :descriptiveTitle, :semesterName)";

        $arr['departmentId'] = $data['departmentId'];
        $arr['courseId'] = $data['courseId'];
        $arr['yearlevelId'] = $data['yearlevelId'];
        $arr['subjectName'] = $data['subjectName'];
        $arr['descriptiveTitle'] = $data['descriptiveTitle'];
        $arr['semesterId'] = $semesterId;
        $arr['semesterName'] = $semesterName;

        userdata($query, $arr);
        
        $departmentId = $arr['departmentId'];
        $courseId = $arr['courseId'];
        $yearlevelId = $arr['yearlevelId'];

        header("Location: yearLevelPage.php?department_id=$departmentId&course_id=$courseId&yearlevel_id=$yearlevelId");
        die;
    }

    return $errors;
}

function updateSubject($data)
{
    $errors = array();

    if (count($errors) == 0) {
        $query = "UPDATE subjects 
                  SET subject_name = :subjectName,
                      descriptive_title = :descriptiveTitle,
                      semester = :semester
                  WHERE subject_id = :subjectId";

        $arr['subjectName'] = $data['subjectName'];
        $arr['descriptiveTitle'] = $data['descriptiveTitle'];
        $arr['semester'] = $data['semester'];
        $arr['subjectId'] = $data['subjectId'];

        userdata($query, $arr);
    }

    return $errors;
}

function assignTeacherToSubject($data)
{
    $errors = array();

    if (count($errors) == 0) {

        list($teacherId, $teacherName) = explode('|', $data['departmentTeacher']);

        $query = "UPDATE subjects 
                  SET teacher_id = :teacherId, 
                      teacher_name = :teacherName
                  WHERE subject_id = :subjectId";

        $arr['teacherId'] = $teacherId;
        $arr['teacherName'] = $teacherName;
        $arr['subjectId'] = $data['subjectId'];

        userdata($query, $arr);
    }

    return $errors;
}


function createTeacherAccount($data)
{
    $errors = array();

    // Check if a file is uploaded
    if (!empty($_FILES["teacherProfile"]["name"])) {
        $uploadedFilePath = null;
        $target_dir = "../profile/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES["teacherProfile"]["name"]);

        // Check if file is an actual image
        $check = getimagesize($_FILES["teacherProfile"]["tmp_name"]);
        if ($check !== false) {
            // Upload the file to the specified directory
            if (move_uploaded_file($_FILES["teacherProfile"]["tmp_name"], $target_file)) {
                $uploadedFilePath = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your profile image.";
            }
        } else {
            $errors[] = "File is not an image.";
        }
    } else {
        $errors[] = "Please select a profile image for the teacher.";
    }

    // Insert a new record into the 'teachers' table only if there are no errors
    if (count($errors) == 0) {

        list($departmentId, $departmentName) = explode('|', $data['teacherDepartment']);

            $query = "INSERT INTO teachers (teacher_name, teacher_email, teacher_password, department_id, department_name, teacher_profile)
                      VALUES (:teacherName, :teacherEmail, :teacherPassword, :departmentId, :departmentName, :teacherProfile)";

            $arr['teacherName'] = $data['teacherName'];
            $arr['teacherEmail'] = $data['teacherEmail'];
            $arr['teacherPassword'] = $data['teacherPassword'];
            $arr['departmentId'] = $departmentId;
            $arr['departmentName'] = $departmentName; // Make sure department_name is set
            $arr['teacherProfile'] = $uploadedFilePath;

            userdata($query, $arr);
    }

    return $errors;
}

function updateTeacherAccount($data)
{
    $errors = array();

    // Check if a file is uploaded
    if (!empty($_FILES["updateTeacherProfile"]["name"])) {
        $uploadedFilePath = null;
        $target_dir = "../profile/"; // Directory where uploaded files will be stored
        $target_file = $target_dir . basename($_FILES["updateTeacherProfile"]["name"]);

        // Check if file is an actual image
        $check = getimagesize($_FILES["updateTeacherProfile"]["tmp_name"]);
        if ($check !== false) {
            // Upload the file to the specified directory
            if (move_uploaded_file($_FILES["updateTeacherProfile"]["tmp_name"], $target_file)) {
                $uploadedFilePath = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your profile image.";
            }
        } else {
            $errors[] = "File is not an image.";
        }
    }

    // Update the record in the 'teachers' table only if there are no errors
    if (count($errors) == 0) {
        list($departmentId, $departmentName) = explode('|', $data['updateTeacherDepartment']);

        $query = "UPDATE teachers
                  SET teacher_name = :teacherName,
                      teacher_email = :teacherEmail,
                      teacher_password = :teacherPassword,
                      department_id = :departmentId,
                      department_name = :departmentName,
                      teacher_profile = :teacherProfile
                  WHERE teacher_id = :teacherId";

        $arr['teacherName'] = $data['updateTeacherName'];
        $arr['teacherEmail'] = $data['updateTeacherEmail'];
        $arr['teacherPassword'] = $data['updateTeacherPassword'];
        $arr['departmentId'] = $departmentId;
        $arr['departmentName'] = $departmentName;
        $arr['teacherProfile'] = $uploadedFilePath;
        $arr['teacherId'] = $data['updateTeacherId'];

        userdata($query, $arr);
    }

    return $errors;
}

function createStudentAccount($data)
{
    $errors = array();
    
    if (count($errors) == 0) {
        list($departmentId, $departmentName) = explode('|', $data['studentDepartment']);
        list($courseId, $courseName) = explode('|', $data['studentCourse']);
        list($yearlevelId, $yearLevel) = explode('|', $data['studentYearlevel']);

        $query = "INSERT INTO students (student_name, student_email, student_password, department_id, department_name, course_id, course_name, yearlevel_id, year_level)
                  VALUES (:studentName, :studentEmail, :studentPassword, :departmentId, :departmentName, :courseId, :courseName, :yearlevelId, :yearLevel)";

        $arr['studentName'] = $data['studentName'];
        $arr['studentEmail'] = $data['studentEmail'];
        $arr['studentPassword'] = $data['studentPassword'];
        $arr['departmentId'] = $departmentId;
        $arr['departmentName'] = $departmentName;
        $arr['courseId'] = $courseId;
        $arr['courseName'] = $courseName;
        $arr['yearlevelId'] = $yearlevelId;
        $arr['yearLevel'] = $yearLevel;

        userdata($query, $arr);
    }

    return $errors;
}

function updateStudentAccount($data)
{
    $errors = array();

    if (count($errors) == 0) {
        list($departmentId, $departmentName) = explode('|', $data['updateStudentDepartment']);
        list($courseId, $courseName) = explode('|', $data['updateStudentCourse']);
        list($yearlevelId, $yearLevel) = explode('|', $data['updateStudentYearlevel']);

        $query = "UPDATE students 
                  SET student_name = :studentName,
                      student_email = :studentEmail,
                      student_password = :studentPassword,
                      department_id = :departmentId,
                      department_name = :departmentName,
                      course_id = :courseId,
                      course_name = :courseName,
                      yearlevel_id = :yearlevelId,
                      year_level = :yearLevel
                  WHERE student_id = :studentId";

        $arr['studentName'] = $data['updateStudentName'];
        $arr['studentEmail'] = $data['updateStudentEmail'];
        $arr['studentPassword'] = $data['updateStudentPassword'];
        $arr['departmentId'] = $departmentId;
        $arr['departmentName'] = $departmentName;
        $arr['courseId'] = $courseId;
        $arr['courseName'] = $courseName;
        $arr['yearlevelId'] = $yearlevelId;
        $arr['yearLevel'] = $yearLevel;
        $arr['studentId'] = $data['updateStudentId'];

        userdata($query, $arr);
    }

    return $errors;
}

function addGrade($data)
{
    $errors = array();

    if (empty($data['prelimScore']) && empty($data['midtermScore']) && empty($data['semifinalScore']) && empty($data['finalScore'])) {
        $errors[] = "At least one field is required.";
    } else {
        $studentId = $data['studentId'];
        $subjectId = $data['subjectId'];
        $teacherId = $data['teacherId'];
        $prelimScore = isset($data['prelimScore']) ? floatval($data['prelimScore']) : 0;
        $midtermScore = isset($data['midtermScore']) ? floatval($data['midtermScore']) : 0;
        $semifinalScore = isset($data['semifinalScore']) ? floatval($data['semifinalScore']) : 0;
        $finalScore = isset($data['finalScore']) ? floatval($data['finalScore']) : 0;
        $semesterName = $data['semesterName'];

        // Calculate the final grade
        $totalPointsEarned = $prelimScore + $midtermScore + $semifinalScore + $finalScore;
        $maxPoints = 400; // Assuming the maximum possible points for all scores is 100 each
        $finalGrade = number_format(($totalPointsEarned / $maxPoints) * 100, 2);

        // Add additional validation if needed

        if (count($errors) == 0) {
            $newconnection = new Connection();
            $connection = $newconnection->openConnection();

            // Check if a grade already exists for the student and subject
            $checkStmt = $connection->prepare("SELECT * FROM grades WHERE student_id = :student_id AND subject_id = :subject_id AND teacher_id = :teacher_id");
            $checkStmt->bindParam(':student_id', $studentId);
            $checkStmt->bindParam(':subject_id', $subjectId);
            $checkStmt->bindParam(':teacher_id', $teacherId);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                // If a grade exists, update the existing record
                $query = "UPDATE grades
                          SET prelim = COALESCE(:prelim_score, prelim),
                              midterm = COALESCE(:midterm_score, midterm),
                              semi_finals = COALESCE(:semifinal_score, semi_finals),
                              finals = COALESCE(:final_score, finals),
                              final_grade = :final_grade
                          WHERE student_id = :student_id AND subject_id = :subject_id  AND teacher_id = :teacher_id";

                $arr = array(
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'prelim_score' => $prelimScore,
                    'midterm_score' => $midtermScore,
                    'semifinal_score' => $semifinalScore,
                    'final_score' => $finalScore,
                    'final_grade' => $finalGrade
                );
            } else {
                // If no grade exists, insert a new record
                $query = "INSERT INTO grades (student_id, subject_id, teacher_id, prelim, midterm, semi_finals, finals, final_grade, semester)
                          VALUES (:student_id, :subject_id, :teacher_id, :prelim_score, :midterm_score, :semifinal_score, :final_score, :final_grade, :semester_name)";

                $arr = array(
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                    'prelim_score' => $prelimScore,
                    'midterm_score' => $midtermScore,
                    'semifinal_score' => $semifinalScore,
                    'final_score' => $finalScore,
                    'final_grade' => $finalGrade,
                    'semester_name' => $semesterName
                );
            }

            userdata($query, $arr);

            $newconnection->closeConnection();

            // Redirect with subject_id in the URL
            header("Location: viewSubject.php?subject_id=$subjectId");
            die;
        }
    }

    return $errors;
}


function studentLogin($data) {
    $errors = array();

    if (count($errors) == 0) {
        $arr['studentEmail'] = $data['studentEmail'];
        $arr['studentPassword'] = $data['studentPassword'];

        $query = "SELECT * FROM students WHERE student_email = :studentEmail AND student_password = :studentPassword LIMIT 1";

        $row = userdata($query, $arr);

        if (is_array($row)) {
            $_SESSION['USER'] = $row[0];
            $_SESSION['LOGGED_IN'] = true;

            if ($_SESSION['USER']->usertype == 'Admin') {
                header("Location: admindashboard.php");
            } else {
                header("Location: studentdashboard.php");
            }
            die;
        } else {
            $errors[] = "Wrong email or password";
        }
    }

    return $errors;
}

function teacherLogin($data) {
    $errors = array();

    if (count($errors) == 0) {
        $arr['teacherEmail'] = $data['teacherEmail'];
        $arr['teacherPassword'] = $data['teacherPassword'];

        $query = "SELECT * FROM teachers WHERE teacher_email = :teacherEmail AND teacher_password = :teacherPassword LIMIT 1";

        $row = userdata($query, $arr);

        if (is_array($row)) {
            $_SESSION['USER'] = $row[0];
            $_SESSION['LOGGED_IN'] = true;

            if ($_SESSION['USER']->usertype == 'Admin') {
                header("Location: admindashboard.php");
            } else {
                header("Location: teacherdashboard.php");
            }
            die;
        } else {
            $errors[] = "Wrong email or password";
        }
    }

    return $errors;
}


function usercheck_login($redirect = true){
    if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

        return true;

    }
    if($redirect){
        header("Location: landingpage.php");
        die;
    }else{
        return false;
    }
}

function userdata($query,$vars = array()){
    $string = "mysql:host=localhost;dbname=crmcsystem";
    $con = new PDO($string,'root','');

    if(!$con){
        return false;
    }

    $stm = $con->prepare($query);
    $check = $stm->execute($vars);

    if($check){
        $data = $stm->fetchAll(PDO::FETCH_OBJ);
        if(count($data) > 0){
            return $data;
        }
    }
    return false;
}