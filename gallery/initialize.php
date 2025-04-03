<?php
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => getenv('DEV_PASSWORD') ?: '5da283a2d990e8d8512cf967df5bc0d0', // Move to .env
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

// Auto-detect base URL
if(!defined('base_url')) define('base_url', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/');

// Ensure correct app path
if(!defined('base_app')) define('base_app', realpath(__DIR__).'/');

// Secure database credentials using environment variables
if(!defined('DB_SERVER')) define('DB_SERVER', getenv('DB_SERVER') ?: "localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME', getenv('DB_USERNAME') ?: "root");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv('DB_PASSWORD') ?: "");
if(!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: "gallery_db");

// Store developer data securely
if(!defined('dev_data')) define('dev_data', $dev_data);
?>
