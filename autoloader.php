<?php

function projectAutoLoader(string $class): void
 { 
    $class = str_replace('\\', "/", $class);
    require_once "{$class}.php";
 }
 
 spl_autoload_register('projectAutoLoader');