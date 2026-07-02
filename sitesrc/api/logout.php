<?php
session_start();
session_destroy();
header("Location: ../Login/Default.aspx");
exit;
?>