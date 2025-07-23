<?php

/**
 * Get list of BuddyPress friends for a given user ID
 */
function myplugin_get_user_friends($user_id) {
    if (!function_exists('bp_is_active') || !bp_is_active('friends')) {
        return [];
    }

    $friend_ids = friends_get_friend_user_ids($user_id);
    if (empty($friend_ids)) {
        return [];
    }

    $query = new BP_User_Query([
        'user_ids' => $friend_ids,
    ]);

    $friends = [];

    foreach ($query->results as $friend) {
        $friends[] = [
            'ID'         => $friend->ID,
            'name'       => $friend->display_name,
            'username'   => $friend->user_login,
            'email'      => $friend->user_email,
            'avatar_url' => bp_core_fetch_avatar([
                'item_id' => $friend->ID,
                'html'    => false,
            ]),
            'profile_url' => bp_core_get_user_domain($friend->ID),
        ];
    }

    return $friends;
}
