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
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    // Query to select all rows from the 'user_cyber' table
    $query = "SELECT * FROM user_data";
    $statement = $pdo->query($query);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Display the table content with styling
    echo '<style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
               background-color: #f2f2f2;
            }
          </style>';
    echo '<table>
               <tr>
                   <th>id</th>
                   <th>Name</th>
                   <th>Organisation Name</th>
                   <th>Designation</th>
                   <th>Contact</th>
                   <th>Email</th>
                   <th>City</th>
                   <th>State</th>
               </tr>';
                 
                      
    foreach ($users as $user) {
        echo '<tr>';
echo '<td>' . $user['id'] . '</td>';
echo '<td>' . $user['name'] . '</td>';
echo '<td>' . $user['orgname'] . '</td>';
echo '<td>' . $user['designation'] . '</td>';
echo '<td>' . $user['contact'] . '</td>';
echo '<td>' . $user['email'] . '</td>';
echo '<td>' . $user['city'] . '</td>';
echo '<td>' . $user['state'] . '</td>';
echo '</tr>';
}
echo '</table>';

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Email sending failed: ' . $mail->ErrorInfo;
}
?>
