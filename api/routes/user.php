<?php
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	//use \Firebase\JWT\JWT;
	
	// Get single user
	$app->get('/user/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "SELECT * FROM Users WHERE user_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $user = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($user);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});

	// Get All Users
	$app->get('/user', function(Request $request, Response $response){
		$sql = "SELECT * FROM Users";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	        $users = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        echo json_encode($users);
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});



	// Login
	$app->post('/user/login', function(Request $request, Response $response){
		$username = $request->getParam('username');
	    $password = $request->getParam('password');
	    $role_id = $request->getParam('role_id');

		$hash = password_hash($password, PASSWORD_DEFAULT);

	    $sql = "SELECT * FROM Users WHERE username = '$username' AND role_id = $role_id LIMIT 1";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->query($sql);
	       	$user = $stmt->fetch(PDO::FETCH_OBJ);
	        $db = null;
	        if (password_verify($password, $user->password)) {
			     echo json_encode([ "status"=>true, "data"=>[ 
			     	"user_id" => $user->user_id,
			     	"username" => $user->username,
			     	"role_id" => $user->role_id,
			     ]]);
			}else{
				echo json_encode(["status" => false, "data"=>[] ]);
			}
	       

	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});

	// Add User
	$app->post('/user/add', function(Request $request, Response $response){
		$role_id = $request->getParam('role_id');
	    $name = $request->getParam('name');
	    $phone = $request->getParam('phone');
	    $username = $request->getParam('username');
	    $pass = $request->getParam('password');

		$password = password_hash($pass, PASSWORD_DEFAULT);



	    $sql = "INSERT INTO Users (role_id, name, phone, username, password) VALUES
	    (:role_id, :name, :phone, :username, :password)";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':role_id', $role_id);
	        $stmt->bindParam(':name', $name);
	        $stmt->bindParam(':phone', $phone);
	        $stmt->bindParam(':username', $username);
	        $stmt->bindParam(':password', $password);
	        $stmt->execute();
	        echo '{"notice": {"text": "User Added"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Update User
	$app->put('/user/update/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');

	   	$role_id = $request->getParam('role_id');
	    $name = $request->getParam('name');
	    $phone = $request->getParam('phone');
	    $username = $request->getParam('username');
	    $password = $request->getParam('password');

	    $sql = "UPDATE Users SET
	    			role_id = :role_id,
					name = :name,
					phone = :phone,
					username = :username,
					password = :password
				WHERE user_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->bindParam(':role_id', $role_id);
	        $stmt->bindParam(':name', $name);
	        $stmt->bindParam(':phone', $phone);
	        $stmt->bindParam(':username', $username);
	        $stmt->bindParam(':password', $password);
	        $stmt->execute();
	        echo '{"notice": {"text": "User Updated"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});
	// Delete User
	$app->delete('/user/delete/{id}', function(Request $request, Response $response){
	    $id = $request->getAttribute('id');
	    $sql = "DELETE FROM Users WHERE user_id = $id";
	    try{
	        // Get DB Object
	        $db = new db();
	        // Connect
	        $db = $db->connect();
	        $stmt = $db->prepare($sql);
	        $stmt->execute();
	        $db = null;
	        echo '{"notice": {"text": "User Deleted"}';
	    } catch(PDOException $e){
	        echo '{"error": {"text": '.$e->getMessage().'}';
	    }
	});