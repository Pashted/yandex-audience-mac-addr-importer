<?php
/**
 * Created by PhpStorm.
 * User: Pashted
 * Date: 20.02.2019
 * Time: 12:00
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Импорт аудитории по МАК-адресам в Яндекс-аудитории</title>

    <script src="script.js"></script>
</head>
<body>

<form enctype="multipart/form-data" action="" method="POST">

    <h2>Шаг 1 - загрузка TXT-файла с MAC-адресами</h2>
    <p><i><a href="https://tech.yandex.ru/audience/doc/intro/data-requirements-docpage/#data-requirements__mac"
             target="_blank">требования к файлу</a></i></p>
    <input name="file" type="file" accept=".txt">
    <button type="submit">Загрузить</button>
    <?
    if (isset($_FILES['file']) && move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
        echo '<pre>';
        echo "Файл корректен и был успешно загружен.\n";
        print_r($_FILES);
        print "</pre>";
    }

    ?>
    <br><br><br>
    <h2>Шаг 2 - отправка файла в Яндекс.Аудитории</h2>
    <p>
        <a href="https://oauth.yandex.ru/authorize?response_type=token&client_id=<?= $client_id ?>">Предоставить права
            для приложения в текущем аккаунте Яндекс.Аудитории и отправить файл</a>
    </p>

    <? if (!isset($_REQUEST['segment-id']) && isset($_REQUEST['token']) && !empty($_REQUEST['token'])) {
        $result = postFile();

        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } ?>

    <br><br><br>
    <h2>Шаг 3 - сохранение нового сегмента</h2>

    <?

    if (isset($result)) { ?>

        ID <input type="text" name="segment-id" value="<?= $result['segment']['id'] ?>" style="width:80px">
        NAME <input type="text" name="segment-name" value="Сегмент от <?= date('d M Y, H:i:s'); ?>" style="width:240px">

        <button type="submit">Сохранить</button>

    <? } elseif (isset($_REQUEST['segment-id'])) {

        echo "<pre>";
        print_r(saveSegment());
        echo "</pre>";

    } else { ?>
        Сегмент не загружен
    <? } ?>

</form>

</body>
</html>