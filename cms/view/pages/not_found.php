<?php

http_response_code(404);
require 'view/components/header.php';

echo '<div id="notFound">404</div>';

require 'view/components/footer.php';
