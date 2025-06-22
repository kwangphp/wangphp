<?php

$session = new Session();

$session->Start();
$session->Unset();
$session->Destroy();

redirect('https://example.com/');
exit;
?>
