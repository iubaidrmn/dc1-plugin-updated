![image](https://github.com/user-attachments/assets/053b9128-34f8-4fd9-a46b-a55c23e959f8)

DC1 Plugin
Description:
The DC1 Plugin is a custom WordPress plugin designed for the icodeguru website to add a user dashboard with features such as user signup, login, and progress tracking. It stores user-related data, such as IELTS scores, typing speed, hackathons, and more, in a custom database table. The plugin includes activation and deactivation hooks for managing the database table and enabling button functionality.

Version:
1.0.0

Author:
Team Six

Features:
- User Dashboard: Displays user-related information.
- Custom Database Table: Stores user data like name, email, IELTS score, typing speed, and more.
- User Signup & Login: Allows users to register and log in.
- Progress Tracking: Users can track their progress in different areas such as hackathons, courses, typing speed, etc.

Installation:
1. Download the `dc1-plugin` folder.
2. Upload the folder to the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin from the WordPress admin dashboard.

Usage:
- User Signup: Use the [dc1_signup_form] shortcode to display the signup form on any page or post.
- User Login: Use the [dc1_login_form] shortcode to display the login form on any page or post.
- User Dashboard: Use the [dc1_user_dashboard] shortcode to display the user's progress and details.
- Progress Update: Use the [dc1_update_progress_form] shortcode to allow users to update their progress.

File Structure:
- dc1-plugin.php: Main plugin file, includes activation and deactivation functions.
- inc/scripts.php: Handles loading necessary scripts and styles.
- inc/add_btn.php: Adds custom button functionality.
- inc/user_functions.php: Contains functions for user signup, login, and progress tracking.

Requirements:
- PHP version 7.4 or higher.
- WordPress version 5.5 or higher.

Changelog:
Version 1.0.0
- Initial release.

Support:
For any issues or feature requests, visit [https://icode.guru](https://icode.guru).

License:
This plugin is open-source and licensed under the GPLv2 license.

Warning:
This plugin creates a custom table in your WordPress database. Ensure your database is properly backed up before activating or deactivating the plugin.
