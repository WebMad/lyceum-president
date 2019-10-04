<?php
session_start();
header('Content-type:application/json;charset=utf-8');
$link = new PDO('mysql:host=127.0.0.1;dbname=webmadness', 'root', '');