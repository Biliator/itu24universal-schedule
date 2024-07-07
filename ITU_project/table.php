<?php
/**
 * A variation of the table is used in all our components so we worked on the backend for it together
 * @author xkanko01
 * @author xvorob02
 * @author xbabus01
 */
function GetSideBarLook(){
    $buttons = array();
    // user
    if($_SESSION['data']['rights'] == 0){
        $buttons = array(true, true, true, true, true, false, false, false, false);
    }
    // teacher
    if($_SESSION['data']['rights'] == 1){

        $buttons = array(true, true, true, false, false, true, false, false, false);
    }
    // schedule master :)
    if($_SESSION['data']['rights'] == 2){
        $buttons = array(true, false, true, false, false, false, false, false, false);
    }
    // garant
    if($_SESSION['data']['rights'] == 3){
        $buttons = array(true, true, true, false, false, true, true, false, false);
    }
    // admin
    if($_SESSION['data']['rights'] == 4){
        $buttons = array(true, true, true, false, false, true, true, true, true);
    }
    $data = array(
        'personal_informations' => $buttons[0],
        'individual_schedule' => $buttons[1],
        'subjects_anotaions' => $buttons[2],
        'subject_regitration' => $buttons[3],
        'draft_schedule' => $buttons[4],
        'personal_request' => $buttons[5],
        'activity_request' => $buttons[6],
        'manage_user' => $buttons[7],
        'manage_rooms' => $buttons[8]

    );
    return $data;
}

function IsSpace($result, $row, $activity){
    $day = intval($activity['den']);
    $duration = intval($activity['delka']);
    $h10 = intval($activity['cas'][0])*10;
    $h1  = intval($activity['cas'][1]);
    $time = $h10 + $h1 - 6;

    for ($x = 0; $x < $duration; $x++) {
        if($result[$day][$row][$x + $time] !== false){
            return false;
        }
    }
    return true;
}

function getClass($activity){
    $type = $activity['typ'];
    $duration = $activity['delka'];

    if($type == 0 and $duration == 1){
        return 'grid-1h';
    }
    if($type == 0 and $duration == 2){
        return 'grid-2h';
    }
    if($type == 0 and $duration == 3){
        return 'grid-3h';
    }
    if($type == 1 and $duration == 1){
        return 'grid-1hcvs';
    }
    if($type == 1 and $duration == 2){
        return 'grid-2hcvs';
    }
    if($type == 1 and $duration == 3){
        return 'grid-3hcvs';
    }
    if($type == 2 and $duration == 1){
        return 'grid-1hcv';
    }
    if($type == 2 and $duration == 2){
        return 'grid-2hcv';
    }
    if($type == 2 and $duration == 3){
        return 'grid-3hcv';
    }
}

function AppendActivity($result, $row, $activity, $check){

    $class = getClass($activity);

    $JSactivity = array(
        'subject' => $activity['predmet'],
        'nazev' => $activity['nazev'],
        'class' => $class,
        'check' => true,
        'room' => $activity['mistnost'],
        'checked' => $check,
        'lastModified' => true,
        'id' => $activity['id_aktivity']
    );

    $day = intval($activity['den']);
    $duration = intval($activity['delka']);
    $h10 = intval($activity['cas'][0])*10;
    $h1  = intval($activity['cas'][1]);
    $time = $h10 + $h1 - 6;

    for ($x = 0; $x < $duration; $x++) {
        $result[$day][$row][$x + $time] = array();
        $result[$day][$row][$x + $time] = $JSactivity;
    }
    return $result;
}

function AppendEmptyRow($result, $row, $activity){
    $day = intval($activity['den']);
    $result[$day][$row] = array();
    for ($y = 0; $y < 15; $y++) {
        $result[$day][$row][$y] = false;
    }
    return $result;
}

function GetJSDay($day){
    $day_str = '';
    if($day == 1)
        $day_str = 'PO';
    if($day == 2)
        $day_str = 'UT';
    if($day == 3)
        $day_str = 'ST';
    if($day == 4)
        $day_str = 'CT';
    if($day == 5)
        $day_str = 'PA';
    
    $JSDay = array(
        'subject' => $day_str,
        'class' => 'grid-day',
        'check' => false,
        'room' => ''
    );

    return $JSDay;

}

function GetJSTime($num){
    $time = '';
    if($num == 7)
        $time = '7:00 - 7:50';
    if($num == 8)
        $time = '8:00 - 8:50';
    if($num == 9)
        $time = '9:00 - 9:50';
    if($num == 10)
        $time = '10:00 - 10:50';
    if($num == 11)
        $time = '11:00 - 11:50';
    if($num == 12)
        $time = '12:00 - 12:50';
    if($num == 13)
        $time = '13:00 - 13:50';
    if($num == 14)
        $time = '14:00 - 14:50';
    if($num == 15)
        $time = '15:00 - 15:50';
    if($num == 16)
        $time = '16:00 - 16:50';
    if($num == 17)
        $time = '17:00 - 17:50';
    if($num == 18)
        $time = '18:00 - 18:50';
    if($num == 19)
        $time = '19:00 - 19:50';
    if($num == 20)
        $time = '20:00 - 20:50';
    if($num == 21)
        $time = '21:00 - 21:50';
    if($num == 22)
        $time = '22:00 - 22:50';
    
    $JSTime = array(
        'subject' => $time,
        'class' => 'grid-day',
        'check' => false,
        'room' => ''
    );

    return $JSTime;
}

function FillEmptySpaces($result, $number_row){
    $JSBlack = array(
        'subject' => '',
        'class' => 'grid-black',
        'check' => false,
        'room' => ''
    );

    $JSEmpty = array(
        'subject' => '',
        'class' => 'grid-empty',
        'check' => false,
        'room' => ''
    );
    // table 
    for ($x = 0; $x <= 5; $x++) {
        // row
        for ($y = 0; $y < $number_row[$x]; $y++) {
            $deleted = 0;
            // column
            for ($z = 0; $z < 15 - $deleted; $z++) {

                // first block black
                if($x == 0 and $z == 0){
                    $result[$x][$y][$z] = array();
                    $result[$x][$y][$z] = $JSBlack;
                }

                // first line time
                elseif($x == 0){
                    $result[$x][$y][$z] = array();
                    $result[$x][$y][$z] = GetJSTime($z + 6);
                }

                // first column and first row DATE
                elseif($y == 0 and $z == 0){
                    $result[$x][$y][$z] = array();
                    $result[$x][$y][$z] = GetJSDay($x);
                }

                // first column but not first row BLACK
                elseif($z == 0){
                    $result[$x][$y][$z] = array();
                    $result[$x][$y][$z] = $JSBlack;
                }

                // empty
                elseif($result[$x][$y][$z] == false){
                    $result[$x][$y][$z] = array();
                    $result[$x][$y][$z] = $JSEmpty;
                }

                elseif( (strcmp($result[$x][$y][$z]['class'], 'grid-2h') == 0) or
                        (strcmp($result[$x][$y][$z]['class'], 'grid-2hcv') == 0) or
                        (strcmp($result[$x][$y][$z]['class'], 'grid-2hcvs') == 0)){
                            $deleted++;
                            array_splice($result[$x][$y], $z + 1, 1);
                        }
                elseif( (strcmp($result[$x][$y][$z]['class'], 'grid-3h') == 0) or
                        (strcmp($result[$x][$y][$z]['class'], 'grid-3hcv') == 0) or
                        (strcmp($result[$x][$y][$z]['class'], 'grid-3hcvs') == 0)){
                            $deleted++;
                            array_splice($result[$x][$y], $z + 1, 1);
                            $deleted++;
                            array_splice($result[$x][$y], $z + 1, 1);
                        }
            }
        }
    }
    return $result;
}

function CreateTable($data){
    $result = array();
    $number_row = array();
    for ($x = 0; $x <= 5; $x++) {
        $number_row[$x] = 1; 
    }
    for ($x = 0; $x <= 5; $x++) {
        $result[$x] = array();
        $result[$x][0] = array();
        for ($y = 0; $y < 15; $y++) {
            $result[$x][0][$y] = false;
        }
    }

    $userActivities = getUserActivities();

    foreach($data as $activity){
        $check = false;
        foreach($userActivities as $uActiv){
            if($uActiv == $activity['id_aktivity']) {
                $check = true;
                break;
            }
        }
        $day = intval($activity['den']);
        $row = 0;
        while(true){
            if(IsSpace($result, $row, $activity)){
                $result = AppendActivity($result, $row, $activity, $check);
                break;
            }
            else{
                $row ++;
            }
            if($row >= $number_row[$day]){
                $result = AppendEmptyRow($result, $row, $activity);
                $result = AppendActivity($result, $row, $activity, $check);
                $number_row[$day]++;
                break;
            }
        }
    }
    $result = FillEmptySpaces($result, $number_row);
    return $result;
}


function getUserActivities() {
            
    $db = mysqli_init();
    if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
        die('Cannot connect: ' . mysqli_connect_error());
    }
    
    $user_Id = $_SESSION['user'];
    $barva = $_SESSION['barva'];
    $query = "SELECT prihlasen.id_aktivity FROM prihlasen WHERE prihlasen.osobni_cislo = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $user_Id);
    $stmt->execute();
    $stmt->bind_result($activity_Id);
    $activities = array();
    while ($stmt->fetch()) {
        $activities[] = $activity_Id;
    }

    $stmt->close();
    mysqli_close($db);

    return $activities;
}

?>