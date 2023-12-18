<?php
session_start();

function isAdmin()
{
    if (isset($_SESSION["role"])) {
        if ($_SESSION["role"] == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
?>