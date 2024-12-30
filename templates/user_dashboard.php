<?php
/*
Template Name: Dashboard
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

// Get the user ID
$user_id = get_current_user_id();

// Retrieve the user data
$current_user = wp_get_current_user();
$name = $current_user->display_name;

// Retrieve progress data for the logged-in user
global $wpdb;
$table_name = $wpdb->prefix . 'dc1_users';
$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id), ARRAY_A);

// Fallback if no data is available
if (!$data) {
    $data = [
        'ielts' => 0,
        'typing_speed' => 0,
        'total_hackathon' => 0,
        'win_hackathon' => 0,
        'courses' => 0,
        'webinars' => 0,
        'cgpa' => 0,
    ];
}
get_header();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Dashboard</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<section class="dashboard-section">
    <p class="dashboard-title ">Hi ! <?php echo $data['name']; ?></p>
    <h2 class="greeting">Your Progress Dashboard</h2>

    <canvas id="progressChart" width="800" height="400"></canvas>

    <div class="button-group">
        <a href="progress_form.php?id=<?php echo $user_id; ?>" class="update-btn">Update Progress</a>
    </div>
</section>

<script>
    const ctx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(ctx, {
        type: 'bar', // You can change to 'line', 'pie', etc.
        data: {
            labels: ['IELTS Progress', 'Typing Speed', 'Hackathons Participated', 'Hackathons Won', 'Courses Taught', 'Webinars Moderated', 'CGPA'],
            datasets: [{
                label: 'Progress Metrics',
                data: [
                    <?php echo esc_js($data['ielts']); ?>,
                    <?php echo esc_js($data['typing_speed']); ?>,
                    <?php echo esc_js($data['total_hackathon']); ?>,
                    <?php echo esc_js($data['win_hackathon']); ?>,
                    <?php echo esc_js($data['courses']); ?>,
                    <?php echo esc_js($data['webinars']); ?>,
                    <?php echo esc_js($data['cgpa']); ?>
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.3)',
                    'rgba(255, 159, 64, 0.3)',
                    'rgba(255, 205, 86, 0.3)',
                    'rgba(201, 203, 207, 0.3)',
                    'rgba(54, 162, 235, 0.3',
                    'rgba(153, 102, 255, 0.3)',
                    'rgba(255, 99, 132, 0.3)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php get_footer(); ?>
</body>
</html>
