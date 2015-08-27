<?php
/**
 * Created by PhpStorm.
 * User: a6y
 * Date: 25.08.15
 * Time: 16:16
 */
require_once 'src/autoload.php';
$checker = new \Parser\Checker();
$return = array (
    'Type' => 'Error',
    'Mess' => 'Неизвестная ошибка'
);
if (!empty($_POST['algo']) && array_key_exists($_POST['algo'], $checker->getAlgo())) {
    if (!empty($_POST['filters']) && is_array($_POST['filters'])) {
        $filters = array_intersect(array_keys($checker->getFilters()), $_POST['filters']);
        if (!empty($filters)) {
            if ($checker->setOldDomain((string)$_POST['old_url'])) {
                if ($checker->setNewDomain((string)$_POST['new_url'])) {
                    $threads = empty($_POST['threads']) ? 10 : intval($_POST['threads']);
                    $return = array (
                        'Type' => 'Ok',
                        'Data' => json_encode($checker->run((string)$_POST['algo'], $filters, $threads))
                    );
                } else {
                    $return = array (
                        'Type' => 'Error',
                        'Mess' => 'Неверный новый домен'
                    );
                }
            } else {
                $return = array (
                    'Type' => 'Error',
                    'Mess' => 'Неверный старый домен'
                );
            }
        } else {
            $return = array (
                'Type' => 'Error',
                'Mess' => 'Неверный фильтр'
            );
        }
    } else {
        $return = array (
            'Type' => 'Error',
            'Mess' => 'Не выбран не один фильтр'
        );
    }
} else {
    $return = array (
        'Type' => 'Error',
        'Mess' => 'Неверный алгоритм'
    );
}
echo json_encode($return);
