<?php
require_once 'lib/util.php';
http_response_code(404);
?>
<!doctype html>
<html>
    <head>
        <title>Heroku Logs - Error 404</title>
    </head>
    <body>
        <h1>404. Not found.</h1>
        <p>The requested URL <span class="strong"><?= path(); ?></span> was not found on this server.</p>
    </body>
</html>
