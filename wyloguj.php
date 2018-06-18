<?php
session_start();
session_destroy();
header('Location: aplikacja.php');