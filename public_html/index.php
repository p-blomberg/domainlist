<?php
require dirname(__DIR__)."/init.php";

// Fire the controller somehow?
echo "<pre>";
var_dump($_SERVER['PATH_INFO']);
var_dump($_GET);

require "missing_file.php"; // "Fatal error" should be caught by error handler
throw new Exception("We are out of tea"); // Should be caught by exception handler
