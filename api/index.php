<?php

// Mengambil koneksi ke database
require "../config/conn.php";
include '../config/func.php';

// Get posted data
$data = json_decode(file_get_contents('php://input'), true);

// Handle request based on the endpoint
$endpoint = $_SERVER['REQUEST_URI'];
$dir = dirname($_SERVER["PHP_SELF"]);

$id = isset($_GET["id"]) ? $_GET["id"] : NULL;

switch ($endpoint) {
    case $dir.'/index.php?request=register':
        handleRegister($data);
        break;
    case $dir.'/index.php?request=login':
        handleLogin($data);
        break;
    case $dir.'/index.php?request=user&id='.$id:
        handleCheckUser($id);
        break;
    case $dir.'/index.php?request=allusers&id='.$id:
        handleListAllUsers($id);
        break;
    case $dir.'/index.php?request=createuser':
        handleCreateManageUsers($data);
        break;
    case $dir.'/index.php?request=deleteuser':
        handleDeleteManageUsers($data);
        break;
    case $dir.'/index.php?request=profile':
        handleUpdateProfile($data);
        break;
    case $dir.'/index.php?request=frequency':
        handleCheckFrequency();
        break;
    case $dir.'/index.php?request=bmi':
        handleCheckFormula($data);
        break;
    case $dir.'/index.php?request=bodypartworkout&id='.$id:
        handleListBodypart($id);
        break;
    case $dir.'/index.php?request=goals':
        handleListGoals();
        break;
    case $dir.'/index.php?request=formulaworkout&id='.$id:
        handleCheckDataFormulaWorkout($id);
        break;
    case $dir.'/index.php?request=trainer&id='.$id:
        handleCheckTrainer($id);
        break;
    case $dir.'/index.php?request=program':
        handleCreateProgram($data);
        break;
    case $dir.'/index.php?request=listprogram&id='.$id:
        handleCheckListProgram($id);
        break;
    case $dir.'/index.php?request=listprogramclient&id='.$id:
        handleCheckListProgramClient($id);
        break;
    case $dir.'/index.php?request=schedule':
        handleCheckSchedule($data);
        break;
    case $dir.'/index.php?request=schedule_activity':
        handleCheckScheduleActivity($data);
        break;
    case $dir.'/index.php?request=training':
        handleCheckWorkoutTraining($data);
        break;
    case $dir.'/index.php?request=guide':
        handleCheckWorkoutGuide($data);
        break;
    case $dir.'/index.php?request=getactivity&id='.$id:
        handleCheckResultTraining($id);
        break;
    case $dir.'/index.php?request=saveactivity':
        handleSaveWorkoutTraining($data);
        break;
    case $dir.'/index.php?request=deleteactivity':
        handleDeleteWorkoutTraining($data);
        break;
    case $dir.'/index.php?request=completesession':
        handleSessionWorkoutTraining($data);
        break;
    case $dir.'/index.php?request=resetsession':
        handleResetSessionWorkoutTraining($data);
        break;
    case $dir.'/index.php?request=listworkout&id='.$id:
        handleCheckListWorkout($id);
        break;
    case $dir.'/index.php?request=programclient':
        handleCheckProgramClient($data);
        break;
    case $dir.'/index.php?request=category&id='.$id:
        handleCheckCategory($id);
        break;
    case $dir.'/index.php?request=formula&id='.$id:
        handleCheckDataFormula($id);
        break;
    case $dir.'/index.php?request=level&id='.$id:
        handleCheckLevel($id);
        break;
    case $dir.'/index.php?request=workout&id='.$id:
        handleCheckWorkout($id);
        break;
    case $dir.'/index.php?request=formula':
        handleCreateFormulaProgram($data);
        break;
    case $dir.'/index.php?request=createformulaworkout':
        handleCreateFormulaWorkout($data);
        break;
    case $dir.'/index.php?request=createbmi':
        handleCreateManageBMI($data);
        break;
    case $dir.'/index.php?request=deletebmi':
        handleDeleteManageBMI($data);
        break;
    case $dir.'/index.php?request=deletefrequency':
        handleDeleteManageFrequency($data);
        break;
    case $dir.'/index.php?request=createfrequency':
        handleCreateManageFrequency($data);
        break;
    case $dir.'/index.php?request=bodypart&id='.$id:
        handleCheckBodypart($id);
        break;
    case $dir.'/index.php?request=exercise':
        handleCheckexercise($data);
        break;
    case $dir.'/index.php?request=trainingexercise':
        handleCreateTrainingExercise($data);
        break;
    case $dir.'/index.php?request=deleteformula':
        handleDeleteFormulaProgram($data);
        break;
    case $dir.'/index.php?request=deleteformulaworkout':
        handleDeleteFormulaWorkout($data);
        break;
    case $dir.'/index.php?request=schedule_program':
        handleCheckScheduleWorkout($data);
        break;
    case $dir.'/index.php?request=deleteworkout':
        handleDeleteWorkoutSession($data);
        break;
    default:
        http_response_code(404);
        echo json_encode(array('message' => 'Error: Endpoint not found'));
        break;
}

function handleRegister($data) {

    global $conn;

    if(isset($data)) {
        $role = isset($data["selectedOptionRole"]) ? htmlspecialchars($data["selectedOptionRole"]) : NULL;
        $username = isset($data["username"]) ? htmlspecialchars($data["username"]) : NULL;
        $email = isset($data["email"]) ? htmlspecialchars($data["email"]) : "";
        $pwd = isset($data["password"]) ? mysqli_real_escape_string($conn, $data["password"]) : NULL;
        $gender = isset($data["selectedOptionGender"]) ? htmlspecialchars($data["selectedOptionGender"]) : NULL;
    
        $sqlCheckUser = "SELECT username_user FROM tbl_users WHERE username_user = '$username'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
    
        if(mysqli_fetch_assoc($resultCheckUser)) {
            $response = array('message' => 'Username '.$username.' telah terdaftar');
            die(json_encode($response));
            return false;
        }
    
        $hash = password_hash($pwd, PASSWORD_BCRYPT);
        $sqlRegistUser = "INSERT INTO tbl_users (role_user, username_user, email_user, password_user, gender_user) VALUES ('$role', '$username', '$email', '$hash', '$gender')";
        
        if (mysqli_query($conn, $sqlRegistUser) === TRUE) {
            $response = array('message' => 'Success');
            echo json_encode($response);
        } else {
            $response = array('message' => 'Gagal menyimpan ke database');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleLogin($data) {
    
    global $conn;

    if(isset($data)) {
        $username = htmlspecialchars(mysqli_real_escape_string($conn, $data["username"]));
        $pwd = mysqli_real_escape_string($conn, $data["password"]);

        $sqlCheckUser = "SELECT id_user, role_user, username_user, password_user FROM tbl_users WHERE username_user = '$username'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);

        if(mysqli_num_rows($resultCheckUser) === 1 ) {
            $rowsUser = mysqli_fetch_assoc($resultCheckUser);

            if(password_verify($pwd, $rowsUser["password_user"])) {
                $response = array(
                    'message' => 'Success',
                    'id' => $rowsUser['id_user'],
                    'role' => $rowsUser['role_user'],
                    'username' => $rowsUser['username_user'], 
                );
                echo json_encode($response);
            }
            else {
                $response = array('message' => 'Password tidak sesuai');
                die(json_encode($response));
                return false;
            }
        }
        else {
            $response = array('message' => 'Username '.$username.' tidak terdaftar');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckUser($id) {

    global $conn;

    if(isset($id) || !empty($id)) {
        $sqlCheckUser = "SELECT * FROM tbl_users WHERE id_user = '$id'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
    
        if(mysqli_num_rows($resultCheckUser) > 0) {
            $rowsUser = mysqli_fetch_assoc($resultCheckUser);
            $response = array(
                'message' => 'Success',
                'role' => $rowsUser['role_user'],
                'username' => $rowsUser['username_user'], 
                'email' => $rowsUser['email_user'],
                'gender' => $rowsUser['gender_user'],
                'age' => $rowsUser['age_user'],
                'weight' => $rowsUser['weight_user'],
                'height' => $rowsUser['height_user'],
            );
            echo json_encode($response);
        }
        else {
            $response = array('message' => 'Data not found');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleListAllUsers($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListUsers = "SELECT id_user, role_user, username_user FROM tbl_users WHERE role_user != '$id' ORDER BY role_user ASC";
        $resultCheckListUsers = mysqli_query($conn, $sqlCheckListUsers);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListUsers) > 0) {
            while ($rowsListUsers = mysqli_fetch_assoc($resultCheckListUsers)) {
                $response = array(
                    'label' => $rowsListUsers['role_user'].' - '.$rowsListUsers['username_user'],
                    'value' => $rowsListUsers['id_user'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data users not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateManageUsers($data) {

    global $conn;

    if(isset($data)) {
        
        $role = htmlspecialchars($data['selectedOptionRole']);
        $gender = htmlspecialchars($data["selectedOptionGender"]);
        $user = htmlspecialchars($data["username"]);
        $pwd = isset($data["password"]) ? htmlspecialchars($data["password"]) : NULL;

        $sqlCheckUser = "SELECT username_user FROM tbl_users WHERE username_user = '$user'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
        if(mysqli_num_rows($resultCheckUser) > 0 ){
            $response = array('message' => 'Username '.$user.' sudah terdaftar');
            die(json_encode($response));
            return false;
        }
        else {

            $hash = password_hash($pwd, PASSWORD_BCRYPT);
            $sqlInsertUser = "INSERT INTO tbl_users (role_user, username_user, password_user, gender_user) VALUES ('$role', '$user', '$hash', '$gender')";
            
            if (mysqli_query($conn, $sqlInsertUser) === TRUE) {
                $sqlResultUsers = "SELECT id_user, role_user, username_user FROM tbl_users";
                $queryResultUsers = mysqli_query($conn, $sqlResultUsers);
                while ($rowsListUsers = mysqli_fetch_assoc($queryResultUsers)) {
                    $response = array(
                        'value' => $rowsListUsers['id_user'],
                        'label' => $rowsListUsers['role_user'].' - '.$rowsListUsers['username_user'],
                    );
                    $pushdata[] = $response;
                }
            } else {
                $response = array('message' => 'Failed insert to database');
                die(json_encode($response));
                return false;
            }
            echo json_encode($pushdata);
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleDeleteManageUsers($data) {

    global $conn;

    if(isset($data)) {
        
        $id = $data["idUser"];

        foreach ($id as $i) {
            $sqlCheckUserProgram = "SELECT id_user FROM tbl_program WHERE id_user = '$i'";
            $queryCheckUserProgram = mysqli_query($conn, $sqlCheckUserProgram);
            if (mysqli_num_rows($queryCheckUserProgram) > 0) {
                $response = array('message' => 'Data user sudah terdaftar di program workout');
                die(json_encode($response));
                return false;
            } 
        }
         
        $pushdata = array();

        foreach ($id as $i) {
            mysqli_query($conn, "DELETE FROM tbl_users WHERE id_user = '$i'");
        }

        $sqlResultUsers = "SELECT id_user, role_user, username_user FROM tbl_users";
        $queryResultUsers = mysqli_query($conn, $sqlResultUsers);
        while ($rowsListUsers = mysqli_fetch_assoc($queryResultUsers)) {
            $response = array(
                'label' => $rowsListUsers['role_user'].' - '.$rowsListUsers['username_user'],
                'value' => $rowsListUsers['id_user'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleUpdateProfile($data) {

    global $conn;

    if(isset($data)) {
        
        $id = htmlspecialchars($data['idUser']);
        $username = htmlspecialchars($data["username"]);
        $email = htmlspecialchars($data["email"]);
        
        // Check id
        $sqlCheckId = "SELECT username_user FROM tbl_users WHERE id_user = '$id'";
        $resultCheckId = mysqli_query($conn, $sqlCheckId);
        $dataCheckId = mysqli_fetch_assoc($resultCheckId);

        if ($username != $dataCheckId["username_user"]) {
            // Check user
            $sqlCheckUser = "SELECT username_user FROM tbl_users WHERE username_user = '$username'";
            $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
            if(mysqli_num_rows($resultCheckUser) === 1 ){
                $response = array('message' => 'Username '.$username.' telah terdaftar');
                die(json_encode($response));
                return false;
            }
            else {
                // Update data user
                $sqlUpdateUser = "UPDATE tbl_users SET username_user = '$username', email_user = '$email' WHERE id_user = '$id'";
        
                if (mysqli_query($conn, $sqlUpdateUser) === TRUE) {
                    $response = array('message' => 'Success');
                    echo json_encode($response);
                } else {
                    $response = array('message' => 'Failed update to database');
                    die(json_encode($response));
                    return false;
                }
            }
        }
        else {        
            // Update data user
            $sqlUpdateUser = "UPDATE tbl_users SET email_user = '$email' WHERE id_user = '$id'";
    
            if (mysqli_query($conn, $sqlUpdateUser) === TRUE) {
                $response = array('message' => 'Success');
                echo json_encode($response);
            } else {
                $response = array('message' => 'Failed update to database');
                die(json_encode($response));
                return false;
            }
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckFrequency() {

    global $conn;

    $sqlCheckFrequency = "SELECT code_frequency, level_frequency, desc_frequency FROM tbl_frequency";
    $resultCheckFrequency = mysqli_query($conn, $sqlCheckFrequency);

    $pushdata = array();

    if(mysqli_num_rows($resultCheckFrequency) > 0) {
        while($rowsFrequency = mysqli_fetch_assoc($resultCheckFrequency)){ 
            $response = array(
                'value' => $rowsFrequency['code_frequency'],
                'label' => $rowsFrequency['desc_frequency'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Data frequency not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckTrainer($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT id_user FROM tbl_users WHERE id_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }

        $sqlCheckTrainer = "SELECT id_user, role_user, username_user FROM tbl_users WHERE role_user = 'Trainer'";
        $resultCheckTrainer = mysqli_query($conn, $sqlCheckTrainer);

        $pushdata = array();

        if(mysqli_num_rows($resultCheckTrainer) > 0) {
            while($rowsFrequency = mysqli_fetch_assoc($resultCheckTrainer)){ 
                $response = array(
                    'id' => $rowsFrequency['id_user'],
                    'role' => $rowsFrequency['role_user'],
                    'label' => $rowsFrequency['username_user'],
                );
                $pushdata[] = $response;
            }
            echo json_encode($pushdata);
        }
        else {
            $response = array('message' => 'Data Trainer not found');
            die(json_encode($response));
            return false;
        }
    }
}

function handleCheckFormula($data) {
    global $conn;

    if (isset($data)) {
        $bmi = htmlspecialchars($data['category']);
        $frequency = htmlspecialchars($data["selectedOptionFrequency"]);

        // Check BMI
        $sqlCheckBMI = "SELECT * FROM tbl_bmi WHERE category_bmi = '$bmi'";
        $resultCheckBMI = mysqli_query($conn, $sqlCheckBMI);

        if (mysqli_num_rows($resultCheckBMI) === 0) {
            $response = array('message' => 'Data BMI not found');
            die(json_encode($response));
            return false;
        } else {
            $rowsCheckBMI = mysqli_fetch_assoc($resultCheckBMI);
            $codebmi = $rowsCheckBMI["code_bmi"];

            // Check Program
            $sqlCheckProgram = "SELECT A.code_formula, C.name_type_workout, C.desc_type_workout, D.level_frequency FROM tbl_formula AS A
            INNER JOIN tbl_formula_workout AS B ON A.code_formula = B.code_formula
            INNER JOIN tbl_type_workout AS C ON B.id_type_workout = C.id_type_workout
            INNER JOIN tbl_frequency AS D ON A.code_frequency = D.code_frequency
            WHERE A.code_bmi = '$codebmi' AND A.code_frequency = '$frequency'";
            $resultCheckProgram = mysqli_query($conn, $sqlCheckProgram);
            $resultCheckFormula = mysqli_fetch_assoc($resultCheckProgram);

            $programs = array();
            $codeFormula = '';
            $no = 1;
            while ($rowsCheckFormula = mysqli_fetch_assoc($resultCheckProgram)) {
                $programs[] = array(
                    'exercise' => $rowsCheckFormula["desc_type_workout"].", ",
                    'program' => $no++.". ".$rowsCheckFormula["name_type_workout"].", "
                );
                $codeFormula = $rowsCheckFormula["code_formula"];
            }

            if (count($programs) > 0) {
                $response = array(
                    'message' => 'Success',
                    'id' => $codeFormula,
                    'programs' => $programs, 
                    'category' => $codebmi, 
                    'level' => $resultCheckFormula["level_frequency"], 
                );

                echo json_encode($response);
            } else {
                $response = array('message' => 'Data formula not found');
                die(json_encode($response));
                return false;
            }
        }
    } else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleListBodypart($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = 'Trainer'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListBodypart = "SELECT id_bodypart, name_bodypart FROM tbl_bodypart";
        $resultCheckListBodypart = mysqli_query($conn, $sqlCheckListBodypart);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListBodypart) > 0) {
            while ($rowsListBodypart = mysqli_fetch_assoc($resultCheckListBodypart)) {
                $response = array(
                    'label' => $rowsListBodypart['name_bodypart'],
                    'value' => $rowsListBodypart['id_bodypart'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data body part not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleListGoals() {

    global $conn;

    $sqlCheckGoals = "SELECT * FROM tbl_goals";
    $resultCheckGoals = mysqli_query($conn, $sqlCheckGoals);

    $pushdata = array();

    if(mysqli_num_rows($resultCheckGoals) > 0) {
        while($rowsGoals = mysqli_fetch_assoc($resultCheckGoals)){ 
            $response = array(
                'value' => $rowsGoals['id_goals'],
                'label' => $rowsGoals['desc_goals'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Data goals workout not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateProgram($data) {

    global $conn;

    if(isset($data)) {
        
        $program = htmlspecialchars($data['program']);
        $bmi = htmlspecialchars($data['bmi']);
        $frequency = htmlspecialchars($data['frequency']);
        $goals = htmlspecialchars($data['goals']);
        $user = htmlspecialchars($data['user']);
        $trainer = htmlspecialchars($data["trainer"]);
        $date = htmlspecialchars($data["date"]);
        $age = htmlspecialchars($data["age"]);
        $weight = htmlspecialchars($data["weight"]);
        $height = htmlspecialchars($data["height"]);

        $startDate = htmlspecialchars($data["startDate"]);
        $endDate = htmlspecialchars($data["endDate"]);
        $startTimestamp = strtotime(str_replace('/', '-', $startDate));
        $endTimestamp = strtotime(str_replace('/', '-', $endDate));

        $autoid = autonum(6, "code_program", "tbl_program");

        $sqlTrainingPatern = "SELECT code_training_pattern FROM tbl_training_pattern WHERE code_formula = '$program' ORDER BY seq_training_pattern ASC";
        $resultTrainingPatern = mysqli_query($conn, $sqlTrainingPatern);

        $codeTP = array();

        if(mysqli_num_rows($resultTrainingPatern) > 0) {
            while($rowsTrainingPatern = mysqli_fetch_assoc($resultTrainingPatern)){
                $codeTP[] = $rowsTrainingPatern['code_training_pattern'];
            }
        }
        else {
            $response = array('message' => 'Rule program workout '.$program.' belum terdaftar');
            die(json_encode($response));
            return false;
        }

        $rangeDate = array();

        for ($i = $startTimestamp; $i <= $endTimestamp; $i += 86400) {
            $rangeDate[] = date('Y-m-d', $i);
        }

        $pattern = array("ON", "ON", "OFF", "ON", "ON", "ON", "OFF", "OFF");

        $codeTP_on_index = 0;
        $pattern_length = count($pattern);
        $codeTP_length = count($codeTP);
        $range_length = count($rangeDate);
        
        for ($i = 0; $i < $range_length; $i++) {
            $p = $pattern[$i % $pattern_length];
            if ($p === "ON") {
                $new_codeTP[] = $codeTP[$codeTP_on_index % $codeTP_length];
                $codeTP_on_index++;
            } else {
                $new_codeTP[] = "OFF";
            }
        }

        foreach ($rangeDate as $index => $d) {
            $result = $pattern[$index % $pattern_length];
            $code_training_pattern = $new_codeTP[$index];
            
            mysqli_query($conn, "INSERT INTO tbl_schedule (code_program, code_training_pattern, date_schedule, rest_schedule) VALUES ('$autoid', '$code_training_pattern', '$d', '$result')");
        }
            
        mysqli_query($conn, "INSERT INTO tbl_program (code_program, code_frequency, code_bmi, id_user, id_trainer, code_formula, date_program, age_program, weight_program, height_program, goals_program) VALUES ('$autoid', '$frequency', '$bmi', '$user', '$trainer', '$program', '$date', '$age', '$weight', '$height', '$goals')");

        $response = array('message' => 'Success');
        echo json_encode($response);

    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckListProgram($id) {

    global $conn;

    if(isset($id) || !empty($id)) {
        $sqlCheckListProgram = "SELECT A.id_program, A.code_program, A.date_program, A.code_formula, C.username_user AS data_user, D.username_user AS data_trainer FROM tbl_program AS A 
        INNER JOIN tbl_formula AS B ON A.code_formula = B.code_formula
        INNER JOIN tbl_users AS C ON A.id_user = C.id_user
        INNER JOIN tbl_users AS D ON A.id_trainer = D.id_user
        WHERE A.id_user = '$id'";
        
        $resultCheckListProgram = mysqli_query($conn, $sqlCheckListProgram);
    
        $jsonData = array();

        if (mysqli_num_rows($resultCheckListProgram) > 0) {
            while ($rowsListProgram = mysqli_fetch_assoc($resultCheckListProgram)) {
                $categoryName = 'Coach '.$rowsListProgram['data_trainer'];
                $idprog = $rowsListProgram['code_program'];
                $val = 'Program '.$rowsListProgram['code_formula'].' - '.$rowsListProgram['date_program'];

                $categoryExists = false;
                foreach ($jsonData as &$category) {
                    if ($category['category_name'] == $categoryName) {
                        $categoryExists = true;
                        $category['subcategory'][] = array('id' => $idprog, 'val' => $val);
                        break;
                    }
                }

                if (!$categoryExists) {
                    $jsonData[] = array(
                        'isExpanded' => false,
                        'category_name' => $categoryName,
                        'subcategory' => array(array('id' => $idprog, 'val' => $val))
                    );
                }
            }
        } else {
            $response = array('message' => 'Data program workout not found');
            die(json_encode($response));
            return false;
        }
        
        $jsonString = json_encode($jsonData);
        if ($jsonString === false) {
            die('Error encoding JSON data');
        }
        echo $jsonString;
    }

}

function handleCheckSchedule($data){

    global $conn;

    if(isset($data)) {
        $code = htmlspecialchars($data['scheduleWorkout']);
    
        $sqlCheckSchedule = "SELECT * FROM tbl_schedule WHERE code_program = '$code'";
        $resultCheckSchedule= mysqli_query($conn, $sqlCheckSchedule);
        
        $pushdata = array();

        if(mysqli_num_rows($resultCheckSchedule) > 0) {
            while($rowsCheckSchedule = mysqli_fetch_assoc($resultCheckSchedule)){ 
                $response = array(
                    'date' => $rowsCheckSchedule['date_schedule'],
                    'rest' => $rowsCheckSchedule['rest_schedule'],
                    'status' => $rowsCheckSchedule['status_schedule'],
                );
                $pushdata[] = $response;
            }
        }
        else {
            $response = array('message' => 'Jadwal workout '.$code.' tidak ditemukan');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckScheduleActivity($data){

    global $conn;

    if(isset($data)) {
        $code = htmlspecialchars($data['schedule']);
        $date = htmlspecialchars($data['date']);

        $sqlCheckSchedule = "SELECT id_schedule FROM tbl_schedule WHERE code_program = '$code' AND date_schedule = '$date'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckSchedule);

        if (!$resultCheckSchedule) {
            $response = array('message' => 'Error checking schedule');
            die(json_encode($response));
            return false;
        }

        if (mysqli_num_rows($resultCheckSchedule) > 0) {
            $rowsCheckSchedule = mysqli_fetch_assoc($resultCheckSchedule);
            $idSchedule = $rowsCheckSchedule["id_schedule"];

            $sqlCheckScheduleActivity = "SELECT A.id_schedule, B.id_exercise, B.id_training, C.name_workout, D.name_bodypart FROM tbl_schedule AS A
            INNER JOIN tbl_training AS B ON A.id_schedule = B.id_schedule
            INNER JOIN tbl_exercise AS C ON B.id_exercise = C.id_exercise
            INNER JOIN tbl_bodypart AS D ON C.id_bodypart = D.id_bodypart 
            WHERE A.id_schedule = '$idSchedule'";
            $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);

            if (!$resultCheckScheduleActivity) {
                $response = array('message' => 'Error checking schedule activity');
                die(json_encode($response));
                return false;
            }

            $jsonData = array();

            if (mysqli_num_rows($resultCheckScheduleActivity) > 0) {
                while ($rowsActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)) {

                    $categoryName = $rowsActivity['name_bodypart'];
                    $idtraining = $rowsActivity['id_training'];
                    $valtraining = $rowsActivity['name_workout'];

                    $categoryExists = false;
                    foreach ($jsonData as &$category) {
                        if ($category['category_name'] == $categoryName) {
                            $categoryExists = true;
                            $category['subcategory'][] = array('id' => $code, 'val' => $valtraining, 'train' => $idtraining);
                            break;
                        }
                    }
    
                    if (!$categoryExists) {
                        $jsonData[] = array(
                            'isExpanded' => false,
                            'category_name' => $categoryName,
                            'subcategory' => array(array('id' => $code, 'val' => $valtraining, 'train' => $idtraining))
                        );
                    }

                }
            } else {
                $response = array('message' => 'Data activity not found');
                die(json_encode($response));
                return false;
            }

            $jsonString = json_encode($jsonData);
            if ($jsonString === false) {
                die('Error encoding JSON data');
            }
            echo $jsonString;

        } else {
            $response = array('message' => 'Schedule not found');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckWorkoutTraining($data){

    global $conn;

    if(isset($data)) {
        $idUser = htmlspecialchars($data['idUser']);
        $idTraining = htmlspecialchars($data['trainingExercise']);
        
        $sqlCheckUser = "SELECT gender_user FROM tbl_users WHERE id_user = '$idUser'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
        $rowsCheckUser = mysqli_fetch_assoc($resultCheckUser);

        $sqlCheckWorkoutTraining = "SELECT A.id_schedule, A.id_training, C.name_workout, C.met_exercise, C.animation_exercise_man, C.animation_exercise_woman, D.weight_program FROM tbl_training AS A
        INNER JOIN tbl_schedule AS B ON A.id_schedule = B.id_schedule
        INNER JOIN tbl_exercise AS C ON A.id_exercise = C.id_exercise
        INNER JOIN tbl_program AS D ON B.code_program = D.code_program
        WHERE A.id_training = '$idTraining'";
    
        $resultCheckWorkoutTraining = mysqli_query($conn, $sqlCheckWorkoutTraining);
        
        $pushdata = array();
        
        $url = "https://" . $_SERVER["HTTP_HOST"] . "/src/assets/gif/";
        $gif = "animation.gif";

        if(mysqli_num_rows($resultCheckWorkoutTraining) > 0) {
            while($rowsCheckWorkoutTraining = mysqli_fetch_assoc($resultCheckWorkoutTraining)){ 
                
                $checkGender = $rowsCheckUser["gender_user"] === 'Man' ? $rowsCheckWorkoutTraining['animation_exercise_man'] : $rowsCheckWorkoutTraining['animation_exercise_woman'];
                $response = array(
                    'idtraining' => $rowsCheckWorkoutTraining['id_training'],
                    'name' => $rowsCheckWorkoutTraining['name_workout'],
                    'met' => $rowsCheckWorkoutTraining['met_exercise'],
                    'weight' => $rowsCheckWorkoutTraining['weight_program'],
                    'animation' => $checkGender === null ? $url.$gif : (!file_exists("../src/assets/gif/".strtolower($rowsCheckUser["gender_user"]).'/'.$checkGender) ? $url.$gif : $url.strtolower($rowsCheckUser["gender_user"]).'/'.$checkGender),
                    'status' => $checkGender,
                );
                $pushdata[] = $response;
            }
        }
        else {
            $response = array('message' => 'Panduan latihan workout tidak ditemukan');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckWorkoutGuide($data){

    global $conn;

    if(isset($data)) {
        $idUser = htmlspecialchars($data['idUser']);
        $idExercise = htmlspecialchars($data['idExercise']);
        
        $sqlCheckUser = "SELECT gender_user FROM tbl_users WHERE id_user = '$idUser'";
        $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
        $rowsCheckUser = mysqli_fetch_assoc($resultCheckUser);

        $sqlCheckWorkoutTraining = "SELECT A.animation_exercise_man, A.animation_exercise_woman, A.name_workout, B.name_bodypart FROM tbl_exercise AS A
        INNER JOIN tbl_bodypart AS B ON A.id_bodypart = B.id_bodypart
        WHERE A.id_exercise = '$idExercise'";
    
        $resultCheckWorkoutTraining = mysqli_query($conn, $sqlCheckWorkoutTraining);
        
        $pushdata = array();
        
        $url = "https://" . $_SERVER["HTTP_HOST"] . "/src/assets/gif/";
        $gif = "animation.gif";

        if(mysqli_num_rows($resultCheckWorkoutTraining) === 1) {
            $rowsCheckWorkoutTraining = mysqli_fetch_assoc($resultCheckWorkoutTraining);

            $checkGender = $rowsCheckUser["gender_user"] === 'Man' ? $rowsCheckWorkoutTraining['animation_exercise_man'] : $rowsCheckWorkoutTraining['animation_exercise_woman'];
            
            $response = array(
                'body' => $rowsCheckWorkoutTraining['name_bodypart'],
                'name' => $rowsCheckWorkoutTraining['name_workout'],
                'animation' => $checkGender === null ? $url.$gif : (!file_exists("../src/assets/gif/".strtolower($rowsCheckUser["gender_user"]).'/'.$checkGender) ? $url.$gif : $url.strtolower($rowsCheckUser["gender_user"]).'/'.$checkGender),
                'status' => $checkGender,
            );
            $pushdata[] = $response;
        }
        else {
            $response = array('message' => 'Workout guide not available');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckProgramClient($data){

    global $conn;

    if(isset($data)) {
        $id = htmlspecialchars($data['programclient']);
        
        $sqlCheckProgram = "SELECT A.age_program, A.code_formula, A.goals_program, B.username_user, C.category_bmi, D.level_frequency, E.id_type_workout FROM tbl_program AS A
        INNER JOIN tbl_users AS B ON A.id_user = B.id_user
        INNER JOIN tbl_bmi AS C ON A.code_bmi = C.code_bmi
        INNER JOIN tbl_frequency AS D ON A.code_frequency = D.code_frequency
        INNER JOIN tbl_formula_workout AS E ON A.code_formula = E.code_formula
        WHERE A.code_program = '$id'";
        $resultCheckProgram = mysqli_query($conn, $sqlCheckProgram);
        $rowsResultProgram = mysqli_fetch_assoc($resultCheckProgram);

        $typeWorkoutId = array();

        if(mysqli_num_rows($resultCheckProgram) > 0) {

            while($rowsCheckProgram = mysqli_fetch_assoc($resultCheckProgram)){ 
                $typeWorkoutId[] = $rowsCheckProgram["id_type_workout"];
            }

            $typeWorkoutDesc = array();

            foreach ($typeWorkoutId as $i) {
                $sqlCheckTypeWorkout = "SELECT desc_type_workout FROM tbl_type_workout WHERE id_type_workout = '$i'";
                $resultCheckTypeWorkout = mysqli_query($conn, $sqlCheckTypeWorkout);
                $rowsCheckTypeWorkout = mysqli_fetch_assoc($resultCheckTypeWorkout);
                
                $typeWorkoutDesc[] = $rowsCheckTypeWorkout["desc_type_workout"];
            }

            $strTypeWorkoutDesc = implode(", ", $typeWorkoutDesc);

            $response = array(
                'client' => $rowsResultProgram['username_user'],
                'age' => $rowsResultProgram['age_program'],
                'goals' => $rowsResultProgram['goals_program'],
                'category' => $rowsResultProgram['category_bmi'],
                'level' => $rowsResultProgram['level_frequency'],
                'program' => $rowsResultProgram['code_formula'],
                'workout' => $strTypeWorkoutDesc,
            );
            $pushdata[] = $response;
        }
        else {
            $response = array('message' => 'Workout program '.$id.' not available');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleSaveWorkoutTraining($data){
    global $conn;

    if(isset($data)) {
        $id = htmlspecialchars($data['idTraining']);
        $time = htmlspecialchars($data['timeInterval']);
        $calory = htmlspecialchars($data['caloriesBurned']);
        
        $sqlInsertSetTraining = "INSERT INTO tbl_set_training (id_training, calory_set_training, time_set_training) VALUES ('$id', '$calory', '$time')";

        if (!mysqli_query($conn, $sqlInsertSetTraining)) {
            $response = array('message' => 'Failed to insert data into database server');
            die(json_encode($response));
            return false;
        }

        $sqlCheckWorkoutTraining = "SELECT * FROM tbl_set_training WHERE id_training = '$id'";
        $resultCheckWorkoutTraining = mysqli_query($conn, $sqlCheckWorkoutTraining);

        if (!$resultCheckWorkoutTraining) {
            $response = array('message' => 'Failed to execute query');
            die(json_encode($response));
            return false;
        }
        
        $pushdata = array();

        $no = 1;

        if(mysqli_num_rows($resultCheckWorkoutTraining) > 0) {
            while($rowsCheckWorkoutTraining = mysqli_fetch_assoc($resultCheckWorkoutTraining)){ 
                $response = array(
                    'training' => $rowsCheckWorkoutTraining['id_training'],
                    'id' => $rowsCheckWorkoutTraining['id_set_training'],
                    'set' => $no++,
                    'calory' => $rowsCheckWorkoutTraining['calory_set_training'],
                    'time' => $rowsCheckWorkoutTraining['time_set_training'],
                );
                $pushdata[] = $response;
            }
        }
        else {
            $response = array('message' => 'Sesi latihan yang telah diselesaikan tidak ditemukan');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleDeleteWorkoutTraining($data){
    global $conn;

    if(isset($data)) {
        $id = htmlspecialchars($data['idTraining']);
        $set = htmlspecialchars($data['setTraining']);
        
        $sqlDeleteSetTraining = "DELETE FROM tbl_set_training WHERE id_set_training = '$set'";

        if (!mysqli_query($conn, $sqlDeleteSetTraining)) {
            $response = array('message' => 'Failed to delete data into database server');
            die(json_encode($response));
            return false;
        }

        $sqlCheckWorkoutTraining = "SELECT * FROM tbl_set_training WHERE id_training = '$id'";
        $resultCheckWorkoutTraining = mysqli_query($conn, $sqlCheckWorkoutTraining);

        if (!$resultCheckWorkoutTraining) {
            $response = array('message' => 'Failed to execute query');
            die(json_encode($response));
            return false;
        }
        
        $pushdata = array();

        $no = 1;

        if(mysqli_num_rows($resultCheckWorkoutTraining) > 0) {
            while($rowsCheckWorkoutTraining = mysqli_fetch_assoc($resultCheckWorkoutTraining)){ 
                $response = array(
                    'training' => $rowsCheckWorkoutTraining['id_training'],
                    'id' => $rowsCheckWorkoutTraining['id_set_training'],
                    'set' => $no++,
                    'calory' => $rowsCheckWorkoutTraining['calory_set_training'],
                    'time' => $rowsCheckWorkoutTraining['time_set_training'],
                );
                $pushdata[] = $response;
            }
        }
        else {
            $response = array('message' => 'Sesi latihan yang telah diselesaikan tidak ditemukan');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckResultTraining($id){
    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckWorkoutTraining = "SELECT * FROM tbl_set_training WHERE id_training = '$id'";
        $resultCheckWorkoutTraining = mysqli_query($conn, $sqlCheckWorkoutTraining);

        if (!$resultCheckWorkoutTraining) {
            $response = array('message' => 'Failed to execute query');
            die(json_encode($response));
            return false;
        }
        
        $pushdata = array();

        $no = 1;

        if(mysqli_num_rows($resultCheckWorkoutTraining) > 0) {
            while($rowsCheckWorkoutTraining = mysqli_fetch_assoc($resultCheckWorkoutTraining)){ 
                $response = array(
                    'training' => $rowsCheckWorkoutTraining['id_training'],
                    'id' => $rowsCheckWorkoutTraining['id_set_training'],
                    'set' => $no++,
                    'calory' => $rowsCheckWorkoutTraining['calory_set_training'],
                    'time' => $rowsCheckWorkoutTraining['time_set_training'],
                );
                $pushdata[] = $response;
            }
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleSessionWorkoutTraining($data) {

    global $conn;

    if(isset($data)) {
        
        $id = htmlspecialchars($data['programid']);
        $date = $data["programdate"];
        
        if (is_array($date)) {
            $response = array('message' => 'Request failed');
            die(json_encode($response));
            return false;
        }
    
        $sqlCheckSchedule = "SELECT id_schedule FROM tbl_schedule WHERE code_program = '$id' AND date_schedule = '$date'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckSchedule);
        if(mysqli_num_rows($resultCheckSchedule) === 1 ){
            $rowsCheckSchedule = mysqli_fetch_assoc($resultCheckSchedule);
            $idSchedule = $rowsCheckSchedule["id_schedule"];

            $sqlCheckScheduleActivity = "SELECT A.id_schedule, A.id_training, B.id_set_training, B.calory_set_training, B.time_set_training FROM tbl_training AS A
            LEFT JOIN tbl_set_training AS B ON A.id_training = B.id_training
            WHERE A.id_schedule = '$idSchedule'";
            $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);
            if (mysqli_num_rows($resultCheckScheduleActivity) > 0) {

                mysqli_query($conn, "UPDATE tbl_schedule SET status_schedule = '1' WHERE id_schedule = '$idSchedule'");
      
                $data = array();

                while($rowsCheckScheduleActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)){
                    $idTraining = $rowsCheckScheduleActivity["id_training"];
                    $idcalory = $rowsCheckScheduleActivity["calory_set_training"];
                    $idtime = $rowsCheckScheduleActivity["time_set_training"];

                    $response = array(
                        'id' => $idTraining,
                        'calory' => $idcalory,
                        'time' => $idtime,
                    );
                    $data[] = $response;

                }
                
                $result = array();
                foreach ($data as $item) {
                    if (!isset($result[$item['id']])) {
                        $result[$item['id']] = array(
                            'id' => $item['id'],
                            'calory' => (float) $item['calory'],
                            'time' => $item['time']
                        );
                    } else {
                        list($hours, $minutes) = explode(':', $result[$item['id']]['time']);
                        $time_minutes = $hours * 60 + $minutes;
                        list($hours, $minutes) = explode(':', $item['time']);
                        $time_minutes += $hours * 60 + $minutes;
                        $result[$item['id']]['time'] = sprintf('%02d:%02d', floor($time_minutes / 60), $time_minutes % 60);

                        $result[$item['id']]['calory'] += (float) $item['calory'];
                    }
                }

                foreach ($result as $item) {
                    $idTrn = $item['id'];
                    $clr = $item['calory'];
                    $tme = $item['time'];

                    mysqli_query($conn, "UPDATE tbl_training SET calory_exercise = '$clr', time_exercise = '$tme' WHERE id_training = '$idTrn'");
                }
                
                $response = array(
                    'scheduleWorkout' => $id,
                );

                handleCheckSchedule($response);
            }
            else {
                $response = array('message' => 'Data sesi workout not found');
                die(json_encode($response));
                return false;
            }
        }
        else {
            $response = array('message' => 'Program workout not found');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleResetSessionWorkoutTraining($data) {

    global $conn;

    if(isset($data)) {
        
        $id = htmlspecialchars($data['programid']);
        $date = $data["programdate"];
        
        if (is_array($date)) {
            $response = array('message' => 'Request failed, training sessions have not been created');
            die(json_encode($response));
            return false;
        }
    
        $sqlCheckSchedule = "SELECT id_schedule FROM tbl_schedule WHERE code_program = '$id' AND date_schedule = '$date'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckSchedule);

        if(mysqli_num_rows($resultCheckSchedule) === 1 ){
            $rowsCheckSchedule = mysqli_fetch_assoc($resultCheckSchedule);
            $idSchedule = $rowsCheckSchedule["id_schedule"];

            $sqlCheckScheduleActivity = "SELECT id_training FROM tbl_training WHERE id_schedule = '$idSchedule'";
            $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);
            if (mysqli_num_rows($resultCheckScheduleActivity) > 0) {
                
                mysqli_query($conn, "UPDATE tbl_schedule SET status_schedule = '0' WHERE id_schedule = '$idSchedule'");

                while($rowsCheckScheduleActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)){
                    $idTraining = $rowsCheckScheduleActivity["id_training"];

                    mysqli_query($conn, "UPDATE tbl_training SET calory_exercise = NULL, time_exercise = NULL WHERE id_training = '$idTraining'");
                    mysqli_query($conn, "DELETE FROM tbl_set_training WHERE id_training = '$idTraining'");

                }    
                $response = array(
                    'scheduleWorkout' => $id,
                );
    
                handleCheckSchedule($response);
            }
            else {
                $response = array('message' => 'Data sesi workout not found');
                die(json_encode($response));
                return false;
            }
        }
        else {
            $response = array('message' => 'Training sessions have not been created');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckListWorkout($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT id_user FROM tbl_users WHERE id_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListWorkout = "SELECT A.name_bodypart, B.* FROM tbl_bodypart AS A 
        INNER JOIN tbl_exercise AS B ON A.id_bodypart = B.id_bodypart";
        
        $resultCheckListWorkout = mysqli_query($conn, $sqlCheckListWorkout);
    
        $jsonData = array();

        if (mysqli_num_rows($resultCheckListWorkout) > 0) {
            while ($rowsListWorkout = mysqli_fetch_assoc($resultCheckListWorkout)) {
                $categoryName = $rowsListWorkout['name_bodypart'];
                $idex = $rowsListWorkout['id_exercise'];
                $val = $rowsListWorkout['name_workout'];

                $categoryExists = false;
                foreach ($jsonData as &$category) {
                    if ($category['category_name'] == $categoryName) {
                        $categoryExists = true;
                        $category['subcategory'][] = array('id' => $idex, 'val' => $val);
                        break;
                    }
                }

                if (!$categoryExists) {
                    $jsonData[] = array(
                        'isExpanded' => false,
                        'category_name' => $categoryName,
                        'subcategory' => array(array('id' => $idex, 'val' => $val))
                    );
                }
            }
        } else {
            $response = array('message' => 'Data workout guide not found');
            die(json_encode($response));
            return false;
        }
        
        $jsonString = json_encode($jsonData);
        if ($jsonString === false) {
            die('Error encoding JSON data');
        }
        echo $jsonString;
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckCategory($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListCategory = "SELECT code_bmi, category_bmi FROM tbl_bmi";
        $resultCheckListCategory = mysqli_query($conn, $sqlCheckListCategory);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListCategory) > 0) {
            while ($rowsListCategory = mysqli_fetch_assoc($resultCheckListCategory)) {
                $response = array(
                    'label' => $rowsListCategory['code_bmi'].' - '.$rowsListCategory['category_bmi'],
                    'value' => $rowsListCategory['code_bmi'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data category body not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckLevel($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListLevel = "SELECT code_frequency, level_frequency FROM tbl_frequency";
        $resultCheckListLevel = mysqli_query($conn, $sqlCheckListLevel);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListLevel) > 0) {
            while ($rowsListLevel = mysqli_fetch_assoc($resultCheckListLevel)) {
                $response = array(
                    'label' => $rowsListLevel['code_frequency'].' - '.$rowsListLevel['level_frequency'],
                    'value' => $rowsListLevel['code_frequency'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data level frequency not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckWorkout($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListWorkout = "SELECT id_type_workout, name_type_workout FROM tbl_type_workout";
        $resultCheckListWorkout = mysqli_query($conn, $sqlCheckListWorkout);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListWorkout) > 0) {
            while ($rowsListWorkout = mysqli_fetch_assoc($resultCheckListWorkout)) {
                $response = array(
                    'label' => $rowsListWorkout['name_type_workout'],
                    'value' => $rowsListWorkout['id_type_workout'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data type workout not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateFormulaProgram($data) {

    global $conn;

    if(isset($data)) {
        
        $category = htmlspecialchars($data['category']);
        $level = htmlspecialchars($data["level"]);
        $workout = $data["workout"];

        $sqlCheckFormula = "SELECT code_formula FROM tbl_formula WHERE code_bmi = '$category' AND code_frequency = '$level'";
        $resultCheckFormula = mysqli_query($conn, $sqlCheckFormula);
        if(mysqli_num_rows($resultCheckFormula) > 0 ){
            $rowsListFormula = mysqli_fetch_assoc($resultCheckFormula);
            $response = array('message' => 'Program workout '.$rowsListFormula["code_formula"].' sudah terdaftar');
            die(json_encode($response));
            return false;
        }
        else {

            $autoid = autonum(2, "code_formula", "tbl_formula");
            $newid = "P".$autoid;
            $pushdata = array();

            $sqlInsertFormula = "INSERT INTO tbl_formula (code_formula, code_bmi, code_frequency) VALUES ('$newid', '$category', '$level')";
            
            foreach ($workout as $i) {
                mysqli_query($conn, "INSERT INTO tbl_formula_workout (code_formula, id_type_workout) VALUES ('$newid', '$i')");
            }

            if (mysqli_query($conn, $sqlInsertFormula) === TRUE) {
                $sqlResulFormula = "SELECT code_formula FROM tbl_formula";
                $queryResultFormula = mysqli_query($conn, $sqlResulFormula);
                while ($rowsListFormula = mysqli_fetch_assoc($queryResultFormula)) {
                    $response = array(
                        'label' => 'Program Workout '.$rowsListFormula['code_formula'],
                        'value' => $rowsListFormula['code_formula'],
                    );
                    $pushdata[] = $response;
                }

            } else {
                $response = array('message' => 'Failed insert to database');
                die(json_encode($response));
                return false;
            }
            echo json_encode($pushdata);
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateFormulaWorkout($data) {

    global $conn;

    if(isset($data)) {
        
        $seq = htmlspecialchars($data['sequence']);
        $program = htmlspecialchars($data["program"]);
        $body = $data["body"];

        $sqlCheckFormulaWorkout = "SELECT code_formula FROM tbl_training_pattern WHERE code_formula = '$program' AND seq_training_pattern = '$seq'";
        $resultCheckFormulaWorkout = mysqli_query($conn, $sqlCheckFormulaWorkout);
        if(mysqli_num_rows($resultCheckFormulaWorkout) > 0 ){
            $response = array('message' => 'Program workout '.$program.' sequence '.$seq.' sudah terdaftar');
            die(json_encode($response));
            return false;
        }
        else {

            $autoid = autonum(2, "code_training_pattern", "tbl_detail_pattern");
            $newid = "W".$autoid;

            $descBodypart = array();

            foreach ($body as $i) {
                $sqlCheckBodypart = "SELECT name_bodypart FROM tbl_bodypart WHERE id_bodypart = '$i'";
                $resultCheckBodypart = mysqli_query($conn, $sqlCheckBodypart);
                $rowsListBodypart = mysqli_fetch_assoc($resultCheckBodypart);
                
                mysqli_query($conn, "INSERT INTO tbl_detail_pattern (code_training_pattern, id_bodypart) VALUES ('$newid', '$i')");
                
                $descBodypart[] = $rowsListBodypart["name_bodypart"];
            }

            $strDescBodyPart = implode(", ", $descBodypart);

            $sqlInsertFormulaWorkout = "INSERT INTO tbl_training_pattern (code_formula, code_training_pattern, seq_training_pattern, body_training_pattern) VALUES ('$program', '$newid', '$seq', '$strDescBodyPart')";

            $pushdata = array();

            $no = 1;
            if (mysqli_query($conn, $sqlInsertFormulaWorkout) === TRUE) {
                $sqlResultFormulaWorkout = "SELECT * FROM tbl_training_pattern ORDER BY code_formula ASC, seq_training_pattern ASC";
                $queryResultFormulaWorkout = mysqli_query($conn, $sqlResultFormulaWorkout);
                while ($rowsListFormulaWorkout = mysqli_fetch_assoc($queryResultFormulaWorkout)) {
                    $response = array(
                        'label' => 'R'.$no++.'. '.$rowsListFormulaWorkout['code_formula'].'. '.$rowsListFormulaWorkout['seq_training_pattern'].': '.$rowsListFormulaWorkout['body_training_pattern'],
                        'value' => $rowsListFormulaWorkout['code_training_pattern'],
                    );
                    $pushdata[] = $response;
                }

            } else {
                $response = array('message' => 'Failed insert to database');
                die(json_encode($response));
                return false;
            }
            echo json_encode($pushdata);
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateManageBMI($data) {

    global $conn;

    if(isset($data)) {
        
        $awal = htmlspecialchars($data['nilaiAwal']);
        $akhir = htmlspecialchars($data["nilaiAkhir"]);
        $category = htmlspecialchars($data["categoryBMI"]);

        $sqlCheckBMI = "SELECT category_bmi FROM tbl_bmi WHERE category_bmi = '$category'";
        $resultCheckBMI = mysqli_query($conn, $sqlCheckBMI);
        if(mysqli_num_rows($resultCheckBMI) > 0 ){
            $response = array('message' => 'Category '.$category.' sudah terdaftar');
            die(json_encode($response));
            return false;
        }
        else {

            $autoid = autonum(2, "code_bmi", "tbl_bmi");
            $newid = "C".$autoid;
            $pushdata = array();

            $sqlInsertBMI = "INSERT INTO tbl_bmi (code_bmi, category_bmi, nilai_awal_bmi, nilai_akhir_bmi) VALUES ('$newid', '$category', '$awal', '$akhir')";
            
            if (mysqli_query($conn, $sqlInsertBMI) === TRUE) {
                $sqlResultBMI = "SELECT id_bmi, code_bmi, category_bmi FROM tbl_bmi";
                $queryResultBMI = mysqli_query($conn, $sqlResultBMI);
                while ($rowsListBMI = mysqli_fetch_assoc($queryResultBMI)) {
                    $response = array(
                        'value' => $rowsListBMI['code_bmi'],
                        'label' => $rowsListBMI['code_bmi'].' - '.$rowsListBMI['category_bmi'],
                    );
                    $pushdata[] = $response;
                }
            } else {
                $response = array('message' => 'Failed insert to database');
                die(json_encode($response));
                return false;
            }
            echo json_encode($pushdata);
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateManageFrequency($data) {

    global $conn;

    if(isset($data)) {
        
        $level = htmlspecialchars($data["levelWorkout"]);
        $desc = htmlspecialchars($data["descWorkout"]);

        $sqlCheckFrequency = "SELECT level_frequency FROM tbl_frequency WHERE level_frequency = '$level'";
        $resultCheckFrequency = mysqli_query($conn, $sqlCheckFrequency);
        if(mysqli_num_rows($resultCheckFrequency) > 0 ){
            $rowsListFrequency = mysqli_fetch_assoc($resultCheckFrequency);
            $response = array('message' => 'Level '.$rowsListFrequency["level_frequency"].' sudah terdaftar');
            die(json_encode($response));
            return false;
        }
        else {

            $autoid = autonum(2, "code_frequency", "tbl_frequency");
            $newid = "L".$autoid;
            $pushdata = array();

            $sqlInsertFrequency = "INSERT INTO tbl_frequency (code_frequency, level_frequency, desc_frequency) VALUES ('$newid', '$level', '$desc')";
            
            if (mysqli_query($conn, $sqlInsertFrequency) === TRUE) {
                $sqlResultFrequency = "SELECT id_frequency, code_frequency, level_frequency FROM tbl_frequency";
                $queryResultFrequency = mysqli_query($conn, $sqlResultFrequency);
                while ($rowsListFrequency = mysqli_fetch_assoc($queryResultFrequency)) {
                    $response = array(
                        'value' => $rowsListFrequency['code_frequency'],
                        'label' => $rowsListFrequency['code_frequency'].' - '.$rowsListFrequency['level_frequency'],
                    );
                    $pushdata[] = $response;
                }
            } else {
                $response = array('message' => 'Failed insert to database');
                die(json_encode($response));
                return false;
            }
            echo json_encode($pushdata);
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckListProgramClient($id) {

    global $conn;

    if(isset($id) || !empty($id)) {
        $sqlCheckListProgram = "SELECT A.id_program, A.code_program, A.date_program, A.code_formula, C.username_user AS data_user, D.username_user AS data_trainer FROM tbl_program AS A 
        INNER JOIN tbl_formula AS B ON A.code_formula = B.code_formula
        INNER JOIN tbl_users AS C ON A.id_user = C.id_user
        INNER JOIN tbl_users AS D ON A.id_trainer = D.id_user
        WHERE A.id_trainer = '$id'";
        
        $resultCheckListProgram = mysqli_query($conn, $sqlCheckListProgram);
    
        $jsonData = array();

        if (mysqli_num_rows($resultCheckListProgram) > 0) {
            while ($rowsListProgram = mysqli_fetch_assoc($resultCheckListProgram)) {
                $categoryName = $rowsListProgram['data_user'];
                $idcode = $rowsListProgram['code_program'];
                $val = 'Program '.$rowsListProgram['code_formula'].' - '.$rowsListProgram['date_program'];
                $categoryExists = false;
                foreach ($jsonData as &$category) {
                    if ($category['category_name'] == $categoryName) {
                        $categoryExists = true;
                        $category['subcategory'][] = array('id' => $idcode, 'val' => $val);
                        break;
                    }
                }
                if (!$categoryExists) {
                    $jsonData[] = array(
                        'isExpanded' => false,
                        'category_name' => $categoryName,
                        'subcategory' => array(array('id' => $idcode, 'val' => $val))
                    );
                }
            }
        } else {
            $response = array('message' => 'Data program workout not found');
            die(json_encode($response));
            return false;
        }
        
        $jsonString = json_encode($jsonData);
        if ($jsonString === false) {
            die('Error encoding JSON data');
        }
        echo $jsonString;
    }

}

function handleCheckBodypart($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckProgram = "SELECT code_program FROM tbl_program WHERE code_program = '$id'";
        $resultCheckProgram = mysqli_query($conn, $sqlCheckProgram);

        if (!$resultCheckProgram) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListBodypart = "SELECT * FROM tbl_bodypart";
        $resultCheckListBodypart = mysqli_query($conn, $sqlCheckListBodypart);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListBodypart) > 0) {
            while ($rowsListBodypart = mysqli_fetch_assoc($resultCheckListBodypart)) {
                $response = array(
                    'label' => $rowsListBodypart['name_bodypart'],
                    'value' => $rowsListBodypart['id_bodypart'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data bodypart not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckExercise($data) {

    global $conn;

    if(isset($data)) {
        
        $id = htmlspecialchars($data["bodypartid"]);
         
        $sqlCheckListExercise = "SELECT * FROM tbl_exercise WHERE id_bodypart = '$id'";
        $resultCheckListExercise = mysqli_query($conn, $sqlCheckListExercise);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListExercise) > 0) {
            while ($rowsListExercise = mysqli_fetch_assoc($resultCheckListExercise)) {
                $response = array(
                    'id' => $rowsListExercise['id_exercise'],
                    'value' => $rowsListExercise['name_workout'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data exercise not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCreateTrainingExercise($data) {

    global $conn;

    if(isset($data)) {
        
        $program = htmlspecialchars($data['programId']);
        $date = htmlspecialchars($data['dateId']);
        $body = htmlspecialchars($data["bodypartId"]);
        $exercise = $data["exerciseId"];

        $sqlCheckcSchedule = "SELECT id_schedule FROM tbl_schedule WHERE code_program = '$program' AND date_schedule = '$date'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckcSchedule);
        if(mysqli_num_rows($resultCheckSchedule) > 0 ){
            $rowsSchedule = mysqli_fetch_assoc($resultCheckSchedule);
            $idSchedule = $rowsSchedule["id_schedule"];
            
            for($countcek = 0; $countcek < count($exercise); $countcek++) {
                $idExeCek = $exercise[$countcek];
                
                $sqlCheckTraining = "SELECT id_training FROM tbl_training WHERE id_schedule = '$idSchedule' AND id_exercise = '$idExeCek'";
                $resultCheckTraining = mysqli_query($conn, $sqlCheckTraining);

                if(mysqli_num_rows($resultCheckTraining) > 0 ) {
                    $response = array('message' => 'Data exercise sudah terdaftar dalam sesi latihan');
                    die(json_encode($response));
                    return false;
                }
            }

            foreach ($exercise as $r) {
                mysqli_query($conn, "INSERT INTO tbl_training (id_schedule, id_exercise) VALUES ('$idSchedule', '$r')");
            }

            $sqlCheckScheduleActivity = "SELECT A.id_schedule, B.id_exercise, B.id_training, C.name_workout, D.name_bodypart FROM tbl_schedule AS A
            INNER JOIN tbl_training AS B ON A.id_schedule = B.id_schedule
            INNER JOIN tbl_exercise AS C ON B.id_exercise = C.id_exercise
            INNER JOIN tbl_bodypart AS D ON C.id_bodypart = D.id_bodypart 
            WHERE A.code_program = '$program' AND A.date_schedule = '$date'";
            $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);
    
            if(mysqli_num_rows($resultCheckScheduleActivity) > 0) {
                while($rowsCheckScheduleActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)){ 
                    $response = array(
                        'id' => $rowsCheckScheduleActivity['id_training'],
                        'label' => $rowsCheckScheduleActivity['name_bodypart'],
                        'value' => $rowsCheckScheduleActivity['name_workout'],
                    );
                    $pushdata[] = $response;
                }
            }

            echo json_encode($pushdata);
        }
        else {
            $response = array('message' => 'Program workout '.$program.' tanggal '.$date.' tidak terdaftar');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleDeleteManageBMI($data) {

    global $conn;

    if(isset($data)) {
        
        $id = $data["idBMI"];

        foreach ($id as $i) {
            $sqlCheckBMI = "SELECT code_bmi FROM tbl_formula WHERE code_bmi = '$i'";
            $queryCheckBMI = mysqli_query($conn, $sqlCheckBMI);
            if (mysqli_num_rows($queryCheckBMI) > 0) {
                $response = array('message' => 'Data BMI sudah terdaftar di formula program');
                die(json_encode($response));
                return false;
            } 
        }
         
        $pushdata = array();

        foreach ($id as $i) {
            mysqli_query($conn, "DELETE FROM tbl_bmi WHERE code_bmi = '$i'");
        }

        $sqlResultBMI = "SELECT id_bmi, code_bmi, category_bmi FROM tbl_bmi";
        $queryResultBMI = mysqli_query($conn, $sqlResultBMI);
        while ($rowsListBMI = mysqli_fetch_assoc($queryResultBMI)) {
            $response = array(
                'label' => $rowsListBMI['code_bmi'].' - '.$rowsListBMI['category_bmi'],
                'value' => $rowsListBMI['code_bmi'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleDeleteManageFrequency($data) {

    global $conn;

    if(isset($data)) {
        
        $id = $data["idFrequency"];

        foreach ($id as $i) {
            $sqlCheckFrequency = "SELECT code_frequency FROM tbl_formula WHERE code_frequency = '$i'";
            $queryCheckFrequency = mysqli_query($conn, $sqlCheckFrequency);
            if (mysqli_num_rows($queryCheckFrequency) > 0) {
                $response = array('message' => 'Data frequency sudah terdaftar di formula program');
                die(json_encode($response));
                return false;
            } 
        }
         
        $pushdata = array();

        foreach ($id as $i) {
            mysqli_query($conn, "DELETE FROM tbl_frequency WHERE code_frequency = '$i'");
        }

        $sqlResultFrequency = "SELECT id_frequency, code_frequency, level_frequency FROM tbl_frequency";
        $queryResultFrequency = mysqli_query($conn, $sqlResultFrequency);
        while ($rowsListFrequency = mysqli_fetch_assoc($queryResultFrequency)) {
            $response = array(
                'label' => $rowsListFrequency['code_frequency'].' - '.$rowsListFrequency['level_frequency'],
                'value' => $rowsListFrequency['code_frequency'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckDataFormula($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = '$id'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListFormula = "SELECT code_formula FROM tbl_formula";
        $resultCheckListFormula = mysqli_query($conn, $sqlCheckListFormula);
        
        $pushdata = array();

        if (mysqli_num_rows($resultCheckListFormula) > 0) {
            while ($rowsListFormula = mysqli_fetch_assoc($resultCheckListFormula)) {
                $response = array(
                    'label' => 'Program Workout '.$rowsListFormula['code_formula'],
                    'value' => $rowsListFormula['code_formula'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data formula program workout not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleCheckDataFormulaWorkout($id) {

    global $conn;

    if(isset($id) || !empty($id)) {

        $sqlCheckUser= "SELECT role_user FROM tbl_users WHERE role_user = 'Trainer'";
        $resultCheckUser= mysqli_query($conn, $sqlCheckUser);

        if (!$resultCheckUser) {
            $response = array('message' => 'Endpoint not found');
            die(json_encode($response));
            return false;
        }
        
        $sqlCheckListFormulaWorkout = "SELECT * FROM tbl_training_pattern ORDER BY code_formula ASC, seq_training_pattern ASC";
        $resultCheckListFormulaWorkout = mysqli_query($conn, $sqlCheckListFormulaWorkout);
        
        $pushdata = array();

        $no = 1;
        if (mysqli_num_rows($resultCheckListFormulaWorkout) > 0) {
            while ($rowsListFormulaWorkout = mysqli_fetch_assoc($resultCheckListFormulaWorkout)) {
                $response = array(
                    'label' => 'R'.$no++.'. '.$rowsListFormulaWorkout['code_formula'].'. '.$rowsListFormulaWorkout['seq_training_pattern'].': '.$rowsListFormulaWorkout['body_training_pattern'],
                    'value' => $rowsListFormulaWorkout['code_training_pattern'],
                );
                $pushdata[] = $response;
            }
        } else {
            $response = array('message' => 'Data rule workout not found');
            die(json_encode($response));
            return false;
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleDeleteFormulaProgram($data){
    global $conn;

    if(isset($data)) {
        $id = $data['idFormula'];
        
        foreach ($id as $i) {
            $sqlCheckFormula = "SELECT code_formula FROM tbl_program WHERE code_formula = '$i'";
            $queryCheckFormula = mysqli_query($conn, $sqlCheckFormula);
            if (mysqli_num_rows($queryCheckFormula) > 0) {
                $response = array('message' => 'Data formula sudah terdaftar dalam program workout');
                die(json_encode($response));
                return false;
            } 
        }

        $pushdata = array();

        foreach ($id as $i) {
            mysqli_query($conn, "DELETE FROM tbl_formula WHERE code_formula = '$i'");
            mysqli_query($conn, "DELETE FROM tbl_formula_workout WHERE code_formula = '$i'");
        }

        $sqlResultFormula = "SELECT code_formula FROM tbl_formula";
        $queryResultFormula = mysqli_query($conn, $sqlResultFormula);
        while ($rowsListFormula = mysqli_fetch_assoc($queryResultFormula)) {
            $response = array(
                'label' => 'Program Workout '.$rowsListFormula['code_formula'],
                'value' => $rowsListFormula['code_formula'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);

    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleDeleteFormulaWorkout($data){
    global $conn;

    if(isset($data)) {
        $id = $data['idFormula'];
        
        foreach ($id as $i) {
            $sqlCheckFormula = "SELECT code_training_pattern FROM tbl_schedule WHERE code_training_pattern = '$i'";
            $queryCheckFormula = mysqli_query($conn, $sqlCheckFormula);
            if (mysqli_num_rows($queryCheckFormula) > 0) {
                $response = array('message' => 'Data rule workout sudah terdaftar dalam jadwal program workout');
                die(json_encode($response));
                return false;
            } 
        }

        $pushdata = array();

        foreach ($id as $i) {
            mysqli_query($conn, "DELETE FROM tbl_training_pattern WHERE code_training_pattern = '$i'");
            mysqli_query($conn, "DELETE FROM tbl_detail_pattern WHERE code_training_pattern = '$i'");
        }

        $no = 1;
        $sqlResultFormulaWorkout = "SELECT * FROM tbl_training_pattern ORDER BY code_formula ASC, seq_training_pattern ASC";
        $queryResultFormulaWorkout = mysqli_query($conn, $sqlResultFormulaWorkout);
        while ($rowsListFormulaWorkout = mysqli_fetch_assoc($queryResultFormulaWorkout)) {
            $response = array(
                'label' => 'R'.$no++.'. '.$rowsListFormulaWorkout['code_formula'].'. '.$rowsListFormulaWorkout['seq_training_pattern'].': '.$rowsListFormulaWorkout['body_training_pattern'],
                'value' => $rowsListFormulaWorkout['code_training_pattern'],
            );
            $pushdata[] = $response;
        }
        echo json_encode($pushdata);

    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

function handleCheckScheduleWorkout($data) {

    global $conn;

    if(isset($data)) {
        
        $id = htmlspecialchars($data["schedule"]);
        $date = htmlspecialchars($data["date"]);
         
        $sqlCheckSchedule = "SELECT id_schedule FROM tbl_schedule WHERE code_program = '$id' AND date_schedule = '$date'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckSchedule);

        if (!$resultCheckSchedule) {
            $response = array('message' => 'Error checking schedule');
            die(json_encode($response));
            return false;
        }

        if (mysqli_num_rows($resultCheckSchedule) > 0) {
            $rowsCheckSchedule = mysqli_fetch_assoc($resultCheckSchedule);
            $idSchedule = $rowsCheckSchedule["id_schedule"];

            $sqlCheckScheduleActivity = "SELECT A.id_schedule, B.id_exercise, B.id_training, C.name_workout, D.name_bodypart FROM tbl_schedule AS A
            INNER JOIN tbl_training AS B ON A.id_schedule = B.id_schedule
            INNER JOIN tbl_exercise AS C ON B.id_exercise = C.id_exercise
            INNER JOIN tbl_bodypart AS D ON C.id_bodypart = D.id_bodypart 
            WHERE A.id_schedule = '$idSchedule'";
            $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);

            if (!$resultCheckScheduleActivity) {
                $response = array('message' => 'Error checking schedule activity');
                die(json_encode($response));
                return false;
            }

            $response = array();

            if (mysqli_num_rows($resultCheckScheduleActivity) > 0) {
                while ($rowsActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)) {
                    $response = array(
                        'id' => $rowsActivity['id_training'],
                        'label' => $rowsActivity['name_bodypart'],
                        'value' => $rowsActivity['name_workout'],
                    );
                    $pushdata[] = $response;
                }
            } else {
                $response = array('message' => 'Data activity not found');
                die(json_encode($response));
                return false;
            }

            echo json_encode($pushdata);

        } else {
            $response = array('message' => 'Schedule not found');
            die(json_encode($response));
            return false;
        }
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }

}

function handleDeleteWorkoutSession($data){
    global $conn;

    if(isset($data)) {
        $id = htmlspecialchars($data['idProgram']);
        $day = htmlspecialchars($data['idDay']);
        $train = htmlspecialchars($data['idTraining']);

        $sqlCheckSchedule = "SELECT id_set_training FROM tbl_set_training WHERE id_training = '$train'";
        $resultCheckSchedule = mysqli_query($conn, $sqlCheckSchedule);

        if (mysqli_num_rows($resultCheckSchedule) > 0) {
            $response = array('message' => 'Error sesi workout sudah dilakukan oleh klien');
            die(json_encode($response));
            return false;
        }
        
        $sqlDeletTraining = "DELETE FROM tbl_training WHERE id_training = '$train'";
        mysqli_query($conn, $sqlDeletTraining);

        $pushdata = array();
    
        $sqlCheckScheduleActivity = "SELECT A.id_schedule, B.id_exercise, B.id_training, C.name_workout, D.name_bodypart FROM tbl_schedule AS A
        INNER JOIN tbl_training AS B ON A.id_schedule = B.id_schedule
        INNER JOIN tbl_exercise AS C ON B.id_exercise = C.id_exercise
        INNER JOIN tbl_bodypart AS D ON C.id_bodypart = D.id_bodypart 
        WHERE A.code_program = '$id' AND A.date_schedule = '$day'";
        $resultCheckScheduleActivity = mysqli_query($conn, $sqlCheckScheduleActivity);

        if(mysqli_num_rows($resultCheckScheduleActivity) > 0) {
            while($rowsCheckScheduleActivity = mysqli_fetch_assoc($resultCheckScheduleActivity)){ 
                $response = array(
                    'id' => $rowsCheckScheduleActivity['id_training'],
                    'label' => $rowsCheckScheduleActivity['name_bodypart'],
                    'value' => $rowsCheckScheduleActivity['name_workout'],
                );
                $pushdata[] = $response;
            }
        }
        echo json_encode($pushdata);
    }
    else {
        $response = array('message' => 'Endpoint not found');
        die(json_encode($response));
        return false;
    }
}

mysqli_close($conn);

?>