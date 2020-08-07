<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require '../vendor/autoload.php';
   
    function message ($code,$status,$message,$type=null,$object=null) {
        if ($object == null) {
            return array("code" => $code, "status" => $status, "message" => $message);
        } else {
            return array("code" => $code, "status" => $status, "message" => $message, $type => $object);
        }        
    }

    $app = new \Slim\App;
    /**
     * route - CREATE - add new neighbour - POST method
	 * Elle permet de sauvegarder un créer un voisin
     */
    $app->post
    (
        '/neighbour', 
        function (Request $request, Response $old_response) {
            try {
                $params = $request->getQueryParams();                
                $name = $params['name'];
                $address = $params['address'];
                $phone = $params['phone'];
				$about = $params['about'];
				//$favorite = $params['favorite'];

                $sql = "insert into neighbours (name,address,phone,about) values (:name,:address,:phone,:about)";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $statement = $db_connection->prepare($sql);                
                $statement->bindParam(':name', $name);
                $statement->bindParam(':address', $address);
                $statement->bindParam(':phone', $phone);
				$statement->bindParam(':about', $about);
				//$statement->bindParam(':favorite', $favorite);
                $statement->execute();
                
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been created successfully.")));
            } catch (Exception $exception) {
                
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    /**
     * route - READ - get neighbour by id - GET method
	 * Elle retourne les informations d'un voisin à partir de son id
     */
    $app->get
    (
        '/neighbour/{id}', 
        function (Request $request, Response $old_response) {
            try {
                $id = $request->getAttribute('id');                

                $sql = "select * from neighbours where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->prepare($sql);
                $statement->execute(array(':id' => $id));
                if ($statement->rowCount()) {
                    $neighbour = $statement->fetch(PDO::FETCH_OBJ);                    
                    $body->write(json_encode(message(200, 'OK', "Process Successed.", "neighbour", $neighbour)));
                }
                else
                {
                    $body->write(json_encode(message(513, 'KO', "The neighbour with id = '".$id."' has not been found or has already been deleted.")));
                }

                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
            
            return $response;
        }
    );

    /**
     * route - READ - get all neighbours - GET method
	 * Elle retourne la liste complète des voisins (favoris ou non)
     */
    $app->get
    (
        '/neighbours', 
        function (Request $request, Response $old_response) {
            try {
                $sql = "Select * From neighbours";
                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();
    
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->query($sql);
                if ($statement->rowCount()) {
                    $neighbours = $statement->fetchAll(PDO::FETCH_OBJ);                    
                    $body->write(json_encode(message(200, 'OK', "Process Successed.", "neighbours", $neighbours)));
                } else {
                    $body->write(json_encode(message(512, 'KO', "No neighbour has been recorded yet.")));
                }

                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
    
            return $response;
        }
    );
	
	/**
     * route - READ - get all favorites neighbours - GET method
	 * Elle retourne la liste des vosins favoris
     */
    $app->get
    (
        '/favoritesNeighbours', 
        function (Request $request, Response $old_response) {
            try {
                $sql = "Select * From neighbours where favorite = 1 ";
                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();
    
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->query($sql);
                if ($statement->rowCount()) {
                    $neighbours = $statement->fetchAll(PDO::FETCH_OBJ);                    
                    $body->write(json_encode(message(200, 'OK', "Process Successed.", "neighbours", $neighbours)));
                } else {
                    $body->write(json_encode(message(512, 'KO', "No neighbour has been recorded yet.")));
                }

                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
    
            return $response;
        }
    );
	
	/**
     * route - UPDATE - update a neighbour by id - PUT method
	 * Elle permet d'ajouter ou de retirer un voisin des favoris
     */
    $app->put
    (
        '/markneighbour/{id}', 
        function (Request $request, Response $old_response) {
            try {

                $id = $request->getAttribute('id');

                $params = $request->getQueryParams();
				$favorite = $params['favorite'];
				

                $sql = "update neighbours set favorite = :favorite where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $statement = $db_connection->prepare($sql);
				$statement->bindParam(':favorite', $favorite);
                $statement->bindParam(':id', $id);
                $statement->execute();

                $db_access->releaseConnection();

                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been updated successfully.")));
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    /**
     * route - UPDATE - update a neighbour by id - PUT method
	 * Elle met à jour les informations d'un voisin à partir de son ID
     */
    $app->put
    (
        '/neighbour/{id}', 
        function (Request $request, Response $old_response) {
            try {

                $id = $request->getAttribute('id');

                $params = $request->getQueryParams();
                $name = $params['name'];
                $address = $params['address'];
                $phone = $params['phone'];
				$about = $params['about'];
				

                $sql = "update neighbours set name = :name, address = :address, phone = :phone, about = :about where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $statement = $db_connection->prepare($sql);
                $statement->bindParam(':name', $name);
				$statement->bindParam(':about', $about);
                $statement->bindParam(':address', $address);
                $statement->bindParam(':phone', $phone);
                $statement->bindParam(':id', $id);
                $statement->execute();

                $db_access->releaseConnection();

                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been updated successfully.")));
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    /**
     * route - DELETE - delete a neighbour by id - DELETE method
	 * Elle permet de supprimer un voisin à partir de son ID
     */
    $app->delete
    (
        '/neighbour/{id}', 
        function (Request $request, Response $old_response) {
            try {
                $id = $request->getAttribute('id');

                $sql = "delete from neighbours where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->prepare($sql);
                $statement->execute(array(':id' => $id));

                $body->write(json_encode(message(200, 'OK', "The neighbour has been deleted successfully.")));
                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    $app->run();
?>
