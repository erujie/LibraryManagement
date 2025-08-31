<?php
session_start();
session_destroy();
header("Location: staffLogin.html");
exit();
?>