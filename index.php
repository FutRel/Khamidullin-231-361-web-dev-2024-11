<?php
// Функция для вывода ссылок или их отсутствия в зависимости от числа
function outNumAsLink($x)
{
    if ($x > 9) {
        return '<span>' . $x . '</span>';
    }
    return '<a href="?content=' . $x . '">' . $x . '</a>';
}

// Функция для вывода строки таблицы умножения
function outRow($n)
{
    for ($i = 2; $i <= 9; $i++) {
        // echo '<div class="row-item">' . $n . ' × ' . $i . ' = ' . ($n * $i) . '</div>';
        echo '<div class="row-item">' . outNumAsLink($n) . ' × ' . outNumAsLink($i) . ' = ' . outNumAsLink($n * $i) . '</div>';
    }
}


function outDivForm()
{
    echo '<div class="table-container">';
    if (!isset($_GET['content'])) {
        for ($i = 2; $i <= 9; $i++) {
            echo '<div class="ttRow">';
            outRow($i);
            echo '</div>';
        }
    } else {
        echo '<div class="ttSingleRow">';
        outRow($_GET['content']);
        echo '</div>';
    }
    echo '</div>';
}

function outTableForm()
{
    echo '<table class="multiplication-table">';
    if (!isset($_GET['content'])) {
        echo '<tr>';
        for ($i = 2; $i <= 9; $i++) {
            echo '<td>';
            outRow($i);
            echo '</td>';
        }
        echo '</tr>';
    } else {
        echo '<tr><td>';
        outRow($_GET['content']);
        echo '</td></tr>';
    }
    echo '</table>';
}

$html_type = isset($_GET['html_type']) ? $_GET['html_type'] : 'TABLE';

function isSelected($param, $value)
{
    return (isset($_GET[$param]) && $_GET[$param] == $value) ? ' class="selected"' : '';
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <nav>
            <a href="?html_type=TABLE<?= isset($_GET['content']) ? '&content=' . $_GET['content'] : '' ?>"
                <?= isSelected('html_type', 'TABLE') ?>>Табличная форма</a>
            <a href="?html_type=DIV<?= isset($_GET['content']) ? '&content=' . $_GET['content'] : '' ?>"
                <?= isSelected('html_type', 'DIV') ?>>Блочная форма</a>
        </nav>
    </header>

    <div class="container">
        <aside>
            <ul>
                <li><a href="?<?= isset($_GET['html_type']) ? 'html_type=' . $_GET['html_type'] : '' ?>"
                        <?= !isset($_GET['content']) ? 'class="selected"' : '' ?>>Всё</a></li>
                <?php for ($i = 2; $i <= 9; $i++): ?>
                    <li><a href="?content=<?= $i ?>&html_type=<?= $html_type ?>" <?= isSelected('content', $i) ?>><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </aside>

        <main>
            <?php $html_type == 'TABLE' ? outTableForm() : outDivForm(); ?>
        </main>
    </div>



    <footer>
        <?php
        echo ($html_type == 'TABLE' ? "Табличная верстка. " : "Блочная верстка. ");
        echo !isset($_GET['content']) ? "Таблица умножения полностью. " : "Столбец таблицы умножения на " . $_GET['content'] . ". ";
        date_default_timezone_set('Europe/Moscow');
        echo date('d.m.Y H:i:s');
        ?>
    </footer>

</body>

</html>