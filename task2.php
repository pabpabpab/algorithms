<?php


/*
 * Реализовать удаление элемента дерева через поиск минимального\максимального элемента в поддереве
 */

// класс дерева
include_once('tree.php');
// класс итератора где методы lnr, lrn, nlr
include_once('iterator.php');



$tree = new BinaryTree();

// вставка узлов
$nodes = [500,300,  305,303,302,304,  200,100,50,30,70,700,800,900,1000,20,80,77,83,950,975,945,943,990,995,888,980];
foreach ($nodes as $node) {
    $tree->insert($node);
}

// класс итератора для обхода дерева
// передать в него дерево
$iterator = new TreeIterator($tree);


// вывод исходного дерева
echo"<h3>Исходное дерево</h3>";
echo"<div style='position:relative;height:470px;top:-30px;'>";

$iterator->nlr($tree->root, 1);

echo"</div>";


echo"<h3>Удаление узлов 50, 900, 500</h3>";

$tree->delete(50);
$tree->delete(900);
$tree->delete(500);

// вывод дерева с удаленными узлами
echo"<div style='position:relative;height:450px;'>";

$iterator->nlr($tree->root, 1);

echo"</div>";

