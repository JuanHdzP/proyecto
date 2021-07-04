<?php
require_once('vendor/autoload.php');
$session_factory = new Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$session->destroy();
header('Location: sesion.php');