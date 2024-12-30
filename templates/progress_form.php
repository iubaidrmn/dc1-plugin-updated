<?php
/*
Template Name: Progress Form
*/

// Define the path to the WordPress root directory dynamically
$wordpress_root = dirname(dirname(dirname(dirname (dirname(__FILE__)))));

// Include the wp-load.php file to load WordPress environment
require_once $wordpress_root . '/wp-load.php';

// Check if WordPress environment is loaded
if ( !defined( 'ABSPATH' ) ) {
    echo 'WordPress environment not loaded'; // Debugging line
    exit;
}

$msg = '';

// Get the user ID
$user_id = get_current_user_id();

// Initialize form values
$ielts_progress = '';
$typing_speed = '';
$hackathon_participations = '';
$hackathon_wins = '';
$courses_taught = '';
$webinars_moderated = '';
$cgpa = '';

// Retrieve progress data for the logged-in user
global $wpdb;
$table_name = $wpdb->prefix . 'dc1_users';
$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id), ARRAY_A);

if ($data) {
    $ielts_progress = $data['ielts'];
    $typing_speed = $data['typing_speed'];
    $hackathon_participations = $data['total_hackathon'];
    $hackathon_wins = $data['win_hackathon'];
    $courses_taught = $data['courses'];
    $webinars_moderated = $data['webinars'];
    $cgpa = $data['cgpa'];
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the inputs to avoid security risks
    $ielts_progress = sanitize_text_field($_POST['ielts_progress']);
    $typing_speed = sanitize_text_field($_POST['typing_speed']);
    $hackathon_participations = sanitize_text_field($_POST['hackathon_participations']);
    $hackathon_wins = sanitize_text_field($_POST['hackathon_wins']);
    $courses_taught = sanitize_text_field($_POST['courses_taught']);
    $webinars_moderated = sanitize_text_field($_POST['webinars_moderated']);
    $cgpa = sanitize_text_field($_POST['cgpa']);

    $data = array(
        'user_id' => $user_id, // User ID from the WordPress session
        'ielts' => $ielts_progress,
        'typing_speed' => $typing_speed,
        'total_hackathon' => $hackathon_participations,
        'win_hackathon' => $hackathon_wins,
        'courses' => $courses_taught,
        'webinars' => $webinars_moderated,
        'cgpa' => $cgpa,
    );

    $format = array('%d', '%s', '%s', '%d', '%d', '%d', '%d', '%s');

    // Update or insert data
    if ($data) {
        $wpdb->update($table_name, $data, array('user_id' => $user_id), $format, array('%d'));
    } else {
        $wpdb->insert($table_name, $data, $format);
    }

    wp_redirect('user_dashboard.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Form</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>

<section class="progress-section">
    <h2 class="progress-title">Your Progress</h2>

    <?php if ($msg !== ''): ?>
        <div class="progress-message <?php echo esc_attr($msg_class); ?>">
            <?php echo esc_html($msg); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <!-- IELTS Preparation -->
        <div class="progress-item">
            <label for="ielts_progress">IELTS Preparation Progress (%):</label>
            <input type="number" name="ielts_progress" id="ielts_progress" min="0" max="100" required value="<?php echo esc_attr($ielts_progress); ?>">
        </div>

        <!-- Typing Speed -->
        <div class="progress-item">
            <label for="typing_speed">Typing Speed (WPM):</label>
            <input type="number" name="typing_speed" id="typing_speed" min="0" required value="<?php echo esc_attr($typing_speed); ?>">
        </div>

        <!-- Hackathon Participations -->
        <div class="progress-item">
            <label for="hackathon_participations">Hackathon Participations:</label>
            <input type="number" name="hackathon_participations" id="hackathon_participations" min="0" required value="<?php echo esc_attr($hackathon_participations); ?>">
        </div>

        <!-- Hackathon Wins -->
        <div class="progress-item">
            <label for="hackathon_wins">Hackathon Wins:</label>
            <input type="number" name="hackathon_wins" id="hackathon_wins" min="0" required value="<?php echo esc_attr($hackathon_wins); ?>">
        </div>

        <!-- Courses Taught -->
        <div class="progress-item">
            <label for="courses_taught">Courses Taught:</label>
            <input type="number" name="courses_taught" id="courses_taught" min="0" required value="<?php echo esc_attr($courses_taught); ?>">
        </div>

        <!-- Webinars Moderated -->
        <div class="progress-item">
            <label for="webinars_moderated">Webinars Moderated:</label>
            <input type="number" name="webinars_moderated" id="webinars_moderated" min="0" required value="<?php echo esc_attr($webinars_moderated); ?>">
        </div>

        <!-- CGPA -->
        <div class="progress-item">
            <label for="cgpa">CGPA:</label>
            <input type="number" name="cgpa" id="cgpa" min="0" max="4" step="0.01" required value="<?php echo esc_attr($cgpa); ?>">
        </div>

        <button type="submit" class="submit-button">Save Progress</button>
    </form>
</section>

</body>
</html>
