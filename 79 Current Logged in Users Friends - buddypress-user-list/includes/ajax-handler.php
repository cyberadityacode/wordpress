<?php

if (!function_exists('bp_is_active')) {
    wp_send_json_error('BuddyPress is not active');
}

$args = [
    'type'     => 'active',
    'per_page' => 20,
    'page'     => 1,
];

$query = new BP_User_Query($args);
$users = [];

if (!empty($query->results)) {
    foreach ($query->results as $user) {
        $users[] = [
            'ID'         => $user->ID,
            'name'       => $user->display_name,
            'username'   => $user->user_login,
            'email'      => $user->user_email,
            'avatar_url' => bp_core_fetch_avatar([
                'item_id' => $user->ID,
                'html'    => false
            ]),
            'profile_url' => bp_core_get_user_domain($user->ID),
        ];
    }

    wp_send_json_success($users);
} else {
    wp_send_json_error('No users found');
}
