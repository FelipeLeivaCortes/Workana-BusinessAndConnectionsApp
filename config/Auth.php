<?php
    if (!isset($_SESSION['auth'])) {
        Helpers\redirect("login.php");
    }

