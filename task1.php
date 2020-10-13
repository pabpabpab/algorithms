<?php


/*
 * Реализовать обход дерева в глубину тремя способами: lnr, lrn, nlr
 */

// класс дерева
include_once('tree.php');
// класс итератора где методы lnr, lrn, nlr
include_once('iterator.php');



$tree = new BinaryTree();

// вставка узлов
$nodes = [4,3,5,2,1,0,7,6,8];
foreach ($nodes as $node) {
    $tree->insert($node);
}



// класс итератора для обхода дерева по nlr, lnr, lrn
// передать в него дерево
$iterator = new TreeIterator($tree);

echo"<div style='position:relative;height:270px;top:-30px;'>";

// вывод дерева по NLR
$iterator->nlr($tree->root, 1);

echo"</div>";
echo"<div style='position:relative;height:300px;'>";

// вывод дерева по LNR
$iterator->lnr($tree->root, 1);

echo"</div>";
echo"<div style='position:relative;height:300px;'>";

// вывод дерева по LRN
$iterator->lrn($tree->root, 1);

echo"</div>";



