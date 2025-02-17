<?php
session_start();
SESSION_UNSET();
session_destroy();
header('Location: /');
exit();