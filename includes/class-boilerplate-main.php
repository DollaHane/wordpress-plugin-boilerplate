<?php

class Boilerplate_Main
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'setup_admin_pages']);
        add_action('init', 'boilerplate_register_gutenberg_block');
        add_action('save_api_key', 'handle_save_api_key');
        add_action('wp_ajax_boilerplate_submit_form', 'boilerplate_render_main_page');
        add_action('wp_ajax_nopriv_boilerplate_submit_form', 'boilerplate_render_main_page');
    }

    public function setup_admin_pages()
    {
        add_menu_page(
            'Boilerplate',
            'Boilerplate Main',
            'manage_options',
            'boilerplate_main_page',
            'boilerplate_render_main_page',
            'dashicons-admin-tools',
            20
        );

        add_submenu_page(
            'boilerplate_main_page',
            'Boilerplate Sub One',
            'Boilerplate Sub One',
            'manage_options',
            'boilerplate_sub_page_one',
            'boilerplate_render_sub_page'
        );

        add_submenu_page(
            'boilerplate_main_page',
            'Boilerplate Sub Two',
            'Boilerplate Sub Two',
            'manage_options',
            'boilerplate_sub_page_two',
            'boilerplate_render_from_laravel'
        );

        add_submenu_page(
            'boilerplate_main_page',
            'Settings',
            'Settings',
            'manage_options',
            'boilerplate_settings',
            'boilerplate_render_settings_page'
        );
    }
}
