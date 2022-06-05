<?php

require 'db_config.php';

$conn = new mysqli($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    throw new Exception('Database connection error');
}

