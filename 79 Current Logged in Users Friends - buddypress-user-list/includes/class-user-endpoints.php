<?php

class BP_User_Endpoints {

    public function __construct() {
        add_action('wp_ajax_get_bp_users', [$this, 'ajax_get_users']);
        add_action('wp_ajax_nopriv_get_bp_users', [$this, 'ajax_get_users']); // Optional public access

        add_action('wp_ajax_get_bp_friends', [$this, 'ajax_get_friends']);
    }

    /**
     * Return list of BuddyPress users
     */
    public function ajax_get_users() {
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

        foreach ($query->results as $user) {
            $users[] = [
                'ID'         => $user->ID,
                'name'       => $user->display_name,
                'username'   => $user->user_login,
                'email'      => $user->user_email,
                'avatar_url' => bp_core_fetch_avatar([
                    'item_id' => $user->ID,
                    'html'    => false,
                ]),
                'profile_url' => bp_core_get_user_domain($user->ID),
            ];
        }

        wp_send_json_success($users);
    }

    /**
     * Return list of friends for current user
     */
    public function ajax_get_friends() {
        if (!is_user_logged_in()) {
            wp_send_json_error('Not logged in');
        }

        $user_id = get_current_user_id();
        $friends = myplugin_get_user_friends($user_id);

        if (!empty($friends)) {
            wp_send_json_success($friends);
        } else {
            wp_send_json_error('No friends found');
        }
    }
}
