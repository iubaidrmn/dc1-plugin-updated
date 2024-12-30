<?php
/*
Template Name: Custom Login
*/
// Ensure WordPress environment is loaded

// Define the path to the WordPress root directory dynamically
$wordpress_root = dirname(dirname(dirname(dirname (dirname(__FILE__)))));

// Include the wp-load.php file to load WordPress environment
require_once $wordpress_root . '/wp-load.php';

// Check if WordPress environment is loaded
if ( !defined( 'ABSPATH' ) ) {
    echo 'WordPress environment not loaded'; // Debugging line
}

// Get the user ID
$user_id = get_current_user_id();

// Message variable initialization
$msg = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    global $wpdb;
    $table_name = $wpdb->prefix . 'dc1_users';
    

    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d AND email = %s", $user_id, $email));
    if ($user) {
        if (password_verify($password, $user->password)) {
            $msg = 'Login successful!';
            $msg_class = 'login-success';
            wp_redirect('user_dashboard.php'); 
        } else {
            $msg = 'Invalid password. Please try again.';
            $msg_class = 'login-error';
        }
    } else {
        $msg = 'No user found with that email. Please try again.';
        $msg_class = 'login-error';
    }
}

?>
<head>
    <title>Custom Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<div class="login-container">
    <h2 class="login-heading">Welcome to the Custom Login Page</h2>

    <?php if ($msg !== ''): ?>
        <div class="login-message <?php echo esc_attr($msg_class); ?>">
            <?php echo esc_html($msg); ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="">
        <label for="email" class="login-label">Email:</label>
        <input type="email" id="email" name="email" class="login-input" required autocomplete="off">

        <label for="password" class="login-label">Password:</label>
        <input type="password" id="password" name="password" class="login-input" required autocomplete="off">

        <div class="login-signup-link">
            <a href="custom-signup.php">Don't have an account? Sign up here!</a>
        </div>
        <button type="submit" class="login-button">Login</button>
    </form>
</div>