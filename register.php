<?php
// MySQL database credentials
$host = 'localhost';
$port = 3306;
$dbname = 'ncsrck2z_ncsrc_cusat';
$username = 'ncsrck2z_dbuser';
$password = 'ncsrc!@#$';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Connect to the''' MySQL database
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
       $statement->bindParam(6, $city);    // Add this line
       $statement->bindParam(7, $state);
       $statement->bindParam(8, $pincode);

        $statement->execute();
        $lastInsertedId = $pdo->lastInsertId();

        // Return a success message
        echo 'User created successfully!'. $lastInsertedId;
        // $to = $email;
        // $subject = "Registration Successful for Hackathon Reg...";
        // $message = '<html><body>';
        // $message .= 'Greetings from National Cyber Security Research Council!!!<br>';
        // $message .= '<br>';
        // $message .= "Congratulations, Mr/Mrs.$name you have successfully registered for the upcoming event 'Faculty Development Programme on Cyber Security (Kerala Edition)' on 18 October 2023 in Cochin University of Science and Technology, Kochi.<br>";
        // $message .= '<p style="text-align: center;">We wish you all the best for your future endeavor</p><br>'; 
        // $message .= '<br>';
        // $message .= 'Best Regards,<br>';
        // $message .= 'Team NCSRC<br>';
        // $message .= '<br>';
        // $message .= '*Note: Kindly bring your ID proof.*<br>';
        // $message .= '</body></html>';
        // $headers = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $headers .= 'From: support@ncsrc.in' . "\r\n" .
        //     'Reply-To: support@ncsrc.in' . "\r\n";

        // if (mail($to, $subject, $message, $headers)) {
        //     echo "Email sent successfully!";
        // } else {
        //     echo "Email sending failed!";
        // }
    } else {
        // Return an error message for invalid request method
        echo 'Invalid request method!';
    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
