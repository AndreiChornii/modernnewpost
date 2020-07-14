<?php
try {
        session_start();
	include __DIR__ . '/../includes/autoload.php';
        
//        echo $_SERVER['REQUEST_METHOD'];
//        echo "<BR />";
	$route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
//        echo $route;
//        echo "<BR />";
        
        $entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Newpost\NewpostRoutes());
	$entryPoint->run();
//        var_dump($_SESSION);
}
catch (PDOException $e) {
	$title = 'An error has occurred';

	$output = 'Database error: ' . $e->getMessage() . ' in ' .
	$e->getFile() . ':' . $e->getLine();

	include  __DIR__ . '/../templates/layout.html.php';
}
