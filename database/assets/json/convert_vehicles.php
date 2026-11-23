<?php

$filename = readline('Enter file name: ');
switch ($filename) {
    case 'makes':
        $map = [
            'id' => 'id',
            'name' => 'name',
        ];
        break;
    case 'models':
        $map = [
            'id' => 'id',
            'name' => 'name',
            'class' => 'class',
            'make_id' => 'make_id',
        ];
        break;
    case 'data':
        $map = [
            'id' => 'id',
            'name' => 'name',
            'cylinders' => 'cylinders',
            'displacement' => 'displacement',
            'drive' => 'drive',
            'transmission' => 'transmission',
            'make_id' => 'make_id',
            'model_id' => 'model_id',
        ];
        break;
    default:
        throw new Exception('The filename is not in selection list');
}



$json = mb_convert_encoding(file_get_contents("./{$filename}.json"), 'UTF-8');

if ($json === false) {
    exit('Failed to read JSON file.');
}

$data = json_decode($json, true);

if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    exit('JSON decode error: ' . json_last_error_msg());
}

$file = fopen("./vehicles/{$filename}.php", 'w') or exit('Unable to open file');
fwrite($file, '<?php');
fwrite($file, "\n\n");
fwrite($file, '$' . $filename . ' = [');

$result = array_map(function ($item) use ($file, $map) {
    fwrite($file, "\n[");

    $index = 0;
    foreach ($map as $mapKey => $mapValue) {
        $value = $item[$mapKey];
        if (gettype($value) === 'string') {
            $value = "'{$value}'";
        }

        fwrite($file, "\n" . "'{$mapValue}'" . '=>' . $value . ',');
        $index++;
    }

    fwrite($file, "\n],");
}, $data);

fwrite($file, "\n");
fwrite($file, '];');
