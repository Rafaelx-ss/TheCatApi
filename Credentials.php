<?php

$credentials = [
    'githubToken' => getenv('GITHUB_TOKEN'),
    'apiKey' => getenv('ACCESS_TOKEN'),
    'userName' => getenv('USER_NAME'),
    'userEmail' => getenv('USER_EMAIL'),
    'githubRepo' => getenv('GITHUB_REPO'),
];

foreach ($credentials as $key => $value) {
    if (!$value) {
        die("❌ Error: The credential $key is missing in the environment variables.\n");
    }
}

define('GITHUB_TOKEN', $credentials['githubToken']);
define('API_KEY', $credentials['apiKey']);
define('USER_NAME', $credentials['userName']);
define('USER_EMAIL', $credentials['userEmail']);
define('GITHUB_REPO', $credentials['githubRepo']);
