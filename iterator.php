<?php

// класс для обхода дерева по nlr, lnr, lrn

class TreeIterator {
    // сюда передам дерево
    protected $tree = null;
    // счетчик обхода дерева
    protected $iCounter = 0;
    // вспомогательное при удалении узлов, когда нужно в массив собрать узлы поддерева
    protected $nodes = [];

    public function __construct($tree)
    {
        $this->tree = $tree;
        // отправить дереву ссылку на этот итератор
        $tree->setIterator($this);
    }

    // NLR
    public function nlr(&$subtree, $resetCounter = 0)
    {
        // сбросить счетчик обхода при первом входе
        if ($resetCounter === 1) {
            $this->iCounter = 0;
            echo "<h1 style='position:absolute;top:0;left:10px;'>NLR</h1>";
        }
        // печать узла
        $this->nodeEcho($subtree);
        // иду налево
        if ($subtree->left) {
            $this->nlr($subtree->left);
        }
        // иду направо
        if ($subtree->right) {
            $this->nlr($subtree->right);
        }
    }

    // LNR
    public function lnr(&$subtree, $resetCounter = 0)
    {
        // сбросить счетчик обхода при первом входе
        if ($resetCounter === 1) {
            $this->iCounter = 0;
            echo "<h1 style='position:absolute;top:0;left:10px;'>LNR</h1>";
        }
        // иду налево
        if ($subtree->left) {
            $this->lnr($subtree->left);
        }
        // печать узла
        $this->nodeEcho($subtree);
        // иду направо
        if ($subtree->right) {
            $this->lnr($subtree->right);
        }
    }

    // LRN
    public function lrn(&$subtree, $resetCounter = 0)
    {
        // сбросить счетчик обхода при первом входе
        if ($resetCounter === 1) {
            $this->iCounter = 0;
            echo "<h1 style='position:absolute;top:0;left:10px;'>LRN</h1>";
        }
        // иду налево
        if ($subtree->left) {
            $this->lrn($subtree->left);
        }
        // иду направо
        if ($subtree->right) {
            $this->lrn($subtree->right);
        }
        // печать узла
        $this->nodeEcho($subtree);
    }

    // вывод узла на экран
    protected function nodeEcho(&$subtree)
    {
        $this->iCounter += 1;
        $i_th = "<span style='color:#3090ff;margin-left:5px;font-size:12px;'>(".$this->iCounter.")</span>";

        $top = $subtree->level * 50;
        $left = 500 + $subtree->xOffset * 50;

        echo"<div style='position:absolute;top:".$top."px;left:".$left."px;'>" .
            $subtree->value . $i_th .
            "</div>";
    }


    // получить массив узлов (методом nlr) (при удалении корня поддерева для изменения параметров узлов)
    public function getNodes(&$subtree, $start = 0)
    {
        if ($start === 1) {
            $this->nodes = [];
        }
        // узел в массив
        $this->nodes[] = $subtree;

        // иду налево
        if ($subtree->left) {
            $this->getNodes($subtree->left);
        }
        // иду направо
        if ($subtree->right) {
            $this->getNodes($subtree->right);
        }

        // массив узлов поддерева
        return $this->nodes;
    }
}









