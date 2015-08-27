<?php
/**
 * Created by PhpStorm.
 * User: a6y
 * Date: 21.08.15
 * Time: 17:15
 */
/**
 * Store csv file data in tmp table
 */
require_once 'src/autoload.php';
$return = array (
    'Type' => 'Error',
    'Mess' => 'Неизвестная ошибка'
);
if (($handle = fopen($_FILES["csvfile"]["tmp_name"], "r")) !== FALSE) {
    $result = new \Parser\Result();
    $result->init();
    $row = 0;
    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
        $row++;
        // Skip csv header
        if ($row == 1) continue;
        if (!empty($data[0])) {
            $result->addLink($row, $data[0]);
        }
    }
    $return = array (
        'Type' => 'OK',
        'DATA' => $row - 1
    );
} else {
    $return = array (
        'Type' => 'Error',
        'Mess' => 'Could not open csv!'
    );
}
echo json_encode($return);