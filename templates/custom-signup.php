<?php


// Define the path to the WordPress root directory dynamically
$wordpress_root = dirname(dirname(dirname(dirname (dirname(__FILE__)))));

// Include the wp-load.php file to load WordPress environment
require_once $wordpress_root . '/wp-load.php';

// Check if WordPress environment is loaded
if (!defined('ABSPATH')) {
    echo 'WordPress environment not loaded'; // Debugging line
    exit;
}

// Get the user ID
$user_id = get_current_user_id();

// Message variable initialization
$msg = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input fields
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email already exists
    global $wpdb;
    $table_name = $wpdb->prefix . 'dc1_users';
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $email));

    if ($user) {
        $msg = 'This email is already registered. Please use a different email.';
        $msg_class = 'signup-error';
    } elseif ($password !== $confirm_password) {
        $msg = 'Passwords do not match. Please try again.';
        $msg_class = 'signup-error';
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database along with the user_id
        $wpdb->insert(
            $table_name,
            array(
                'user_id' => $user_id,  // Insert the current user's ID
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ),
            array('%d', '%s', '%s', '%s')  // Data types for the insert query
        );

        // If insertion is successful
        if ($wpdb->insert_id) {
            $msg = 'Signup successful! Please log in.';
            $msg_class = 'signup-success';

            // Optionally, redirect to login page or progress page
            wp_redirect('progress_form.php'); 
            exit;  // Ensure redirection stops the rest of the script
        } else {
            $msg = 'There was an error during the signup process. Please try again.';
            $msg_class = 'signup-error';
        }
    }
}
?>

<head>
    <title>Custom Signup</title>
    <link rel="stylesheet" href="../assets/css/styles.css">  <!-- Adjust path to your CSS file -->
</head>

<div class="signup-container">
    <h2 class="signup-heading">Welcome to the Custom Signup Page</h2>

    <?php if ($msg !== ''): ?>
        <div class="signup-message <?php echo esc_attr($msg_class); ?>">
            <?php echo esc_html($msg); ?>
        </div>
    <?php endif; ?>

    <!-- Signup Form -->
    <form method="post" action="">
        <label for="name" class="signup-label">Name:</label>
        <input type="text" id="name" name="name" class="signup-input" required autocomplete="off">

        <label for="email" class="signup-label">Email:</label>
        <input type="email" id="email" name="email" class="signup-input" required autocomplete="off">

        <label for="password" class="signup-label">Password:</label>
        <input type="password" id="password" name="password" class="signup-input" required autocomplete="off">

        <label for="confirm_password" class="signup-label">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" class="signup-input" required autocomplete="off">

        <div class="signup-login-link">
            <a href="custom-login.php">Already have an account? Login here!</a>
        </div>
        <button type="submit" class="signup-button">Sign Up</button>
    </form>
</div>
