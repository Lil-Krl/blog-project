<?php
require_once 'Database.php';
require_once 'BlogManager.php';

// Загрузка конфигурации
$config = require 'config.php';

// Подключение к базе данных
$db = new Database($config['host'], $config['dbname'], $config['username'], $config['password']);

// Проверка и создание таблиц, если они отсутствуют
$db->executeSchema('schema.sql');

// Создание менеджера блога
$blogManager = new BlogManager($db);

// Загрузка данных в базу при загрузке страницы
$loadResult = $blogManager->loadData();

// Подготовка для поиска
$results = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $results = $blogManager->search($_POST['search']);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог - Загрузка и Поиск</title>
    <style>
        h1 { font-size: 24px; margin-bottom: 20px; }
        .result { margin-bottom: 20px; }
        .result .title { font-size: 20px; font-weight: bold; }
        .result .comment { margin-bottom: 10px; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log("<?= htmlspecialchars($loadResult['message']) ?>");
        });
    </script>
</head>
<body>
    <h1>Блог</h1>

    <h2>Поиск записей</h2>
    <form method="POST">
        <input minlength="3" type="text" name="search" placeholder="Введите текст комментария" required>
        <button type="submit">Найти</button>
    </form>

    <?php if ($results !== null): ?>
        <?php if (!empty($results)): ?>
            <h3>Результаты поиска:</h3>
            <div>
                <?php foreach ($results as $index => $result): ?>
                    <div class="result">
                        <p class="title">Блог #<?= $index + 1 ?>: <?= htmlspecialchars($result['title']) ?></p>
                        <p class="comment">Комментарий: <?= htmlspecialchars($result['body']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Ничего не найдено.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
