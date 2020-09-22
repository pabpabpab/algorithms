<?php

include_once ("balanceClass.php");
include_once ("balance2Class.php");


// алгоритм 1
$validator = new BalanceValidator();
// алгоритм 2
$validator2 = new BalanceValidator2();

echo "Алгоритм №1 - баланс скобок проверяется внутри кавычек тоже. <br>";
echo "Алгоритм №2 - баланс скобок внутри кавычек не проверяется. <br><br><br>";



$myString = <<<EOS
((a + b)/ c) - 2
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

$myString = <<<EOS
((a + b)/ c) - 2 (
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";


$myString = <<<EOS
(привет) "())"
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

$myString = <<<EOS
"Это тестовый вариант проверки (задачи со скобками). И вот еще скобки: {[][()]}"
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

$myString = <<<EOS
"([ошибка)"
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

$myString = <<<EOS
"(")
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";


$myString = <<<EOS
"([])
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

$myString = <<<EOS
([])
EOS;
$validator->renderResult($myString);
$validator2->renderResult($myString);

echo "<br><br>";

