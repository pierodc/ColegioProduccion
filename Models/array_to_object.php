<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?
	$Array = array(
        "key1" => 'value1',
        "key2" => 'value2',
        "key3" => 'value3',
        "key4" => 'value4',
    );

    $Objeto = (object)$Array;

    echo "<pre>" . PHP_EOL;
    print_r($Array);
    print_r($Objeto);
    echo "</pre>" . PHP_EOL;
	
	?>
</body>
</html>