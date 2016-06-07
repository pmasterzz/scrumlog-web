<?php
/**
 * Created by PhpStorm.
 * User: pepijn
 * Date: 14-4-2016
 * Time: 12:51
 */

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/scrumlog-web/api/db_config.php";
//$path .= "/api/db_config.php";
include_once($path);

function login($username, $password)
{
    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, p.Person_ID, p.Password,'
        . ' s.Student_ID, s.Class, s.Seating, s.Phase, t.Teacher_ID, s.Last_Submitted_Scrumlog '
        . 'FROM person p '
        . 'LEFT JOIN student s ON p.Person_ID = s.Person_ID '
        . 'LEFT JOIN teacher t ON p.Person_ID = t.Person_ID '
        . 'WHERE Username = ?';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $person = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $person['Password'])) {

            $token = uniqid();
            $sql = 'UPDATE person SET Token = ? WHERE Person_ID = ?';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(1, $token);
            $stmt->bindParam(2, $person['Person_ID']);
            $stmt->execute();
            //echo json_encode($person);
            if ($person['Student_ID'] != NULL) {
                $latest_scrum = getLatestScrum($person['Student_ID']);

                $student = array(
                    'User' => array(
                        'Firstname' => $person['Firstname'],
                        'Lastname' => $person['Lastname'],
                        'Infix' => $person['Infix'],
                        'Person_ID' => $person['Person_ID'],
                        'Student_ID' => $person['Student_ID'],
                        'Class' => $person['Class'],
                        'Seating' => $person['Seating'],
                        'Last_Submitted_Scrumlog' => $latest_scrum['Date']
                    ),
                    'Token' => $token,
                    'Userlevel' => 'Student'
                );
                return $student;
            } else {
                $teacher = array(
                    'User' => array(
                        'Firstname' => $person['Firstname'],
                        'Lastname' => $person['Lastname'],
                        'Infix' => $person['Infix'],
                        'Person_ID' => $person['Person_ID'],
                        'Teacher_ID' => $person['Teacher_ID']
                    ),
                    'Success' => TRUE,
                    'Token' => $token,
                    'Userlevel' => 'Teacher'
                );
                return $teacher;
            }
        } else
            return false;
    } else
        return false;
}

;

function getScrumlog($date, $year, $student_ID, $seating, $cycle_ID)
{
    $filterArray = array($date);

    $sql = "SELECT sc.Input_Yesterday, sc.Input_Help, sc.Input_Today, sc.Input_Problems, sc.Radio_Help, sc.Remark,";
    $sql .= " sc.Scrumlog_ID, sc.Date, sc.Cycle_ID, sc.Seating, st.Student_ID, p.Firstname, p.Lastname, p.Infix";
    $sql .= " FROM scrumlog sc LEFT JOIN student st ON sc.Student_ID=st.Student_ID";
    $sql .= " LEFT JOIN person p ON st.Person_ID=p.Person_ID";
    $sql .= " WHERE sc.Date = ?";


    if ($year !== 'undefined') {
        $sql .= " " . "AND st.Start_Year = ?";
        array_push($filterArray, $year);
    }
    if ($student_ID !== 'undefined') {
        $sql .= " " . "AND sc.Student_ID = ?";
        array_push($filterArray, $student_ID);
    }
    if ($seating !== 'undefined') {
        $sql .= " " . "AND sc.Seating = ?";
        array_push($filterArray, $seating);
    }

    if ($cycle_ID !== 'undefined' && $cycle_ID !== 'null') {
        $sql .= " " . "AND sc.Cycle_ID = ?";
        array_push($filterArray, $cycle_ID);
    }
    $db = getDB();
    $stmt = $db->prepare($sql);
    foreach ($filterArray as $k => $v) {
        $stmt->bindValue(($k + 1), $v);
    }
    $stmt->execute();


    if ($stmt->rowCount() == 0) {
        return false;
    } else {
        $scrumlog = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //  foreach ($scrumlog as $s) {

        //     if($s['Radio_Help'] !== '-')
        //         $s['Radio_Help'] = GetTeacherNameById($s['Radio_Help']);
        //     var_dump($s);
        //  }

        for ($i = 0; $i < sizeof($scrumlog); $i++) {
            if ($scrumlog[$i]['Radio_Help'] !== '-')
                $scrumlog[$i]['Radio_Help'] = GetTeacherNameById($scrumlog[$i]['Radio_Help']);
        }

        return $scrumlog;
    }
}

;

function getAllTables($seating)
{

}

;

function submitScrumlog($input_Yesterday, $input_Problems, $input_Today, $input_Help, $radio_Help, $student_ID, $seating)
{
    $cycle = getCurrentCycle();

    if ($radio_Help === 0) {
        $radio_Help = NULL;
    }

    $sql = 'INSERT INTO scrumlog '
        . '(Input_Yesterday, Input_Problems, Input_Today, Input_Help'
        . ', Radio_Help, Cycle_ID, Date, Student_ID, Seating)'
        . ' VALUES(?, ?, ?, ?, ?, ?, CURDATE(), ?, ?)';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $input_Yesterday);
    $stmt->bindParam(2, $input_Problems);
    $stmt->bindParam(3, $input_Today);
    $stmt->bindParam(4, $input_Help);
    $stmt->bindParam(5, $radio_Help);
    $stmt->bindParam(6, $cycle);
    $stmt->bindParam(7, $student_ID);
    $stmt->bindParam(8, $seating);
    $stmt->execute();
    return;
}

;

function addCycle($start_Date, $end_Date, $description)
{
    $sql = 'INSERT INTO cycle (Start_Date, End_Date, Description) VALUES(?, ?, ?)';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $start_Date);
    $stmt->bindParam(2, $end_Date);
    $stmt->bindParam(3, $description);
    try {
        $stmt->execute();
        return;
    } catch (PDOException $e) {
        die($e);
    }
}

;


// <<<<<<< HEAD
function setTable($students, $seat)
{
    $studentArray = implode(",", $students);

    $db = getDB();
    $sql = 'UPDATE student SET Seating = ? WHERE Student_ID IN(' . $studentArray . ')';


// =======
// function setTable($students, $seat){
//     $studentArray = explode(",", $students);
//         $inQuery = implode(',', array_fill(0, count($studentArray), '?'));
//         $db = getDB();
//         $sql = 'UPDATE student SET Seating = ? WHERE Student_ID IN(' . $inQuery . ')';
// >>>>>>> master
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $seat);

    foreach ($studentArray as $k => $id) {
        $stmt->bindValue(($k + 2), $id);
    };

    $stmt->execute();
    return;
}

;

function updateTable($students)
{
    $studentArray = implode(",", $students);

    // $inQuery = $studentArray;
    // var_dump($inQuery);

    $db = getDB();
    $sql = 'UPDATE student SET Seating = 0 WHERE Student_ID IN(' . $studentArray . ')';
    $stmt = $db->prepare($sql);


    $stmt->execute();
    return;
}

;

function clearTables()
{
    $sql = 'UPDATE student SET Seating=0';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return;
}

;

function getAllTeachers()
{
    $sql = 'SELECT person.Firstname, person.Infix, person.Lastname, teacher.Teacher_ID '
        . 'FROM person '
        . 'LEFT JOIN teacher '
        . 'ON person.Person_ID=teacher.Person_ID '
        . 'WHERE teacher.Teacher_ID > 0';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $teacher;
}

;

function getAllStudents()
{
    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID'
        . ' FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
}

;

function getAllCycles()
{
    $sql = "SELECT Cycle_ID, Start_Date, End_Date, Description FROM cycle ORDER BY Cycle_ID";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $cycles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $cycles;
}

;

function getAllAvailableStudents($table)
{
    $sql = "SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID, s.Seating";
    $sql .= " FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID";
    $sql .= " WHERE s.Seating = 0 OR s.Seating = ?";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $table);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $students;
}

;

function getSpecificTable($seat)
{
    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID'
        . ' FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID '
        . 'WHERE s.Seating=?';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $seat);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
}

;


function getEmptyTable()
{
    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID'
        . ' FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID '
        . 'WHERE s.Seating=0';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $students;
}

;

function deleteCycle($cycle_ID)
{

    $assignment = checkCycleUses($cycle_ID);


    if (!$assignment) {
        $sql = "DELETE FROM cycle WHERE Cycle_ID = ?";
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $cycle_ID);
        $stmt->execute();
        return true;
    } else {
        return false;
    }
}

;

function setTableToZero($table)
{
    $sql = "UPDATE student SET Seating=0 WHERE Seating=?";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $table);
    $stmt->execute();
    return;
}

function updateCycle($description, $start, $end, $id)
{
    $sql = "UPDATE cycle SET Description=?, Start_Date=?, End_Date=? WHERE cycle_ID=?";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $description);
    $stmt->bindValue(2, $start);
    $stmt->bindValue(3, $end);
    $stmt->bindValue(4, $id);
    $stmt->execute();
    return;
}

;

function submitComment($text, $teacher_ID, $scrumlog_ID)
{
    $sql = "UPDATE scrumlog set Teacher_ID=?, Remark=?, Completed=FALSE WHERE Scrumlog_ID=?";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $teacher_ID);
    $stmt->bindValue(2, $text);
    $stmt->bindValue(3, $scrumlog_ID);
    $stmt->execute();
    return;
}

;

function getAllTodos($teacher_ID)
{
    $sql = "SELECT sc.Remark, sc.Teacher_ID, sc.Completed, p.Firstname, p.Lastname, p.Infix, sc.Scrumlog_ID, sc.Input_Help ";
    $sql .= "FROM scrumlog sc LEFT JOIN student st ON sc.Student_ID=st.Student_ID ";
    $sql .= "LEFT JOIN person p ON st.Person_ID=p.Person_ID ";
    $sql .= "WHERE (sc.Teacher_ID=:id OR sc.Radio_Help=:id) AND sc.Date=CURDATE()";

    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $teacher_ID);
    //$stmt->bindValue(1, $teacher_ID);
    $stmt->execute();
    //random comment
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $comments;
}

;

function completeTodo($id, $comment)
{
    $sql = "UPDATE scrumlog SET Completed=TRUE, Remark=? WHERE Scrumlog_ID=?";
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $comment);
    $stmt->bindValue(2, $id);
    $stmt->execute();
    return;
}

;


function checkCycleUses($id)
{
    $sql = "SELECT Assignment_ID FROM assignment WHERE Cycle_ID=?";
    $sql2 = "SELECT Scrumlog_ID FROM scrumlog WHERE Cycle_ID=?";
    $db = getDB();
    $db->beginTransaction();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(1, $id);
    $stmt2->execute();
    if ($stmt->rowCount() > 0 || $stmt2->rowCount() > 0) {
        return true;
    } else {
        return false;
    };
    $db->rollBack();

}

;
function getLatestScrum($student_ID)
{
    $sql = 'SELECT Date From Scrumlog Where Student_ID=? ORDER BY Date DESC';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $student_ID);
    $stmt->execute();
    $scrumlogs = $stmt->fetch(PDO::FETCH_ASSOC);
    return $scrumlogs;
}

;

function GetTeacherNameById($id)
{
    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname '
        . 'FROM person p LEFT JOIN teacher t ON p.Person_ID=t.Person_ID '
        . 'WHERE t.Teacher_ID=?';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $name = $teacher[0]['Firstname'];
    if ($teacher[0]['Infix'] !== NULL)
        $name .= ' ' . $teacher[0]['Infix'];
    $name .= ' ' . $teacher[0]['Lastname'];

    return $name;
}

function getCurrentCycle()
{


    $sql = 'SELECT Cycle_ID FROM cycle WHERE CURDATE() >= Start_Date AND CURDATE() <= End_Date';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $cycle = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response = $cycle[0]['Cycle_ID'];
    return $response;
}

function getLatestScrumlogs($id)
{
    $sql = "SELECT sc.Input_Yesterday, sc.Input_Help, sc.Input_Today, sc.Input_Problems, sc.Radio_Help,";
    $sql .= " sc.Scrumlog_ID, sc.Date, sc.Cycle_ID, sc.Seating, st.Student_ID, p.Firstname, p.Lastname, p.Infix";
    $sql .= " FROM scrumlog sc LEFT JOIN student st ON sc.Student_ID=st.Student_ID";
    $sql .= " LEFT JOIN person p ON st.Person_ID=p.Person_ID";
    $sql .= " WHERE sc.Student_ID=?";
    $sql .= " ORDER BY sc.Date DESC LIMIT 5";

    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $scrumlogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < sizeof($scrumlogs); $i++) {
        if ($scrumlogs[$i]['Radio_Help'] !== '-')
            $scrumlogs[$i]['Radio_Help'] = GetTeacherNameById($scrumlogs[$i]['Radio_Help']);
    }

    return $scrumlogs;

}



