<?php
if (gethostname() == "local_env") {
    $db_config = array(
    'server'   => 'db',
    'login'    => 'root',
    'password' => 'root',
    'database' => 'db',
    );
} else {
    $db_config = array(
    'server'   => 'localhost',
    'login'    => '11238123',
    'password' => '4RRDiulI',
    'database' => 'stud_11238123',
    );
}
