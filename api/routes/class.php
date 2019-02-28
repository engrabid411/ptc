<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	// Get single class
	$app->get('/class/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM Classes WHERE class_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $class = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($class);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});


	// select classes by teacher id
	$app->get('/class-by-teacher/{teacher_id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('teacher_id');
	    $sql = "SELECT * FROM Classes LEFT JOIN ClassRoom  ON Classes.classroom_id = ClassRoom.classroom_id  WHERE Classes.teacher_id = $id ";

	    $data = array();
	    $keys = array();
	    try{

	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
		    $stmt->execute();
		    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
	        $db = null;
	        foreach ($rows as $k => $row) {
	        	$main_key = "";
	        	if($row->section == null || $row->section == ""){
	        		
	        		$main_key = str_replace(" ", "-", $row->class);
	        	}else{
	        		$main_key = str_replace(" ", "-", $row->class)."-".$row->section;
	        	}
	        	if(!in_array($main_key, $keys)){
	        		array_push($keys, $main_key);
	        	}
	        	

	        	$db = new db();
	        	$student_id = $row->student_id;
		        $sql = "SELECT * FROM Students  WHERE student_id = $student_id ";
		        $db = $db->connect();
		        $stmt = $db->prepare($sql);
			    $stmt->execute();
			    $student = $stmt->fetch(PDO::FETCH_OBJ);
	        	$db = null;	
	        	$student->subject_id = $row->subject_id;
	        	$student->classroom_id = $row->classroom_id;
	        	if(array_key_exists($main_key, $data)){
	        		array_push($data[$main_key], $student);
	        	}else{
	        		$data[$main_key] = [$student];
	        	}

	        }
	        
	        echo json_encode([ "status"=>true, "keys"=>$keys, "data"=>$data ]);
	    } catch(PDOException $e){
	        echo json_encode([ "status"=>false, "data"=>[] ]);
	    }
	});

	// Get All classes
	$app->get('/class', function(Request $request, Response $response){
		$sql = "SELECT * FROM Classes";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $classes = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($classes);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});

	// Add Class
	$app->post('/class/add', function(Request $request, Response $response){

		$subject_id = $request->getParam('subject_id');
	    $classroom_id = $request->getParam('classroom_id');
	    $teacher_id = $request->getParam('user_id');
	    $student_id = $request->getParam('student_id');


	    $sql = "INSERT INTO Classes ( subject_id, classroom_id, teacher_id, student_id ) VALUES
	    (:subject_id, :classroom_id, :teacher_id, :student_id)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':subject_id', $subject_id);
	        $stmt->bindParam(':classroom_id', $classroom_id);
	        $stmt->bindParam(':teacher_id', $teacher_id);
	        $stmt->bindParam(':student_id', $student_id);
	        $stmt->execute();
	        echo '{"notice": {"text": "Class Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update Class
	$app->put('/class/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');

	   	$subject_id = $request->getParam('subject_id');
	    $classroom_id = $request->getParam('classroom_id');
	    $teacher_id = $request->getParam('user_id');
	    $student_id = $request->getParam('student_id');

	    $sql = "UPDATE Classes SET
	    			subject_id = :subject_id,
					classroom_id = :classroom_id,
					teacher_id = :teacher_id,
					student_id = :student_id
				WHERE class_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':subject_id', $subject_id);
	        $stmt->bindParam(':classroom_id', $classroom_id);
	        $stmt->bindParam(':teacher_id', $teacher_id);
	        $stmt->bindParam(':student_id', $student_id);
	        $stmt->execute();
	        echo '{"notice": {"text": "Class Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete Class
	$app->delete('/class/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM Classes WHERE class_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "Class Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});