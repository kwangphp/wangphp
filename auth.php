<?php

$session = new Session();

$session->Start();

if(!$session->Stream())
	redirect("https://example.com/login/")
?>