<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	// Get single subject
	$app->get('/subject/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM Subjects WHERE subject_id = $id";
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

	// Get All subjects
	$app->get('/subjects', function(Request $request, Response $response){
		$sql = "SELECT * FROM Subjects";
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

	

	// Add Subject
	$app->post('/subject/add', function(Request $request, Response $response){
	    $name = $request->getParam('name');
	    
	    $sql = "INSERT INTO Subjects (name) VALUES
	    (:name)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':name', $name);
	        $stmt->execute();
	        echo '{"notice": {"text": "Subject Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update subject
	$app->put('/subject/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $name = $request->getParam('name');
	    $sql = "UPDATE Subjects SET
					name = :name
				WHERE subject_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	         $stmt->bindParam(':name', $name);
	        $stmt->execute();
	        echo '{"notice": {"text": "Subject Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete Subject
	$app->delete('/subject/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM Subjects WHERE subject_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "Subject Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});