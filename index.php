<?php
/**
 * Created by PhpStorm.
 * User: a6y
 * Date: 21.08.15
 * Time: 13:46
 */
/**
 * Compare sites
 */
require_once 'src/autoload.php';
$checker = new \Parser\Checker();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Сравнитель сайтов</title>
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
                        <div class="panel panel-default setup1">
                            <div class="panel-body">
                                <h2>Данные</h2>
                                    <p>
                                        <img src="img/csv.png" />
                                    </p>
                                <form class="file-form ajax-form" method="POST" action="ajax_csvfile.php">
                                    <div class="form-group">
                                        <label for="csvfile">Фаил с проверяемыми страницами (csv)</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" id="csvfile" name="csvfile" class="file-input">
                                    </div>
                                    <button type="submit" class="btn btn-default">Отправить</button>
                                </form>
                            </div>
                        </div>
                        <div class="panel panel-default setup2">
                            <div class="panel-body">
                                <h2>Настройка</h2>
                                    <form class="compare-form ajax-form" method="POST" action="ajax_compare.php">
                                        <div class="form-group">
                                            <label for="algo">Алгоритм оценки:</label>
                                            <?foreach ($checker->getAlgo() as $name => $obj):?>
                                                <label class="radio-inline"><input type="radio" id="algo" name="algo" value="<?=$name?>"><?=$name?></label>
                                            <?endforeach;?>
                                        </div>
                                        <div class="form-group">
                                            <label for="filters">Фильтры:</label>
                                            <?foreach ($checker->getFilters() as $name => $obj):?>
                                                <label class="checkbox-inline"><input name='filters[]' type="checkbox" value="<?=$name?>"><?=$name?></label>
                                            <?endforeach;?>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="old_url" name="old_url" placeholder="Старый домен (без www)" value="">
                                        </div>
                                        <div class="form-group">
                                                 <input type="text" class="form-control" id="new_url" name="new_url" placeholder="Новый домен" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="threads" name="threads" placeholder="Количество потоков (по умолчанию 10)" value="">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-large">Сравнить</button>
                                        <a href="index.php" role="button" class="btn btn-default btn-large">Начало</a>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <!-- result -->
                    <div class="col-md-12">
                        <p class="result"></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="preloader">
            <div id="status">&nbsp;</div>
            <div id="status-info">
                <span class="info">

                </span>
            </div>
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
