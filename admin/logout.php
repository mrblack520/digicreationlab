<?php
require_once __DIR__ . '/../includes/auth.php';
adminRequireLogin();
adminLogout();
header('Location: login.php');
exit;
