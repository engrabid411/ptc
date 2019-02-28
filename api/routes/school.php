<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	$configuration = [
	    'settings' => [
	        'displayErrorDetails' => true,
	    ],
	];
	$c = new \Slim\Container($configuration);
	$app = new \Slim\App($c);
	

	$app->options('/{routes:.+}', function ($request, $response, $args) {
	    return $response;
	});

	$app->add(function ($req, $res, $next) {
	    $response = $next($req, $res);
	    return $response
	            ->withHeader('Access-Control-Allow-Origin', '*')
	            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
	            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	});
	// Get single school
	$app->get('/school/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM Schools WHERE school_id = $id";
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

	// Get All schools
	$app->get('/schools', function(Request $request, Response $response){
		$sql = "SELECT * FROM Schools";
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

	

	// Add School
	$app->post('/school/add', function(Request $request, Response $response){
	    $name = $request->getParam('name');
	    $address = $request->getParam('address');
	    $contact = $request->getParam('contact');
	    $branch = $request->getParam('branch');
	    
	    $sql = "INSERT INTO Schools (name,address,contact,branch) VALUES
	    (:name,:address,:contact, :branch)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':name', $name);
	        $stmt->bindParam(':address',$address);
	        $stmt->bindParam(':contact',$contact);
	        $stmt->bindParam(':branch',$branch);
	        $stmt->execute();
	        echo '{"notice": {"text": "School Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update School
	$app->put('/school/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $name = $request->getParam('name');
	    $address = $request->getParam('address');
	    $contact = $request->getParam('contact');
	    $branch = $request->getParam('branch');
	    $sql = "UPDATE Schools SET
					name 	= :name,
					address 	= :address,
	                contact		= :contact,
	                branch = :branch
				WHERE school_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':name', $name);
	        $stmt->bindParam(':address',$address);
	        $stmt->bindParam(':contact',$contact);
	        $stmt->bindParam(':branch',$branch);
	        $stmt->execute();
	        echo '{"notice": {"text": "School Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete School
	$app->delete('/school/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM Schools WHERE school_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "School Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});