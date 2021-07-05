<?php
require_once('vendor/autoload.php');
$session_factory = new Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$segment = $session->getSegment('cross_book');
if (empty($segment->get('id')) || !is_numeric($segment->get('id')) || 'Administrador' != $segment->get('perfil')) {
    header('Location: sesion.php?mensaje=Inicio de sesión requerido');
    exit;
}