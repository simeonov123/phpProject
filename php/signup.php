

<?php
/*  1. Receives input from a user registration form (first name, last name, email, password, and an image file).
    2. Validates that all fields are filled and the email is in the correct format.
    3. Checks if the email already exists in the users table in the database.
    4. Handles the image upload by checking the file extension and MIME type, then moves the file to a permanent location.
    5. Encrypts the password using MD5.
    6. Inserts the new user into the database.
    7. Sets a session variable for the newly created user ID and returns "success" if all operations are successful.
*/

// Start a new session or resume the existing session
session_start();
// Include the database configuration file
include_once "config.php";

// Escape special characters in the form input to prevent SQL injection
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if all form inputs are filled in
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Validate the email format
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email already exists in the database
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - This email already exist!";
        } else {
            // Check if an image file was uploaded
            if (isset($_FILES['image'])) {
                // Retrieve file details
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Extract the file extension
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                // Define allowed extensions
                $extensions = ["jpeg", "png", "jpg"];
                // Check if the file has a valid extension
                if (in_array($img_ext, $extensions) === true) {
                    // Define allowed MIME types
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    // Check if the file has a valid MIME type
                    if (in_array($img_type, $types) === true) {
                        // Create a unique file name using the current timestamp
                        $time = time();
                        $new_img_name = $time . $img_name;
                        // Move the uploaded file to the images directory
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            // Generate a random unique ID
                            $ran_id = rand(time(), 100000000);
                            // Set the user's status
                            $status = "Active now";
                            // Encrypt the password
                            $encrypt_pass = md5($password);
                            // Insert the new user into the database
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                            if ($insert_query) {
                                // Retrieve the new user from the database
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    // Set a session variable with the user's unique ID
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                } else {
                                    echo "This email address not Exist!";
                                }
                            } else {
                                echo "Something went wrong. Please try again!";
                            }
                        }
                    } else {
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                } else {
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
?>
