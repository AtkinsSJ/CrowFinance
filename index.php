<?php

function autoload($className) {
	include( "lib/{$className}.php" );
}
spl_autoload_register('autoload');

$app = new BootStrap();