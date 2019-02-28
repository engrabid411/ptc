<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	
	// Get single Class
	$app->get('/class-room/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM ClassRoom WHERE classroom_id = $id";
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

	// Get All classrooms
	$app->get('/class-room', function(Request $request, Response $response){
		$sql = "SELECT * FROM ClassRoom";
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

	

	// Add class-room
	$app->post('/class-room/add', function(Request $request, Response $response){
	    $school_id = $request->getParam('id');
	    $class = $request->getParam('class');
	    $section = $request->getParam('section');

	    
	    $sql = "INSERT INTO ClassRoom (school_id, class, section) VALUES
	    (:school_id, :class, :section)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':school_id', $school_id);
	        $stmt->bindParam(':class', $class);
	        $stmt->bindParam(':section', $section);
	        $stmt->execute();
	        echo '{"notice": {"text": "ClassRoom Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update ClassRoom
	$app->put('/class-room/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');

	   	$school_id = $request->getParam('id');
	    $class = $request->getParam('class');
	    $section = $request->getParam('section');

	    $sql = "UPDATE ClassRoom SET
					school_id = :school_id,
					class = :class,
					section = :section
				WHERE classroom_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);

	        $stmt->bindParam(':school_id', $school_id);
	        $stmt->bindParam(':class', $class);
	        $stmt->bindParam(':section', $section);
	        
	        $stmt->execute();
	        echo '{"notice": {"text": "ClassRoom Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete ClassRoom
	$app->delete('/class-room/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM ClassRoom WHERE classroom_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "ClassRoom Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});