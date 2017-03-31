<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', []);
});

$app->get('/api/salary', function ($request, $response, $args) {
    $str = file_get_contents(__DIR__ . '/../public/employees.json');
    $all = json_decode($str, true);

    $min = floatval($request->getQueryParam('min'));
    $max = floatval($request->getQueryParam('max'));

    $filtered = [];
    if ($min && $max) {
	    foreach ($all as $employee) {
	    	$salary = str_replace(',', '', $employee['salary']);
	    	$salary = str_replace('$', '', $salary);
	    	$salary = floatval($salary);

	    	if ($min <= $salary && $salary <= $max) {
	    		$filtered[] = $employee;
	    	}
	    }
    } else $filtered = $all;


	try {
		// check request content type
		// format and return response body in specified format
		$mediaType = $request->getMediaType();
		if ($mediaType == 'application/xml') {
			$response->withHeader('Content-Type', 'application/xml');
			$xml = new SimpleXMLElement('<root/>');

			foreach ($filtered as $employee) {
				$item = $xml->addChild('employee');

				$skills = $employee['skills'];
				unset($employee['skills']);

				array_walk_recursive($employee, function($value, $key) use ($item) {
		        	$item->addChild($key, $value);
			    });

				$skills_node = $item->addChild('skills');
				array_walk_recursive($skills, function($value, $key) use ($skills_node) {
		        	$skills_node->addChild($key, $value);
			    });				
			}
			echo $xml->asXml();
		} else if (($mediaType == 'application/json')) {
			$response->withHeader('Content-type', 'application/json');
			echo json_encode($filtered);
		}
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get('/employees', function ($request, $response, $args) {
    $str = file_get_contents(__DIR__ . '/../public/employees.json');
    $all = json_decode($str, true);

    $email = $request->getQueryParam('email');

    $filtered = [];
    if ($email) {
    	foreach ($all as $employee) {
    		 
    		if (strpos($employee['email'], $email) !== false) {
			    $filtered[] = $employee;
			}
    		
    	}
    } else {
    	$filtered = $all;
    }

    return $this->renderer->render($response, 'employees.phtml', [
    	'employees' => $filtered,
    	'email' => $email
    ]);
});
