<?php

namespace MyAwesomePlugin;

use WP_User_Query;

class Ajax
{
    public static function run()
    {
        add_action('wp_ajax_myawesomeplugin_hello', [__CLASS__, 'hello']);
        add_action('wp_ajax_myawesomeplugin_fetch_users', [__CLASS__, 'fetch_users']);

    }
    public static function hello()
    {
        wp_send_json_success('Hello From PHP!');
    }

    // fetch all users of our WP Site

    public static function fetch_users()
    {
        $user_query = new WP_User_Query([
            'fields' => 'all',
            'number' => -1,
        ]);

        $users = $user_query->get_results();
        $results = [];

        foreach ($users as $user) {
            $results[] = [
                'id' => $user->ID,
                'name' => $user->display_name,
                'email' => $user->user_email,
                'username' => $user->user_login,
                'avatar' => get_avatar_url($user->ID),
                'role' => implode(', ', $user->roles),
            ];
        }
        wp_send_json_success($results);
    }

}