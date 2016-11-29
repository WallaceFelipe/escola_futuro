<?php
session_start();

unset($_SESSION);
session_destroy($_SESSION);

die("<script>location.href='login.php';</script>");
?>