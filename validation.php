<?php
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'citizensinfo');

// Establish database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check for connection error
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Function to validate username
function validateUsername($username) {
    global $conn;

    // Check if username already exists in database
    $sql = "SELECT username FROM citizens WHERE username = '$username'"; 
    $result = $conn->query($sql); 
    
    if ($result->num_rows > 0) {
        return "<strong>Username</strong> already taken";
    }
}

// Function to validate password
function validatePassword($password, $confirmPassword) {
    // Check if passwords match
    if ($password != $confirmPassword) {
        return "Both passwords are <strong>not the same</strong>!";
    }
}

// Function to validate full name
function validateFullName($fullName) {
    // Check to make sure only alphabets, spaces, and dots are used
    if (!preg_match("/^[a-zA-Z .]+$/", $fullName)) {
        return "<strong>Full name</strong> should only contain alphabets, spaces, and dots.";
    }
}

function validateAddress($address) {
    // Remove white spaces and new lines
    $address = trim(preg_replace('/\s+/', ' ', $address));

    // Check if the address is not empty
    if (empty($address)) {
        return "<strong>Address</strong> field is required.";
    }

    // Check if the address contains only alphabets, digits, spaces, commas, and periods
    if (!preg_match('/^[a-zA-Z0-9\s\.,]+$/', $address)) {
        return "<strong>Address</strong> should only contain letters, digits, spaces, commas, and periods.";
    }

    // Check if the address is less than or equal to 256 characters
    if (strlen($address) > 256) {
        return "<strong>Address</strong> should not exceed 256 characters.";
    }

    // If all checks pass, return null
    return null;
}

// Function to validate date of birth
function validateDateOfBirth($dateOfBirth) {
    // Check if date of birth is in valid format (YYYY-MM-DD)
    if (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $dateOfBirth)) {
        return "<strong>Date of Birth</strong> should be in the format: YYYY-MM-DD";
    }

    // Check if date of birth is a valid date
    $dob = date_parse($dateOfBirth);
    if (!checkdate($dob['month'], $dob['day'], $dob['year'])) {
        return "<strong>Date of Birth</strong> is not a valid date";
    }

    // Check if date of birth is in the past
    $dob_timestamp = strtotime($dateOfBirth);
    $now_timestamp = strtotime('now');
    if ($dob_timestamp > $now_timestamp) {
        return "<strong>Date of Birth</strong> cannot be in the future";
    }
}

// Function to validate phone number
function validatePhoneNumber($phoneNumber) {
    // Check to make sure phone number is 10 digits long and starts with 0
    if (!preg_match("/^0[0-9]{9}$/", $phoneNumber)) {
        return "<strong>Phone number</strong> should be 10 digits long and start with 0";
    } 
}

// Function to validate image
function validateImage($image) {
    // Check if file was uploaded
    if (!isset($image['tmp_name']) || empty($image['tmp_name'])) {
        return "Please select an image to upload";
    }

    // Check if file is a valid image
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        return "Only JPG, JPEG, PNG and GIF images are allowed";
    }

    // Check if file size is within limit
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if ($image['size'] > $maxFileSize) {
        return "The uploaded image size exceeds the maximum allowed limit of 5MB";
    }

    // If all checks passed, return null (no error message)
    return null;
}

// Function to validate close contact full name
function validateCloseContactFullName($closeContactFullName) {
    // Check to make sure only alphabets and spaces are used
    if (!preg_match("/^[a-zA-Z ]+$/", $closeContactFullName) && $closeContactFullName != '-') {
        return "<strong>Close contact full name</strong> should only contain alphabets and spaces";
    } else if (empty($closeContactFullName)) {
        return 'Please enter "-" for <strong>Close contact full name</strong> if you do not have close contact with anyone';
    }
}

// Function to validate close contact phone number
function validateCloseContactPhoneNumber($closeContactPhoneNumber) {
    // Check to make sure phone number is 10 digits long and starts with 0
    if (!preg_match("/^0[0-9]{9}$/", $closeContactPhoneNumber) && $closeContactPhoneNumber != '-') {
        return "<strong>Close contact phone number</strong> should be 10 digits long and start with 0";
    } else if (empty($closeContactPhoneNumber)) {
        return 'Please enter "-" for <strong>Close contact phone number</strong> if you do not have close contact with anyone';
    }
}
?>
