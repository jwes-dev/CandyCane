<?php
    require_once $Context->ViewName;
    global $HTML;
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Error</title>
</head>
<body>
    <hgroup>
        <h1>Error.</h1>
        <h2>An error occurred while processing your request.</h2>
        <?php
            RenderBody();
        ?>
    </hgroup>
</body>
</html>
