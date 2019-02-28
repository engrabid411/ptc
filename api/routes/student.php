<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	// Get single Student
	$app->get('/student/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM Students WHERE student_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $customer = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($customer);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});

	// Get All students
	$app->get('/students', function(Request $request, Response $response){
		$sql = "SELECT * FROM Students";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $customer = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($customer);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});

	

	// Add Student
	$app->post('/student/add', function(Request $request, Response $response){
		$parent_id = $request->getParam('user_id');
	    $name = $request->getParam('name');
	    $phone = $request->getParam('phone');
	    $address = $request->getParam('address');

	    
	    $sql = "INSERT INTO Students (parent_id,name, phone, address) VALUES
	    (:parent_id, :name, :phone, :address)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':parent_id', $parent_id);
	        $stmt->bindParam(':name', $name);
	        $stmt->bindParam(':phone', $phone);
	        $stmt->bindParam(':address', $address);
	        $stmt->execute();
	        echo '{"notice": {"text": "Student Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update student
	$app->put('/student/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	   	$parent_id = $request->getParam('user_id');
	    $name = $request->getParam('name');
	    $phone = $request->getParam('phone');
	    $address = $request->getParam('address');
	    $sql = "UPDATE Students SET
	    			parent_id = :parent_id,
					name = :name,
					phone = :phone,
					address = :address
				WHERE student_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $parent_id = $request->getParam('parent_id');
	    	$name = $request->getParam('name');
	    	$phone = $request->getParam('phone');
	    	$address = $request->getParam('address');
	        $stmt->execute();
	        echo '{"notice": {"text": "Student Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete Student
	$app->delete('/student/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM Students WHERE student_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "Student Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});