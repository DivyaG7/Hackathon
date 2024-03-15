<?php
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = 'localhost';
$port = 3306; // Added port
$dbname = 'ncsrck2z_ncsrc_cyberdb';
$username = 'ncsrck2z_dbuser';
$password = 'ncsrc!@#$';

// Set up PDO connection
$dsn = "mysql:host=$host;port=$port;dbname=$dbname";  // DSN includes port now

try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}

// Check if city_name is provided in the GET request
if(isset($_GET['city_name'])) {
    $city_name = $_GET['city_name'];
    
    try {
        // Prepare and execute the query
        $stmt = $dbh->prepare("SELECT s.state_name FROM states s INNER JOIN cities c ON s.state_id = c.state_id WHERE c.city_name = :city_name");
        $stmt->bindParam(':city_name', $city_name, PDO::PARAM_STR);
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if state found or not
        if($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'State not found for provided city_name']);
        }
    } catch(PDOException $e) {
        echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'city_name is required']);
}

?>
