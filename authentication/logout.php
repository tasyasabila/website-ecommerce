<?php
session_start();
session_destroy();
header("Location: ../pages/auth/login_admin.php");
exit();
