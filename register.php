<?php
// MySQL database credentials
$host = 'localhost';
$port = 3306;
$dbname = 'ncsrck2z_hackathon';
$username = 'ncsrck2z_dbuser';
$password = 'ncsrc!@#$';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);

    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data from the request body
        $requestBody = json_decode(file_get_contents('php://input'), true);
        
        // Check if all required fields are present
        if (
            isset($requestBody['name']) && 
            isset($requestBody['orgname']) && 
            isset($requestBody['designation']) && 
            isset($requestBody['contact']) && 
            isset($requestBody['email']) && 
            isset($requestBody['city']) && 
            isset($requestBody['state']) && 
            isset($requestBody['pincode'])
        ) {
            // Extract data from the request body
            $name = $requestBody['name'];
            $orgname = $requestBody['orgname'];
            $designation = $requestBody['designation'];
            $contact = $requestBody['contact'];
            $email = $requestBody['email'];
            $city = $requestBody['city'];
            $state = $requestBody['state'];
            $pincode = $requestBody['pincode'];

            // Check if the email already exists in the database
            $checkQuery = "SELECT * FROM user_ksr WHERE email = ?";
            $checkStatement = $pdo->prepare($checkQuery);
            $checkStatement->execute([$email]);
            $existingUser = $checkStatement->fetch();

            if ($existingUser) {
                // Return an error message if the email already exists
                echo 'Email already exists in the database!';
            } else {
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
                echo 'User created successfully! ID: ' . $lastInsertedId;
            }
        } else {
            // Return an error message if required fields are missing
            echo 'Required fields are missing!';
        }
    } else {
        // Return an error message for invalid request method
        echo 'Invalid request method!';
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
