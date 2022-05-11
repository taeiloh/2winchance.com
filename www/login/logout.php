<?php
//config
require_once __DIR__.'/../_inc/config.php';

session_unset();
session_destroy();

header('Location:/main/myaccount.php');