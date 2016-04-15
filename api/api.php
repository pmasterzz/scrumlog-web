<?php

    require 'vendor/autoload.php';
    include 'db_config.php';
    include '../php/database.php';

    $app = new \Slim\Slim();
	
	// return HTTP 200 for HTTP OPTIONS requests
	$app->map('/:x+', function($x) {
		http_response_code(200);
	})->via('OPTIONS');

	// Allow from any origin
	if (isset($_SERVER['HTTP_ORIGIN'])) {
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day
	}
	// Access-Control headers are received during OPTIONS requests
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
			header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         
	
		if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
	}
    
        function middleWare() 
    { 
        $app = \Slim\Slim::getInstance();
        $token = $app->request->headers->get('Token');
        $sql = 'SELECT Token From person WHERE Token = ?';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $token);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            
        }
        else
        {
            $app->halt(403);
        }
    }
    
	function getCurrentCycle(){
        $sql = 'SELECT Cycle_ID FROM cycle WHERE CURDATE() > Start_Date AND CURDATE() < End_Date';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $cycle = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = $cycle[0]['Cycle_ID'];
        return $response;
    }
	
	function GetTeacherNameById($id){
		$sql = 'SELECT p.Firstname, p.Infix, p.Lastname '
		. 'FROM person p LEFT JOIN teacher t ON p.Person_ID=t.Person_ID '
		. 'WHERE t.Teacher_ID=?';
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $id);
		$stmt->execute();
		$teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$name = $teacher[0]['Firstname'];
		if($teacher[0]['Infix'] !== NULL)
			$name .= ' ' . $teacher[0]['Infix'];
		$name .= ' ' . $teacher[0]['Lastname'];
		return $name;
	}
	$app->get('/test', function() use ($app){
		echo GetTeacherNameById(1);
	});
	
    // retrieve selected/filtered scrumlogs
    $app->get('/api/scrumlog',  function () use ($app) {
        
        $date = $app->request->params('date');
        $time = strtotime($date);
        $year = $app->request->params('year');
        $student_ID = $app->request->params('student_ID');
        $seating = $app->request->params('seating');
		$cycle_ID = $app->request->params('cycle_ID');
        $filterArray = array($date);

        $sql = "SELECT sc.Input_Yesterday, sc.Input_Help, sc.Input_Today, sc.Input_Problems, sc.Radio_Help,";
		$sql .= " sc.Scrumlog_ID, sc.Date, sc.Cycle_ID, sc.Seating, st.Student_ID, p.Firstname, p.Lastname, p.Infix";
		$sql .= " FROM scrumlog sc LEFT JOIN student st ON sc.Student_ID=st.Student_ID";
		$sql .= " LEFT JOIN person p ON st.Person_ID=p.Person_ID";
		$sql .= " WHERE sc.Date = ?";

		
       
        if($year !== 'undefined')
        {
            $sql .= " " . "AND st.Start_Year = ?";
            array_push($filterArray, $year);
        }
        if($student_ID !== 'undefined')
        {
            $sql .= " " . "AND sc.Student_ID = ?";
            array_push($filterArray, $student_ID);
        }
        if($seating !== 'undefined' && $seating !== 'null')
        {
            $sql .= " " . "AND sc.Seating = ?";
            array_push($filterArray, $seating);
        }

        if($cycle_ID !== 'undefined' && $cycle_ID !== 'null')
        {
            $sql .= " " . "AND sc.Cycle_ID = ?";
            array_push($filterArray, $cycle_ID);
        }
        
		$db = getDB();
        $stmt = $db->prepare($sql);
		foreach ($filterArray as $k => $v)
        {
           $stmt->bindValue(($k+1), $v); 
        }  
		$stmt->execute();
		if($stmt->rowCount() == 0){
			$res = array(
               'Success' => FALSE
           );
		$response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($res));
        return $response;
		}
		
		else{
        $scrumlog = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($scrumlog[0]['Radio_Help'] !== '-')
			$scrumlog[0]['Radio_Help'] = GetTeacherNameById($scrumlog[0]['Radio_Help']);
	
		$response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($scrumlog));
        return $response;
		}
    });

    //retrieve all tables 
    $app->get('/api/tables','middleWare',function() use ($app){
        $sql = 'SELECT person.Firstname, person.Infix , person.Lastname, student.Seating '
            . 'FROM student '
            . 'LEFT JOIN person '
            . 'ON student.Person_ID=person.Person_ID '
            . 'WHERE Seating != 0';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $seating = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($seating as $seat)
        {
            echo $seat['Firstname'] . ' ' .$seat['Infix'] . ' ' . $seat['Lastname'] . ' ' . $seat['Seating'] . '<br>';
        }
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($seating));
        return $response;// i think dinky donky app 
    });
    //retrieves all filtered tables
    $app->get('/api/table','middleWare',function() use ($app){
        $seat = $app->request()->get('Seating');
        $sql = 'SELECT person.Firstname , person.Lastname, student.Seating '
            . 'FROM student '
            . 'LEFT JOIN person '
            . 'ON person.Person_ID=student.Person_ID '
            . 'WHERE Seating = ?'
            . 'SORT BY person.Lastname';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $seat);
        $stmt->execute();
        $seating = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($seating as $seat)
        {
            echo $seat['Firstname'] . ' ' . $seat['Lastname'] . ' ' . $seat['Seating'] . '<br/>';
        }
    });
    //adds new scrumlog
    $app->post('/api/submitScrumlog',function() use ($app){
        $input_Yesterday = $app->request->params('input_Yesterday');
        $input_Problems = $app->request->params('input_Problems');
        $input_Today = $app->request->params('input_Today');
        $input_Help = $app->request->params('input_Help');
        $radio_Help = $app->request->params('input_Teacher');
        $student_ID = $app->request->params('student_ID');
        $seating = $app->request->params('seating');
        $cycle = getCurrentCycle();
        
        if($radio_Help === 0){
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
    });
    //adds new cycle
    $app->post('/api/cycle','middleWare',function() use ($app){
        $start_Date = $app->request->params('Start_Date');
        $end_Date = $app->request->params('End_Date');
        $number = $app->request->params('Number');
        $sql = 'INSERT INTO cycle (Start_Date, End_Date, Number) VALUES(?, ?, ?)';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $start_Date);
        $stmt->bindParam(2, $end_Date);
        $stmt->bindParam(3, $number);
        $stmt->execute();
    });
    //adjust table seatings
    $app->post('/api/table', 'middleWare',function() use ($app){
	
        $students = $app->request->params('studentArray');
		$studentArray = explode(",", $students);
        $inQuery = implode(',', array_fill(0, count($studentArray), '?'));
        $db = getDB();
        $seat = $app->request->params('seating');
        $sql = 'UPDATE student SET Seating = ? WHERE Student_ID IN(' . $inQuery . ')';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $seat);
		
        foreach($studentArray as $k => $id)
            {
                $stmt->bindValue(($k+2), $id);
            };

        $stmt->execute();
    });
    //clear all tables
    $app->put('/api/cleanTables','middleWare',function(){

        $sql = 'UPDATE student SET Seating=0';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();  
    });
    //Log in
    $app->post('/api/login', function() use($app){
    $username = $app->request->params('username');
    $password = $app->request->params('password');

    $login = login($username, $password);

    if($login === false)
    {
        $response = $app->response();
        $app->response->setStatus(401);
        return $response;
    }
    else
    {
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($login));
        return $response;  
    }


//    $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, p.Person_ID, p.Password,'
//			.' s.Student_ID, s.Class, s.Seating, s.Phase, t.Teacher_ID, s.Last_Submitted_Scrumlog '
//			. 'FROM person p '
//            . 'LEFT JOIN student s ON p.Person_ID = s.Person_ID '
//            . 'LEFT JOIN teacher t ON p.Person_ID = t.Person_ID '
//            . 'WHERE Username = ?';
//    $db = getDB();
//    $stmt = $db->prepare($sql);
//    $stmt->bindParam(1, $username);
//    $stmt->execute();
//    if ($stmt->rowCount() == 1)
//    {
//        $person = $stmt->fetch(PDO::FETCH_ASSOC);
//
//    if (password_verify($password, $person['Password']))
//        {
//
//            $token = uniqid();
//            $sql = 'UPDATE person SET Token = ? WHERE Person_ID = ?';
//            $stmt = $db->prepare($sql);
//            $stmt->bindParam(1, $token);
//            $stmt->bindParam(2, $person['Person_ID']);
//            $stmt->execute();
//            //echo json_encode($person);
//            if ($person['Student_ID'] != NULL)
//                {
//                    $latest_scrum = getLatestScrum($person['Student_ID']);
//
//                    $student = array(
//                        'User' => array(
//                                'Firstname' => $person['Firstname'],
//                                'Lastname' => $person['Lastname'],
//                                'Infix' => $person['Infix'],
//                                'Person_ID' => $person['Person_ID'],
//                                'Student_ID' => $person['Student_ID'],
//                                'Class' => $person['Class'],
//                                'Seating' => $person['Seating'],
//                                'Last_Submitted_Scrumlog' => $latest_scrum['Date']
//                        ),
//                        'Token' => $token,
//                        'Userlevel' => 'Student'
//					);
//                    $response = $app->response();
//                    $response['Content-Type'] = 'application/json';
//                    $response->body(json_encode($student));
//
//
//                    return $response; // i think dinky donky
//                }
//            else
//                {
//                    $teacher = array(
//					'User' => array(
//						'Firstname' => $person['Firstname'],
//						'Lastname' => $person['Lastname'],
//						'Infix' => $person['Infix'],
//						'Person_ID' => $person['Person_ID'],
//						'Teacher_ID' => $person['Teacher_ID']
//					),
//                    'Success' => TRUE,
//                    'Token' => $token,
//					'Userlevel' => 'Teacher'
//                    );
//                    $response = $app->response();
//                    $response['Content-Type'] = 'application/json';
//                    $response->body(json_encode($teacher));
//                    return $response;
//
//
//                }
//        }
//        else
//        {
//           $app->response->setStatus(401);
//            //return $response;// i think dinky donky app
//        }
//    }
//    else
//    {
//        $app->response->setStatus(401);
//         //return $response;// i think dinky donky app
//    }

    });
    $app->post('/api/logout',function() use ($app){
        $sql = 'UPDATE person SET Token = NULL WHERE Person_ID = ?';
        $person_ID = $app->request->params('Person_ID');
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $person_ID);
        $stmt->execute();
    });
    
    $app->get('/api/getAllTeachers','middleWare',  function() use ($app){
        $sql = 'SELECT person.Firstname, person.Infix, person.Lastname, teacher.Teacher_ID '
                . 'FROM person '
                . 'LEFT JOIN teacher '
                . 'ON person.Person_ID=teacher.Person_ID '
                . 'WHERE teacher.Teacher_ID > 0';
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $teacher = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($teacher));
        return $response; 
        
    });
	
	$app->get('/api/checkToken', function() use ($app){
            $token = $app->request->params('token');
            $sql = 'SELECT p.Firstname, p.Infix, p.Lastname, p.Person_ID, '
                .'s.Student_ID, s.Class, s.Seating, s.Phase, t.Teacher_ID, s.Last_Submitted_Scrumlog '
                . 'FROM person p '
                . 'LEFT JOIN student s ON p.Person_ID = s.Person_ID '
                . 'LEFT JOIN teacher t ON p.Person_ID = t.Person_ID '
                . 'WHERE Token = ?';
            $db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $token);
            $stmt->execute();

            if($stmt->rowCount() === 1)
            {
                $person = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($person['Student_ID'] != NULL)
                {   
                    
                    $student = array(
                        'User' => array(
                                'Firstname' => $person['Firstname'],
                                'Lastname' => $person['Lastname'],
                                'Infix' => $person['Infix'],
                                'Person_ID' => $person['Person_ID'],
                                'Student_ID' => $person['Student_ID'],
                                'Class' => $person['Class'],
                                'Seating' => $person['Seating'],   
                                'Last_Submitted_Scrumlog' => $person['Last_Submitted_Scrumlog']
                        ),
                        'Userlevel' => 'Student',
                        'Success' => TRUE
                    );
                    $response = $app->response();                    
                    $response['Content-Type'] = 'application/json';
                    $response->body(json_encode($student));
                    return $response;
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
                        'Userlevel' => 'Teacher'
                    );
                    $response = $app->response();                    
                    $response['Content-Type'] = 'application/json';
                    $response->body(json_encode($teacher));
                    return $response;
                    }
            }
            else{
                $res = array(
                    'Success'=> FALSE
                );
                $response = $app->response();
                $response['Content-Type'] = 'application/json';
                $response->body(json_encode($res));
                return $response; 
            }
	});
    
	$app->get('/api/getAllStudents','middleWare' ,function() use ($app){
		$sql = 'SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID'
		.' FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID';
		$db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->execute();
			$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		$response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($students));
        return $response; 
	});
    
	$app->get('/api/getAllCycles', 'middleWare', function() use ($app){
		$sql = "SELECT Cycle_ID, Start_Date, End_Date, Number FROM cycle";
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$cycles = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
		$response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($cycles));
        return $response;
	});
	
	$app->get('/api/getAllAvailableStudents', 'middleWare', function() use ($app){
	
		$table = $app->request->params('table');
		$sql = "SELECT p.Firstname, p.Infix, p.Lastname, s.Student_ID, s.Seating";
		$sql .= " FROM student s LEFT JOIN person p ON s.Person_ID=p.Person_ID";
		$sql .= " WHERE s.Seating = 0 OR s.Seating = ?";
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(1, $table);
		$stmt->execute();
		$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($students));
        return $response;
	});

    $app->post('/api/deleteCycle', 'middleWare', function() use ($app){
        $cycle_ID = $app->request->params('cycle_ID');

        $assignment = checkCycleUses($cycle_ID);

        if(!$assignment){
            $sql = "DELETE FROM cycle WHERE Cycle_ID = ?";
            $db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $cycle_ID);
            $stmt->execute();
            $res = array('Success' => TRUE);
            $response = $app->response();
            $response['Content-Type'] = 'application/json';
            $response->body(json_encode($res));
            return $response;
        }
      else{
            $res = array('Success' => FALSE);
            $response = $app->response();
            $response['Content-Type'] = 'application/json';
            $response->body(json_encode($res));
            return $response;
        };
    });
	
	$app->post('/api/updateCycle', 'middleWare', function() use ($app){
        $number = $app->request->params('Number');
        $start = $app->request->params('Start_Date');
        $end = $app->request->params('End_Date');
        $id = $app->request->params('Cycle_ID');

        $sql = "UPDATE cycle SET Number=?, Start_Date=?, End_Date=? WHERE cycle_ID=?";

        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $number);
        $stmt->bindValue(2, $start);
        $stmt->bindValue(3, $end);
        $stmt->bindValue(4, $id);
        $stmt->execute();

        $res = array("Success" => TRUE);
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($res));
        return $response;

        
    });

    $app->post('/api/submitComment', 'middleWare', function() use ($app){
        $text = $app->request->params('text');
        $teacher_ID = $app->request->params('teacher');
        $scrumlog_ID = $app->request->params('scrumlog');

        $sql = "UPDATE scrumlog set Teacher_ID=?, Remark=?, Completed=FALSE WHERE Scrumlog_ID=?";

        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $teacher_ID);
        $stmt->bindValue(2, $text);
        $stmt->bindValue(3, $scrumlog_ID);
        $stmt->execute();
    });

    $app->get('/api/getAllTodos', function() use ($app){
        $teacher_ID = $app->request->params('teacher_ID');

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
        
        $response = $app->response();
        $response['Content-Type'] = 'application/json';
        $response->body(json_encode($comments));
        return $response;
    });
    
    $app->put('/api/completeTodo', function() use ($app){
        $id = $app->request->params('scrumlog_ID');
        $comment = $app->request->params('comment');
        $sql = "UPDATE scrumlog SET Completed=TRUE, Remark=? WHERE Scrumlog_ID=?";
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $comment);
        $stmt->bindValue(2, $id);
        $stmt->execute(); 
    });
	$app->run();
    
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
        if ($stmt->rowCount() > 0 || $stmt2->rowCount() > 0) 
        {
            return true;
        }
        else
        {
            return false;
        };
        $db->rollBack();

    };
    ?>
