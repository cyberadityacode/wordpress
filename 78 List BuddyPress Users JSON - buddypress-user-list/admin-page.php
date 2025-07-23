<h1>BuddyPress Users</h1>

<?php
$args = [
    'type' => 'active',
    'per_page' => 20,
    'page' => 1,
];

$query = new BP_User_Query($args);

if (!empty($query->results)) {
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr><th>Avatar</th><th>Name</th><th>Username</th><th>Email</th><th>Profile Link</th></tr></thead>';
    echo '<tbody>';

    foreach ($query->results as $user) {
        echo '<tr>';
        echo '<td>' . get_avatar($user->ID, 40) . '</td>';
        echo '<td>' . esc_html($user->display_name) . '</td>';
        echo '<td>' . esc_html($user->user_login) . '</td>';
        echo '<td>' . esc_html($user->user_email) . '</td>';
        echo '<td><a href="' . esc_url(bp_core_get_user_domain($user->ID)) . '" target="_blank">View Profile</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p>No BuddyPress users found.</p>';
}
?>