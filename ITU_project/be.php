<?php
/**
 * This file receives request that need to work with the DB. 
 * The value of $_POST['request'] dictates what type of request should be handled
 * 
 * @author xkanko01
 * @author xbabus01
 * @author xvorob02
 */
        include 'table.php';
        if(isset($_POST["request"])) {
            $req = $_POST["request"];
            session_start();
            switch ($req){
                case "login":
                    login();
                    break;
                case "logout":
                    logout();
                    break;
                case "getUserRights":
                    getUserRights();
                    break;
                case "profileDetails":
                    profileDetails();
                    break;
                case "updateProfile":
                    updateProfile();
                    break;
                case "getClassActivities":
                    getClassActivities();
                    break;
                case "getClasses":
                    getClasses();
                    break;
                case "deleteOldActivities":
                    deleteOldActivities();
                    break;
                case "getClassesShortcut":
                    getClassesShortcut();
                    break;
                case "registerNewActivities":
                    registerNewActivities();
                    break;
                case "getRegisteredActivities":
                    getRegisteredActivities();
                    break;
                case "SideBarLook":
                    SideBarLook();
                    break;
                case "getPersonalRequirements":
                    getPersonalRequirements();
                    break;
                case "storePersonalRequirements":
                    storePersonalRequirements();
                    break;
                case "getTable":
                    getTable();
                    break;
                case "registerToClass":
                    registerToClass();
                    break;
                case "getRegisteredClasses":
                    getRegisteredClasses();
                    break;
                case "getRooms":
                    getRooms();
                    break;
                case "getUsers":
                    getUsers();
                    break;
                case "getAllClasses":
                    getAllClasses();
                    break;
                case "getGarantedClasses":
                    getGarantedClasses();
                    break;
                case "newUser":
                    newUser();
                    break;
                case "getClassDetails":
                    getClassDetails();
                    break;
                case "updateClassDetails":
                    updateClassDetails();
                    break;
                case "checkGarant":
                    checkGarant();
                    break;              
                case "newRoom":
                    newRoom();
                    break;
                case "newCourse":
                    newCourse();
                    break;                
                case "getRoomInfo":
                    getRoomInfo();
                    break;
                case "deleteRoom":
                    deleteRoom();
                    break;             
                case "addActivity":
                    addActivity();
                    break;
                case "getCurrentClasses":
                    getCurrentClasses();
                    break;
                case "register":
                    register();
                    break;
                case "getYear":
                    getYear();
                    break;
                case "getToEditActivity":
                    getToEditActivity();
                    break;
                case "editActivity":
                    editActivity();
                    break;
                case "updateColors":
                    updateColors();
                    break;
                case "addOwnActivty":
                    addOwnActivty();
                    break;
                case "deleteActivity":
                    deleteActivity();
                    break;
                case "otherProfileDetails":
                    otherProfileDetails();
                    break;
                case "getOtherPersonalRequirements":
                    getOtherPersonalRequirements();
                    break;
                default:
                    $resp = array('resCode' => '1',);
                    header("Content-Type: application/json");
                    echo json_encode($darespta);
                    break;
            }
        } else {
            $resp = array('resCode' => '1',);
            header("Content-Type: application/json");
            echo json_encode($resp);
        }

        /**
         * @author xbabus01
         */
        function deleteRoom(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
            if (isset($_POST['cislo'])) {
                $cislo = $_POST['cislo'];
            }

            $query = "DELETE FROM `mistnosti` WHERE `mistnosti`.`cislo` = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $cislo);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
            
        }
        /**
         * @author xkanko01
         */
        function addActivity(){
            if (isset($_POST['class'])) {
                $class = $_POST['class'];
                $name = $_POST['name'];
                $length = strval($_POST['length']);
                $type = strval($_POST['type']);
                $request = $_POST['requests'];
            } else{
                $resp = array("resCode" => "0");
                header("Content-Type: application/json");
                echo json_encode($resp);
                return;
            }

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            //find out what number will the id have
            $query = "SELECT id_aktivity FROM aktivity ORDER BY id_aktivity DESC LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($id_aktivity);   
            
            $stmt->fetch();

            $number = $id_aktivity + 1;
            
            $stmt->close();
            
            $query2 = "INSERT INTO aktivity (id_aktivity, predmet, nazev, den, cas, delka, typ, mistnost, vyucujici, pozadavek)
            VALUES (?, ?, ?, NULL, NULL, ?, ?, NULL, NULL, ?)";
            
            $stmt2 = $db->prepare($query2);
            $stmt2->bind_param("issiis", $number, $class, $name, $length, $type, $request);
            $result = $stmt2->execute();

            $stmt2->close();
            mysqli_close($db);

            $result = 1;
            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getRoomInfo(){
            if (isset($_POST['cislo'])) {
                $cislo = $_POST['cislo'];
            } else{
                $resp = array(
                    'resCode' => 1
                );
                header("Content-Type: application/json");
                echo json_encode($resp);
                return;
            }

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $query = "SELECT nazev, kapacita FROM mistnosti WHERE cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $cislo);
            $stmt->execute();
            $stmt->bind_result($nazev, $kapacita);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'nazev' => $nazev,
                    'kapacita' => $kapacita,
                );
                $data = $row;
            }

            $resp = array(
                'data' => $data,
                'resCode' => (count($data) > 0) ? 0 : 1
            );

            $stmt->close();
            mysqli_close($db);
        
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function newRoom(){
            if (isset($_POST['name']) && isset($_POST['number']) && isset($_POST['capacity'])) {
                $cislo = $_POST['number'];
                $nazev = $_POST['name'];
                $kapacita = $_POST['capacity'];
            } else{
                $resp = array("resCode" => "1");
                header("Content-Type: application/json");
                echo json_encode($resp);
            }

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $query = "INSERT INTO `mistnosti` (`cislo`, `nazev`, `kapacita`) VALUES (?, ?, ?)";
            
            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $cislo, $nazev, $kapacita);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            $resp = array('resCode' => '0');
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function newCourse(){
            if (isset($_POST['short'])) {
                $zkratka = $_POST['short'];
                $nazev = $_POST['name'];
                $kredity = $_POST['credits'];
                $semestr = $_POST['semester'];
                $fakulta = $_POST['faculty'];
                $rok = $_POST['year'];
                $garant = $_POST['garant'];

            } else{
                $resp = array("resCode" => "1");
                header("Content-Type: application/json");
                echo json_encode($resp);
                return;
            }

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $query = "INSERT INTO `Predmety` (`zkratka`, `nazev`, `kredity`, `semestr`, `fakulta`, `rocnik`, `garant`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssss", $zkratka, $nazev, $kredity, $semestr, $fakulta, $rok, $garant);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function newUser(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['date']) && isset($_POST['pass']) && isset($_POST['rights'])) {
                $name = $_POST['name'];
                $surname= $_POST['surname'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $date = $_POST['date'];
                $rights = $_POST['rights'];
                $pass = $_POST['pass'];
            } else{
                $resp = array("resCode" => "1");
                header("Content-Type: application/json");
                echo json_encode($resp);
            }

            $login = "x";
            $login .= strtolower(substr($surname, 0, 5));
            //enforce login length
            while(strlen($login) < 6) $login .= "x";
            $searchPattern = $login . "%";
            //find out what number will the id have
            $query = "SELECT osobni_cislo FROM Users WHERE osobni_cislo LIKE ? ORDER BY osobni_cislo DESC LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $searchPattern);
            $stmt->execute();
            $stmt->bind_result($osobni_cislo);   
            
            $stmt->fetch();

            if ($osobni_cislo !== null) {
                $number = intval(substr($osobni_cislo, 6, 2));
                $number++;
                if($number < 10) $login .= "0";
            } else {
                $number = "00";
            }
            $login .= $number;
            $stmt->close();

            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            
            $query = "INSERT INTO `Users` (`osobni_cislo`, `pass`, `name`, `surname`, `rok_narozeni`, `email`, `tel`, `prava`, `rocnik`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt2 = $db->prepare($query);
            $stmt2->bind_param("sssssssss", $login, $hashedPass, $name, $surname, $date, $email, $tel, $rights, $rocnik);
            $result = $stmt2->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt2->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        
        /**
         * @author xvorob02
         */
        function login() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
            if (isset($_POST['loginID']) && isset($_POST['password'])) {
                $osobni_cislo = $_POST['loginID'];
                $password = $_POST['password'];
            }


            $query = "SELECT * FROM Users WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $osobni_cislo);
            $stmt->execute();
            $stmt->bind_result($user_Id, $passwordHashed, $name, $surname, $date_of_birth, $email, $tel, $rights, $year, $requirements, $barva);
            
            $row_num = 0;
            while ($stmt->fetch()) {
                $data = array(
                    'password' => $passwordHashed,
                    'name' => $name,
                    'surname' => $surname,
                    'date_of_birth' => $date_of_birth,
                    'email' => $email,
                    'tel' => $tel,
                    'rights' => $rights,
                    'year'=> $year,
                    'requirements' => $requirements,
                    'barva' => $barva
                );
                $row_num += 1;
            }

            if ($row_num < 1) {
                $resp = array("resCode" => "1");
            } else { 
                if(password_verify($password, $passwordHashed)){
                    $_SESSION['user'] = $user_Id;
                    $_SESSION["data"] = $data;
                    $_SESSION['barva'] = $barva;
                } else{
                    session_destroy();
                }
                if(isset($_SESSION['user'])) $resp = array("resCode" => "0");
                else $resp = array("resCode" => "1");
            }

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function logout(){
            $resp = array("resCode" => "0");
            session_destroy();
            //make sure the cookie is unset
            setcookie("PHPSESSID", "", time() - 3600, "/");
            header("Content-Type: application/json");
            //header("Location: index.php");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function getUserRights(){
            if(!isset($_SESSION['user'])) {
                $resp = array("resCode" => "1");
            }
            else {
                $resp = array(
                    'resCode' => 0,
                    'rights' => $_SESSION['data']['rights']
                );
            }

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function profileDetails() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];

            $query = "SELECT name, surname, email, rok_narozeni, tel, prava FROM Users WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $user_Id);
            $stmt->execute();   
            $stmt->bind_result($name, $surname, $email, $rok_narozeni, $tel, $prava);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'rok_narozeni' => $rok_narozeni,
                    'tel' => $tel,
                    'prava' => $prava
                );
                $data[] = $row;
            }

            $data['SideBarLook'] = GetSideBarLook();

            $stmt->close();
            mysqli_close($db);

            $resp = array(
                'data' => $data,
                'resCode' => (count($data) > 0) ? 0 : 1
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function updateProfile() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $osobni_cislo = $_SESSION["user"];
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $email = $_POST['email'];
                $rok_narozeni = $_POST['rok_narozeni'];
                $tel = $_POST['tel'];
                $passwd = $_POST['passwd'];
            }

            if ($passwd != "") {
                $hashedPass = password_hash($passwd, PASSWORD_DEFAULT);
                $query = "UPDATE Users SET name = ?, surname = ?, email = ?, rok_narozeni = ?, tel = ?, pass = ? WHERE osobni_cislo = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("sssssss", $name, $surname, $email, $rok_narozeni, $tel, $hashedPass, $osobni_cislo);
            } else {
                $query = "UPDATE Users SET name = ?, surname = ?, email = ?, rok_narozeni = ?, tel = ? WHERE osobni_cislo = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ssssss", $name, $surname, $email, $rok_narozeni, $tel, $osobni_cislo);
            }

            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function registerToClass() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $osobni_cislo = $_POST['osobni_cislo'];
                $zkratka = $_POST['zkratka'];
                $prava = $_POST['prava'];
            }

            $query = "INSERT INTO prihlasen (osobni_cislo, zkratka, typ) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $osobni_cislo, $zkratka, $prava);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getRegisteredClasses() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $osobni_cislo = $_POST['osobni_cislo'];
            }
            $query = "SELECT Predmety.zkratka FROM Predmety, ON Predmety.zkratka = zapsan.zkratka
                        WHERE zapsan.osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $osobni_cislo);
            $stmt->execute();
            $stmt->bind_result($zkratka);

            $data = array();
            while ($stmt->fetch()) {
                $data[] = $zkratka;
            }

            $resp = array(
                'data' => $data,
                'resCode' => (count($data) > 0) ? 0 : 1
            );

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */        
        function getClasses() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];
            
            $query = "SELECT zapsan.zkratka FROM zapsan WHERE zapsan.osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $user_Id);
            $stmt->execute();   
            $stmt->bind_result($zkratka);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'label' => $zkratka,
                    'checked' => false
                );
                $data[] = $row;
            }

            if(count($data) > 0){
                $res = 0;
            }
            else{
                $res = 1;
            }
            $resp = array(
                'resCode' => $res,
                'data' => $data
            );

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getClassesShortcut() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];
            
            $query = "SELECT Predmety.zkratka FROM Predmety";
            $stmt = $db->prepare($query);
            $stmt->execute();   
            $stmt->bind_result($zkratka);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'label' => $zkratka,
                    'checked' => false,
                    'lastmodified' => false
                );
                $data[] = $row;
            }

            if(count($data) > 0){
                $res = 0;
            }
            else{
                $res = 1;
            }
            $resp = array(
                'resCode' => $res,
                'data' => $data
            );

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getRooms(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
            
            $query = "SELECT * FROM mistnosti ORDER BY cislo ASC";
            $stmt = $db->prepare($query);
            $stmt->execute();   
            $stmt->bind_result($cislo, $nazev, $kapacita);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'cislo' => $cislo,
                    'nazev' => $nazev,
                    'kapacita' => $kapacita
                );
                $data[] = $row;
            }

            if(count($data) > 0){
                $res = 0;
            }
            else{
                $res = 1;
            }
            $resp = array(
                'resCode' => $res,
                'data' => $data
            );

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getUsers(){
                $db = mysqli_init();
                if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                    die('Cannot connect: ' . mysqli_connect_error());
                }
                
                $query = "SELECT osobni_cislo, name, surname, email, rok_narozeni, tel, prava, rocnik FROM Users";
                $stmt = $db->prepare($query);
                $stmt->execute();   
                $stmt->bind_result($login, $name, $surname, $email, $rok_narozeni, $tel, $prava, $rocnik);

                $data = array();
                while ($stmt->fetch()) {
                    $row = array(
                        'login' => $login,
                        'name' => $name,
                        'surname' => $surname,
                        'email' => $email,
                        'rok_narozeni' => $rok_narozeni,
                        'tel' => $tel,
                        'prava' => $prava,
                        'rocnik' => $rocnik,
                    );
                    $data[] = $row;
                }

                $resp = array(
                    'data' => $data,
                    'resCode' => (count($data) > 0) ? 0 : 1
                );

                $stmt->close();
                mysqli_close($db);

                header("Content-Type: application/json");
                echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function getTable() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if (isset($_POST['subjects'])) {
                $subjects = json_decode($_POST['subjects'], true);
            }
            $week = array(1, 2, 3, 4, 5);
            $data = array();
            $query = "SELECT * FROM aktivity WHERE aktivity.den = ? AND aktivity.predmet = ?";
            $stmt = $db->prepare($query);
            if(count($subjects) > 0){
                foreach ($week as $day){
                    foreach ($subjects as $subject) {
                        $stmt->bind_param("ss", $day, $subject);
                        $stmt->execute();
                        $stmt->bind_result($id_aktivity, $predmet, $nazev, $den, $cas, $delka, $typ, $mistnost, $vyucujici, $pozadavek);
        
                        while ($stmt->fetch()) {
                            $row = array(
                                'id_aktivity' => $id_aktivity,
                                'predmet' => $predmet,
                                'nazev' => $nazev,
                                'den' => $den,
                                'cas' => $cas,
                                'delka' => $delka,
                                'typ' => $typ,
                                'mistnost' => $mistnost,
                                'vyucujici' => $vyucujici,
                                'pozadavek' => $pozadavek
                            );
                            $data1[] = $row;
                        }
                    }
                }
                $data = CreateTable($data1);
            }
            else{
                $data1 = [];
                $data = CreateTable($data1);
            }

            
            $resp = array(
                'resCode' => '0',
                'data' => $data
            );

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }

        /**
         * @author xvorob02
         */
        function deleteOldActivities(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];

            $query = "DELETE FROM prihlasen WHERE prihlasen.osobni_cislo = ?";
            $stmt = $db->prepare($query);
            
            $stmt->bind_param("s", $user_Id);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }

        /**
         * @author xvorob02
         */
        function registerNewActivities() {
            
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if (isset($_POST['aktivities'])) {
                $activities = json_decode($_POST['aktivities'], true);
            }

            $user_Id = $_SESSION['user'];

            $query = "INSERT INTO `prihlasen` (`osobni_cislo`, `id_aktivity`) VALUES (?, ?)";
            $stmt = $db->prepare($query);

            foreach ($activities as $activity_Id){
                $stmt->bind_param("ss", $user_Id, $activity_Id);
                $result = $stmt->execute();
            }

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function getRegisteredActivities() {
            
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

            if(count($activities) > 0){
                $query = "SELECT * FROM aktivity WHERE aktivity.id_aktivity = ?";
                $stmt = $db->prepare($query);
                foreach ($activities as $activity){

                    $stmt->bind_param("s", $activity);
                    $stmt->execute();
                    $stmt->bind_result($id_aktivity, $predmet, $nazev, $den, $cas, $delka, $typ, $mistnost, $vyucujici, $pozadavek);

                    while ($stmt->fetch()) {
                        $row = array(
                            'id_aktivity' => $id_aktivity,
                            'predmet' => $predmet,
                            'nazev' => $nazev,
                            'den' => $den,
                            'cas' => $cas,
                            'delka' => $delka,
                            'typ' => $typ,
                            'mistnost' => $mistnost,
                            'vyucujici' => $vyucujici,
                            'pozadavek' => $pozadavek
                        );
                        $data1[] = $row;
                    }
                }
                $data = CreateTable($data1);

                $resp = array(
                    'table' => $data,
                    'Activities' => $activities,
                    'resCode' => 0
                );
            }
            else{
                $data1 = [];
                $data = CreateTable($data1);
                $activities = [];
                $resp = array(
                    'table' => $data,
                    'Activities' => $activities,
                    'resCode' => 0
                );
            }
            $resp['SideBarLook'] = GetSideBarLook();
            $resp['barva'] = $barva;

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getAllClasses() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
        
            $query = "SELECT * FROM Predmety";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($zkratka, $nazev, $kredity, $semestr, $fakulta, $rocnik, $garant);
            
            $rows_count = 0;
            $data1 = array();
            $data2 = array();
            $data3 = array();
            while ($stmt->fetch()) {
                $row = array(
                    'zkratka' => $zkratka,
                    'nazev' => $nazev,
                    'kredity' => $kredity,
                    'semestr' => $semestr,
                    'fakulta' => $fakulta,
                    'rocnik' => $rocnik,
                    'garant' => $garant,
                );
                if ($rocnik == '1')
                    $data1[] = $row;
                else if ($rocnik == '2')
                    $data2[] = $row;
                else if ($rocnik == '3')
                    $data3[] = $row;     
                $rows_count += 1;           
            }
            
            if (isset($_SESSION['user'])) $session = '1';
            else $session = '0';
            $resCode = $rows_count > 0 ? '0' : '1';
            $resp = array(
                'resCode' => $resCode,
                'data1' => $data1,
                'data2' => $data2,
                'data3' => $data3,
                'session' => $session
            );
        
            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getGarantedClasses() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
            if(!isset($_SESSION["user"])) return;
            $garant = $_SESSION["user"];
        
            $query = "SELECT * FROM Predmety WHERE garant = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $garant);
            $stmt->execute();
            $stmt->bind_result($zkratka, $nazev, $kredity, $semestr, $fakulta, $rocnik, $garant);
            
            $rows_count = 0;
            $data1 = array();
            $data2 = array();
            $data3 = array();
            while ($stmt->fetch()) {
                $row = array(
                    'zkratka' => $zkratka,
                    'nazev' => $nazev,
                    'kredity' => $kredity,
                    'semestr' => $semestr,
                    'fakulta' => $fakulta,
                    'rocnik' => $rocnik,
                    'garant' => $garant,
                );
                if ($rocnik == '1')
                    $data1[] = $row;
                else if ($rocnik == '2')
                    $data2[] = $row;
                else if ($rocnik == '3')
                    $data3[] = $row;     
                $rows_count += 1;           
            }
            
            if (isset($_SESSION['user'])) $session = '1';
            else $session = '0';
            $resCode = $rows_count > 0 ? '0' : '1';
            $resp = array(
                'resCode' => $resCode,
                'data1' => $data1,
                'data2' => $data2,
                'data3' => $data3,
                'session' => $session
            );
        
            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getClassDetails() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
        
            if (isset($_POST['zkratka'])) {
                $zkratka = $_POST['zkratka'];
            }
           
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user'] == 'xadmin00')
                    $session = '1';
                else $session = '0';
            } else $session = '0';

            $query = "SELECT p.*, o.name as name, o.surname as surname FROM Predmety p 
                        LEFT JOIN Users o ON p.garant = o.osobni_cislo 
                        WHERE p.zkratka = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $zkratka);
            $stmt->execute();
            $stmt->bind_result($zkratka, $nazev, $kredity, $semestr, $fakulta, $rocnik, $garant, $name, $surname);
        
            $data = array();
            while ($stmt->fetch()) {
                $fullName = $name . " " . $surname;
                $row = array(
                    'zkratka' => $zkratka,
                    'nazev' => $nazev,
                    'kredity' => $kredity,
                    'semestr' => $semestr,
                    'fakulta' => $fakulta,
                    'rocnik' => $rocnik,
                );
                $login = $garant;
                $data[] = $row;
            }

            $resCode = count($data) > 0 ? '0' : '1';
            $resp = array(
                'resCode' => $resCode,
                'data' => $data,
                'login' => $login,
                'garant' => $fullName,
                'session' => $session
            );
        
            $stmt->close();
            mysqli_close($db);
        
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvoro02
         */
        function updateClassDetails() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $zkratka = $_POST['zkratka'];
            $nazev = $_POST['nazev'];
            $kredity = $_POST['kredity'];
            $semestr = $_POST['semestr'];
            $fakulta = $_POST['fakulta'];
            $rocnik = $_POST['rocnik'];
            $garant = $_POST['garant'];

            $query = "UPDATE Predmety 
                        SET nazev = ?, kredity = ?, semestr = ?, fakulta = ?, rocnik = ?, garant = ? 
                        WHERE zkratka = ?";

            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssss", $nazev, $kredity, $semestr, $fakulta, $rocnik, $garant, $zkratka);

            if ($stmt->execute()) {
                $resp = array('resCode' => '0');
            } else {
                $resp = array('resCode' => '1');
            }
        
            $stmt->close();
            mysqli_close($db);
        
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function checkGarant() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $garant = $_POST['garant'];

            $query = "SELECT name, surname, COUNT(*) FROM Users WHERE osobni_cislo = ?";            
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $garant);
            $stmt->execute();
            $stmt->bind_result($name, $surname, $count);
            $stmt->fetch();
        
            $resCode = $count > 0 ? '0' : '1';
            $fullName = $name . " " . $surname;
            $resp = array(
                'resCode' => $resCode,
                'name' => $fullName,
            );
        
            $stmt->close();
            mysqli_close($db);
        
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function getPersonalRequirements() {
            $requirementsString ='';
            $table = array();
            $timeBlockYes = array('value' => true, 'day' => false);
            $timeBlockNo = array('value' => false, 'day' => false);
            $days = array('PO','UT','ST','CT','PA');
            if($_SESSION['data']['requirements'] != NULL){
                $requirementsString = $_SESSION['data']['requirements'];
            }
            else{
                for ($x = 0; $x < 5*14; $x++) {
                    $requirementsString = $requirementsString . '1';
                }
            }

            $splited = str_split($requirementsString);

            for ($x = 0; $x < 5; $x++) {
                $table[$x] = array();
                $day = array('value' => $days[$x], 'day' => true);
                array_push($table[$x], $day);
                for ($y = 0; $y < 14; $y++) {
                    if($splited[$x*14 + $y] == '0'){
                        array_push($table[$x], $timeBlockNo);
                    }
                    else{
                        array_push($table[$x], $timeBlockYes);
                    }
                }
            }
            
            $data = GetSideBarLook();

            $resp = array(
                'resCode' => 0,
                'SideBarLook' => $data,
                'table' => $table
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function storePersonalRequirements() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
        
            if (isset($_POST['requirements'])) {
                $requirements = json_decode($_POST['requirements'], true);
            }

            $user_Id = $_SESSION['user'];
            $query = "UPDATE Users SET pozadavky = ? WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);

            $requirementsString ='';

            foreach($requirements as $reqDay){
                foreach($reqDay as $reqTimeBlock){
                    if(!$reqTimeBlock['day']){
                        if($reqTimeBlock['value']){
                            $requirementsString = $requirementsString . '1';
                        }
                        else{
                            $requirementsString = $requirementsString . '0';
                        }
                    }
                }
            }

            $stmt->bind_param("ss",$requirementsString, $user_Id);
            $result = $stmt->execute();

            if ($result){
                $resp = array('resCode' => '0');
                $_SESSION['data']['requirements'] = $requirementsString;
            }
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getCurrentClasses() {
            $targetDate = strtotime('2024-02-02');
            $currentDate = time();

            if ($currentDate < $targetDate) {
                $semestr = 'zimni';
            } else {
                $semestr = 'letni';
            }

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
        
            $rocnik = $_POST['rocnik'];
            $login = $_SESSION['user'];

            $query = "SELECT p.*, CASE WHEN z.osobni_cislo IS NOT NULL THEN 1 ELSE 0 END AS is_registered
                        FROM Predmety p
                        LEFT JOIN zapsan z ON p.zkratka = z.zkratka AND z.osobni_cislo = ?
                        WHERE p.rocnik = ? AND p.semestr = ?";

            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $login, $rocnik, $semestr);
            $stmt->execute();
            $stmt->bind_result($zkratka, $nazev, $kredity, $semestr, $fakulta, $rocnik, $garant, $is_registered);
            
            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'zkratka' => $zkratka,
                    'nazev' => $nazev,
                    'kredity' => $kredity,
                    'fakulta' => $fakulta,
                    'is_registered' => $is_registered
                );
                $data[] = $row;        
            }
            
            $resCode = count($data) > 0 ? '0' : '1';
            $resp = array(
                'resCode' => $resCode,
                'data' => $data
            );
        
            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xkanko01
         */
        function register() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }
            mysqli_autocommit($db, false); 
            $login = $_SESSION['user'];
            $checkedRows = json_decode($_POST['checkedRows'], true);
            $uncheckedRows = json_decode($_POST['uncheckedRows'], true);

            // Delete unchecked rows
            $queryDelete = "DELETE FROM zapsan WHERE osobni_cislo = ? AND zkratka = ?";
            $stmtDelete = $db->prepare($queryDelete);
            $stmtDelete->bind_param("ss", $login, $zkratka);
        
            foreach ($uncheckedRows as $row) {
                $zkratka = $row['zkratka'];
        
                if (!$stmtDelete->execute()) {
                    $resp = array('resCode' => '1', 'error' => $stmtDelete->error);
                    header("Content-Type: application/json");
                    echo json_encode($resp);
                    mysqli_close($db);
                    exit;
                }
            }
        
            $stmtDelete->close();
        
            $queryInsert = "INSERT INTO zapsan SET osobni_cislo = ?, zkratka = ?, typ = 0";
            $stmtInsert = $db->prepare($queryInsert);
            $stmtInsert->bind_param("ss", $login, $zkratka);
        
            foreach ($checkedRows as $row) {
                $zkratka = $row['zkratka'];
        
                if (!$stmtInsert->execute()) {
                    $resp = array('resCode' => '1', 'error' => $stmtInsert->error);
                    header("Content-Type: application/json");
                    echo json_encode($resp);
                    mysqli_close($db);
                    exit;
                }
            }
        
            $stmtInsert->close();
        
            $resp = array('resCode' => '0');
            mysqli_commit($db);
            mysqli_autocommit($db, true); 
            mysqli_close($db);
        
            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function getClassActivities(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if (isset($_POST['class'])) {
                $class = $_POST['class'];
            }


            $query = "SELECT * FROM aktivity WHERE predmet = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $class);
            $stmt->execute();   
            $stmt->bind_result($id, $predmet, $nazev, $den, $cas, $delka, $typ, $mistnost, $vyucujici, $pozadavek);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'id' => $id,
                    'predmet' => $predmet,
                    'nazev' => $nazev,
                    'den' => $den,
                    'cas' => $cas,
                    'delka' => $delka,
                    'typ' => $typ,
                    'mistnost' => $mistnost,
                    'vyucujici' => $vyucujici,
                    'pozadavek' => $pozadavek

                );
                $data[] = $row;
            }

            $stmt->close();
            mysqli_close($db);

            $resp = array(
                'activities' => $data,
                'resCode' => (count($data) > 0) ? '0' : '1'
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getYear() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];

            $query = "SELECT rocnik FROM Users WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $user_Id);
            $stmt->execute();   
            $stmt->bind_result($rocnik);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'rocnik' => $rocnik
                );
                $data[] = $row;
            }

            $stmt->close();
            mysqli_close($db);

            $resp = array(
                'data' => $data,
                'resCode' => (count($data) > 0) ? '0' : '1'
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xvorob02
         */
        function SideBarLook() {
            $resCode = '0';
            $data = GetSideBarLook();
            $resp = array(
                'resCode' => $resCode,
                'SideBarLook' => $data
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getToEditActivity() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if (isset($_POST['id'])) {
                $id = $_POST['id'];
            }

            $query = "SELECT * FROM aktivity WHERE id_aktivity = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();   
            $stmt->bind_result($id, $predmet, $nazev, $den, $cas, $delka, $typ, $mistnost, $vyucujici, $pozadavek);

            $data = array();
            $num_row = 0;
            while ($stmt->fetch()) {
                $row = array(
                    'id' => $id,
                    'predmet' => $predmet,
                    'nazev' => $nazev,
                    'den' => $den,
                    'cas' => $cas,
                    'delka' => $delka,
                    'typ' => $typ,
                    'mistnost' => $mistnost,
                    'vyucujici' => $vyucujici,
                    'pozadavek' => $pozadavek

                );
                $data[] = $row;
                $num_row++;
            }

            $stmt->close();
            mysqli_close($db);

            $resp = array(
                'data' => $data,
                'resCode' => ($num_row > 0) ? '0' : '1'
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function editActivity() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST["id"];
                $den = $_POST['den'];
                $cas = $_POST['cas'];
                $vyucujici = $_POST['vyucujici'];
                $mistnost = $_POST['mistnost'];
            //}
            $query = "UPDATE aktivity SET den = ?, cas = ?, vyucujici = ?, mistnost = ? WHERE id_aktivity = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssss", $den, $cas, $vyucujici, $mistnost, $id);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function updateColors() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $barva = $_POST['barva'];
            }

            $id = $_SESSION['user'];
            $query = "UPDATE Users SET barva = ? WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ss", $barva, $id);
            $result = $stmt->execute();

            if ($result) 
            {
                $resp = array('resCode' => '0');
                $_SESSION['barva'] = $barva;
            }
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp); 
        }
        /**
         * @author xbabus01
         */
        function addOwnActivty() {
            $predmet = $_POST['predmet'];
            $nazev = $_POST['nazev'];
            $den = $_POST['den'];
            $cas = $_POST['cas'];
            $delka = strval($_POST['delka']);
            $typ = strval($_POST['typ']);

            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            //find out what number will the id have
            $query = "SELECT id_aktivity FROM aktivity ORDER BY id_aktivity DESC LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($id_aktivity);   
            
            $stmt->fetch();

            $number = $id_aktivity + 1;
            
            $stmt->close();
            
            $query2 = "INSERT INTO aktivity (id_aktivity, predmet, nazev, den, cas, delka, typ, mistnost, vyucujici, pozadavek)
            VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL, NULL)";
            
            $stmt2 = $db->prepare($query2);
            $stmt2->bind_param("sssssss", $number, $predmet, $nazev, $den, $cas, $delka, $typ);
            $result = $stmt2->execute();

            $stmt2->close();

            $user_Id = $_SESSION['user'];

            $query3 = "INSERT INTO `prihlasen` (`osobni_cislo`, `id_aktivity`) VALUES (?, ?)";
            $stmt3 = $db->prepare($query3);
            $stmt3->bind_param("ss", $user_Id, $number);
            $result = $stmt3->execute();

            mysqli_close($db);

            $result = 1;
            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function deleteActivity(){
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_SESSION['user'];
            $act_id = $_POST['id'];

            $query = "DELETE FROM prihlasen WHERE osobni_cislo = ? and id_aktivity = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ss", $user_Id, $act_id);
            $result = $stmt->execute();

            if ($result) $resp = array('resCode' => '0');
            else $resp = array('resCode' => '1');

            $stmt->close();
            mysqli_close($db);

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function otherProfileDetails() {
            $db = mysqli_init();
            if (!mysqli_real_connect($db, 'localhost', 'xvorob02', 'a7tujzom', 'xvorob02', 0, '/var/run/mysql/mysql.sock')) {
                die('Cannot connect: ' . mysqli_connect_error());
            }

            $user_Id = $_POST['user_id'];

            $query = "SELECT name, surname, email, rok_narozeni, tel, prava, pozadavky FROM Users WHERE osobni_cislo = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $user_Id);
            $stmt->execute();   
            $stmt->bind_result($name, $surname, $email, $rok_narozeni, $tel, $prava, $requirements);

            $data = array();
            while ($stmt->fetch()) {
                $row = array(
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'rok_narozeni' => $rok_narozeni,
                    'tel' => $tel,
                    'prava' => $prava,
                    'requirements' => $requirements,
                );
                $data[] = $row;
            }

            $data['SideBarLook'] = GetSideBarLook();

            $stmt->close();
            mysqli_close($db);

            $resp = array(
                'data' => $data,
                'resCode' => (count($data) > 0) ? 0 : 1
            );

            header("Content-Type: application/json");
            echo json_encode($resp);
        }
        /**
         * @author xbabus01
         */
        function getOtherPersonalRequirements() {
                $requirementsString ='';
                $table = array();
                $timeBlockYes = array('value' => true, 'day' => false);
                $timeBlockNo = array('value' => false, 'day' => false);
                $days = array('PO','UT','ST','CT','PA');
                if($_POST['requirements'] != NULL){
                    $requirementsString = $_POST['requirements'];
                }
                else{
                    for ($x = 0; $x < 5*14; $x++) {
                        $requirementsString = $requirementsString . '1';
                    }
                }
    
                $splited = str_split($requirementsString);
    
                for ($x = 0; $x < 5; $x++) {
                    $table[$x] = array();
                    $day = array('value' => $days[$x], 'day' => true);
                    array_push($table[$x], $day);
                    for ($y = 0; $y < 14; $y++) {
                        if($splited[$x*14 + $y] == '0'){
                            array_push($table[$x], $timeBlockNo);
                        }
                        else{
                            array_push($table[$x], $timeBlockYes);
                        }
                    }
                }
                
                $data = GetSideBarLook();
    
                $resp = array(
                    'resCode' => 0,
                    'SideBarLook' => $data,
                    'table' => $table
                );
    
                header("Content-Type: application/json");
                echo json_encode($resp);
        }
    ?>