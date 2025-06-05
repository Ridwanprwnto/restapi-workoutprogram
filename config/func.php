<?php

function autonum($lenght_value, $id, $table){

    global $conn;

    $query = 'SELECT MAX(RIGHT('.$id.', '.$lenght_value.')) AS max_id FROM '.$table.' ORDER BY '.$id;
    $result = mysqli_query($conn, $query);
    $data   = mysqli_fetch_assoc($result);

    $last_id = $data['max_id'];
    $num = (int) substr($last_id, 0, $lenght_value);
    $new_num = str_repeat("0", $lenght_value - strlen($num+1)).($num+1);

    return $new_num;

}

function InsertTypeWorkout($data){

    global $conn;

    $name = isset($data["name_workout"]) ? $data["name_workout"] : [];
    $desc = isset($data["desc_workout"]) ? $data["desc_workout"] : [];
    
    if(count(array_unique($name, SORT_REGULAR)) < count($name)) {
        $GLOBALS['alert'] = "Gagal!, Terdapat penginputan data yang sama";
        return false;
    }

    $result = array();

    for($countcek = 0; $countcek < count($name); $countcek++) {

        $arr_data = array(
            $name_data = $name[$countcek],
            $desc_data = $desc[$countcek]
        );

        $query_cek = mysqli_query($conn, "SELECT name_type_workout FROM tbl_type_workout WHERE name_type_workout = '$name_data'");

        if(mysqli_num_rows($query_cek) > 0 ) {
            $GLOBALS['alert'] = "Gagal!, Type workout ".$name_data." sudah terdaftar";
            return false;
        }

        $result[] = $arr_data;
    }

    foreach ($result as $i => $v) {
        $rows = $v;
        mysqli_query($conn, "INSERT INTO tbl_type_workout (name_type_workout, desc_type_workout) VALUES ('$rows[0]', '$rows[1]')");    
    }
    
    return mysqli_affected_rows($conn);
}

function DeleteTypeWorkout($data){
    global $conn;

    $id = $data["checkidtype"];

    foreach ($id as $n) {
        $sqlCheck = "SELECT id_type_workout FROM tbl_exercise WHERE id_type_workout  = '$n'";
        $queryCheck = mysqli_query($conn, $sqlCheck);
        if (mysqli_num_rows($queryCheck) > 0) {
            $GLOBALS['alert'] = "Gagal!, Type workout ".$n." sudah terdaftar dalam daftar exercise";
            return false;
        } 
    }

    foreach ($id as $n) {
        $sqlCheck = "SELECT id_type_workout FROM tbl_formula_workout WHERE id_type_workout  = '$n'";
        $queryCheck = mysqli_query($conn, $sqlCheck);
        if (mysqli_num_rows($queryCheck) > 0) {
            $GLOBALS['alert'] = "Gagal!, Type workout ".$n." sudah terdaftar dalam daftar formula program";
            return false;
        } 
    }

    foreach ($id as $i)  {
        $sql = "DELETE FROM tbl_type_workout WHERE id_type_workout = '$i'";
        mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
}

function InsertBodypart($data){

    global $conn;

    $name = isset($data["name_bodypart"]) ? $data["name_bodypart"] : [];
    
    if(count(array_unique($name, SORT_REGULAR)) < count($name)) {
        $GLOBALS['alert'] = "Gagal!, Terdapat penginputan data yang sama";
        return false;
    }

    $result = array();

    for($countcek = 0; $countcek < count($name); $countcek++) {

        $arr_data = array(
            $name_data = $name[$countcek]
        );

        $query_cek = mysqli_query($conn, "SELECT name_bodypart FROM tbl_bodypart WHERE name_bodypart = '$name_data'");

        if(mysqli_num_rows($query_cek) > 0 ) {
            $GLOBALS['alert'] = "Gagal!, Bodypart ".$name_data." sudah terdaftar";
            return false;
        }

        $result[] = $arr_data;
    }

    foreach ($result as $i => $v) {
        $rows = $v;
        mysqli_query($conn, "INSERT INTO tbl_bodypart (name_bodypart) VALUES ('$rows[0]')");    
    }
    
    return mysqli_affected_rows($conn);
}

function DeleteBodypart($data){
    global $conn;

    $id = $data["checkidbody"];

    foreach ($id as $n) {
        $sqlCheck = "SELECT id_bodypart FROM tbl_exercise WHERE id_bodypart = '$n'";
        $queryCheck = mysqli_query($conn, $sqlCheck);
        if (mysqli_num_rows($queryCheck) > 0) {
            $GLOBALS['alert'] = "Gagal!, Bodypart ".$n." sudah terdaftar dalam daftar exercise";
            return false;
        } 
    }

    foreach ($id as $i)  {
        $sql = "DELETE FROM tbl_bodypart WHERE id_bodypart = '$i'";
        mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
}

function DeleteWorkoutGuide($data){
    global $conn;

    $id = $data["checkidworkout"];

    foreach ($id as $n) {
        $sqlCheck = "SELECT id_exercise FROM tbl_training WHERE id_exercise = '$n'";
        $queryCheck = mysqli_query($conn, $sqlCheck);
        if (mysqli_num_rows($queryCheck) > 0) {
            $GLOBALS['alert'] = "Gagal!, Exercise ".$n." sudah terdaftar dalam daftar program latihan workout";
            return false;
        } 
    }

    foreach ($id as $i)  {
        $sql = "DELETE FROM tbl_exercise WHERE id_exercise = '$i'";
        mysqli_query($conn, $sql);
    }

    return mysqli_affected_rows($conn);
}

function fillSeletTypeWorkout() {

    global $conn;

    $sql = "SELECT * FROM tbl_type_workout";
    $query = mysqli_query($conn, $sql);
    $output = '';

    if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
            $output .= '<option value="'.$row['id_type_workout'].'">'.$row['name_type_workout'].'</option>';
        }
    }
    return $output;
}

function fillSeletBodypart() {

    global $conn;

    $sql = "SELECT * FROM tbl_bodypart";
    $query = mysqli_query($conn, $sql);
    $output = '';

    if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
            $output .= '<option value="'.$row['id_bodypart'].'">'.$row['name_bodypart'].'</option>';
        }
    }
    return $output;
}

function InsertWorkoutGuide($data){

    global $conn;

    $type = isset($data["type_wokout"]) ? $data["type_wokout"] : [];
    $body = isset($data["bodypart_wokout"]) ? $data["bodypart_wokout"] : [];
    $name = isset($data["name_workout"]) ? $data["name_workout"] : [];
    $met = isset($data["met_workout"]) ? $data["met_workout"] : [];
    
    if(count(array_unique($name, SORT_REGULAR)) < count($name)) {
        $GLOBALS['alert'] = "Gagal!, Terdapat penginputan data yang sama";
        return false;
    }

    $result = array();

    for($countcek = 0; $countcek < count($name); $countcek++) {

        $arr_data = array(
            $type[$countcek],
            $body[$countcek],
            $name_data = $name[$countcek],
            $met[$countcek]
        );

        $query_cek = mysqli_query($conn, "SELECT name_workout FROM tbl_exercise WHERE name_workout = '$name_data'");

        if(mysqli_num_rows($query_cek) > 0 ) {
            $GLOBALS['alert'] = "Gagal!, Exercise ".$name_data." sudah terdaftar";
            return false;
        }

        $result[] = $arr_data;
    }

    foreach ($result as $i => $v) {
        $rows = $v;
        mysqli_query($conn, "INSERT INTO tbl_exercise (id_type_workout, id_bodypart, name_workout, met_exercise) VALUES ('$rows[0]', '$rows[1]', '$rows[2]', '$rows[3]')");    
    }
    
    return mysqli_affected_rows($conn);
}
?>