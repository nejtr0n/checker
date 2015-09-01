<?php
/**
 * Created by PhpStorm.
 * User: a6y
 * Date: 26.08.15
 * Time: 18:39
 */
require_once 'src/autoload.php';
$result = new \Parser\Result();
$header = $result->getResultHeader();
$data = $result->getResultData();
if (isset($_GET['clear'])) {
    $result->clearResultData();
    header ("Location: ".basename(__FILE__));
}
// Make csv file
if (isset($_GET['download'])) {
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    $heading = array();
    foreach ($header as $column) {
        $heading[] = $column["name"];
    }
    fputcsv($output, $heading);

    // loop over the rows, outputting them
    foreach ($data as $line){
        $result = array();
        foreach ($header as $column) {
            $result[] = $line[$column["name"]];
        }
        fputcsv($output, $result);
    }
    exit;
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Результаты</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="src/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" media="all" />
    <link href="src/twbs/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" media="all" />
    <link href="css/main.css" rel="stylesheet" media="all" />
</head>
<body>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Результат</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?foreach ($header as $column):?>
                                    <th class="success"><?=$column["name"]?></th>
                                <?endforeach;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?foreach ($data as $line):?>
                                <tr>
                                    <?foreach ($header as $column):?>
                                        <td><?=$line[$column["name"]]?></td>
                                    <?endforeach;?>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                    <h2>Skip</h2>
                    <ul>
                        <li>
                            <b>0</b><span> - Запрос производился</span>
                        </li>
                        <li>
                            <b>1</b><span> - Ссылка пропущена</span>
                        </li>
                    </ul>
                    <h2>Результаты фильтров</h2>
                    <ul><li>
                        <b>0</b><span> - Тексты не совпадают</span>
                        </li>
                    <li>
                        <b>-1</b><span> - Не было хотя бы одного из результатов для сравнения</span>
                    </li>
                    <li>
                        <b>-2</b><span> - Размер текста меньше шингла</span>
                    </li>
                </ul>
                <br />
                    <a href="result.php?clear" role="button" class="btn btn-danger btn-large">Очистить результаты</a>
                    <a href="result.php?download" role="button" class="btn btn-success btn-large">Скачать CSV</a>
                    <a href="index.php" role="button" class="btn btn-default btn-large">Начало</a>
                <p></p>
            </div>
        </div>
    </div>
</div>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- Js -->
<script type="text/javascript" src="src/components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="src/components/jquery/jquery-migrate.min.js"></script>
<script type="text/javascript" src="src/components/jquery/jquery-migrate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript" src="src/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
