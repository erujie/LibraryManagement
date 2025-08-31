<?php
session_start();
session_destroy();
header("Location: studentLogin.html");
exit();
