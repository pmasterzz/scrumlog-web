<?php
/**
 * Created by PhpStorm.
 * User: pepijn
 * Date: 14-4-2016
 * Time: 12:51
 */

include '../api/db_config.php';

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
            }
        else
            {
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
        }
        else
            return false;
    }
    else
        return false;
};

function getLatestScrum($student_ID)
{
    $sql = 'SELECT Date From Scrumlog Where Student_ID=? ORDER BY Date DESC';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $student_ID);
    $stmt->execute();
    $scrumlogs = $stmt->fetch(PDO::FETCH_ASSOC);
    return $scrumlogs;
};
