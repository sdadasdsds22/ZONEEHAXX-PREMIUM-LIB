<?php
$filename = 'online_users.txt';

// Increase count
$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$timeout = 7200; // user session lasts 2 hours

// Load current sessions
$sessions = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

// Remove old sessions
foreach ($sessions as $ipKey => $lastSeen) {
    if ($lastSeen + $timeout < $time) {
        unset($sessions[$ipKey]);
    }
}

// Update current IP timestamp
$sessions[$ip] = $time;
file_put_contents($filename, json_encode($sessions));

// Output number of online users
echo count($sessions);
?>