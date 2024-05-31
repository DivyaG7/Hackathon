<?php
// MySQL database credentials
$host = 'localhost';
$port = 3306;
$dbname = 'ncsrck2z_hackathon';
$username = 'ncsrck2z_dbuser';
$password = 'ncsrc!@#$';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data from the request body
        $requestBody = json_decode(file_get_contents('php://input'), true);
        $name = $requestBody['name'];
        $orgname = $requestBody['orgname'];
        $designation = $requestBody['designation'];
        $contact = $requestBody['contact'];
        $email = $requestBody['email'];
        $city = $requestBody['city'];
        $state = $requestBody['state'];
        $pincode = $requestBody['pincode'];

        // Prepare the INSERT statement
        $query = "INSERT INTO user_data (name, orgname, designation, contact, email, city, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $statement = $pdo->prepare($query);

        // Bind the parameters and execute the statement
        $statement->bindParam(1, $name);
        $statement->bindParam(2, $orgname);
        $statement->bindParam(3, $designation);
        $statement->bindParam(4, $contact);
        $statement->bindParam(5, $email);
        $statement->bindParam(6, $city);
        $statement->bindParam(7, $state);
        $statement->bindParam(8, $pincode);

        $statement->execute();
        $lastInsertedId = $pdo->lastInsertId();

        // Return a success message
        echo json_encode(['status' => 'success', 'message' => 'User created successfully!', 'userId' => $lastInsertedId]);
    } else {
        // Return an error message for invalid request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method!']);
    }

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
}
?>
