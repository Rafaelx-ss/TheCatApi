<?php

$credentials = [
    'githubToken' => getenv('ENV_GITHUB_TOKEN'),
    'apiKey' => getenv('API_KEY'),
    'userName' => getenv('USER_NAME'),
    'userEmail' => getenv('USER_EMAIL'),
    'githubRepo' => getenv('ENV_GITHUB_REPO'),
];

foreach ($credentials as $key => $value) {
    if (!$value) {
        die("❌ Error: The credential $key is missing in the environment variables.\n");
    }
}

define('ENV_GITHUB_TOKEN', $credentials['githubToken']);
define('API_KEY', $credentials['apiKey']);
define('USER_NAME', $credentials['userName']);
define('USER_EMAIL', $credentials['userEmail']);
define('ENV_GITHUB_REPO', $credentials['githubRepo']);
