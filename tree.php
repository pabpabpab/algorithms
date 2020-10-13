<?php


/*
 * Для задания номер 2 изменен метод deleteNode() и
 * добавлены методы getSmallestNode() и getBiggestNode()
 */


class BinaryNode
{
    public $value;
    public $left = null;
    public $right = null;
    // эти свойства для отображения узлов по x, y
    public $level;
    public $xOffset;
    // предок (записывается при вставке узла, но не пригодился)
    public $ancestor = null;


    public function __construct($value)
    {
        $this->value = $value;
    }
    public function setAncestor(&$ancestor = null)
    {
        $this->ancestor = $ancestor;
    }
    public function setLevel($level)
    {
        $this->level = $level;
    }
    public function setXOffset($xOffset)
    {
        $this->xOffset = $xOffset;
    }
}

class BinaryTree
{
    public $root;
    protected $iterator;

    public function __construct()
    {
        $this->root = null;
    }

    // установка ссылки на итератор (из конструктора итератора)
    public function setIterator($iterator)
    {
        $this->iterator = $iterator;
    }

    public function insert(int $int)
    {
        $node = new BinaryNode($int);

        if ($this->root === null) {
            $this->root = $node;
            $node->setLevel(1);
            $node->setXOffset(0);
        } else {
            $ancestor = null;
            $this->insertNode($node, $this->root, $ancestor, 1, 0);
        }
    }

    private function insertNode(BinaryNode $node, &$subtree, &$ancestor, $level, $xOffset)
    {
        if ($subtree === null) {
            $subtree = $node;
            $node->setAncestor($ancestor);
            $node->setLevel($level);
            $node->setXOffset($xOffset);
        } elseif ($subtree->value < $node->value) {
            $this->insertNode($node, $subtree->right, $subtree, $level + 1, $xOffset + 1);
        } elseif ($subtree->value > $node->value) {
            $this->insertNode($node, $subtree->left, $subtree, $level + 1, $xOffset - 1);
        }
    }

    public function delete($value)
    {
        if ($this->root === null) {
             throw new Exception('Дерево пустое');
        }

        $node = &$this->findNode($value, $this->root);

        if ($node) {
            $this->deleteNode($node);
        } else {
            throw new Exception('Элемент не найден');
        }
    }

    private function &findNode($value, BinaryNode &$subtree)
    {
        if (is_null($subtree)) {
            $false = false;
            return $false;
        }

        if ($subtree->value > $value) {
            return $this->findNode($value, $subtree->left);
        } elseif ($subtree->value < $value) {
            return $this->findNode($value, $subtree->right);
        } else {
            return $subtree;
        }
    }

    private function deleteNode(BinaryNode &$node)
    {
        if (is_null($node->left) && is_null($node->right)) {
            // нет левого и правого
            $node = null;
        } elseif (is_null($node->left)) {
            // нет левого
            // предварительно переделать параметры отображения у узлов правого поддерева
            $this->changeSubtree($node->right, ['upLevel', 'reduceXOffset']);
            $node = $node->right;
        } elseif (is_null($node->right)) {
            // нет правого
            // предварительно переделать параметры отображения у узлов левого поддерева
            $this->changeSubtree($node->left, ['upLevel', 'increaseXOffset']);
            $node = $node->left;
        } else {
            // есть левый и правый

            // но у правого нет левого
            // тогда иду в левое поддерево
            if (is_null($node->right->left)) {

                if (is_null($node->left->right)) {
                    // у левого нет правого - беру значение левого и его левую ссылку - это будет удалением
                    // (предварительно изменю параметры отображения у узлов поднимаемого поддерева)
                    $this->changeSubtree($node->left, ['upLevel', 'increaseXOffset']);
                    $node->value = $node->left->value;
                    $node->left = $node->left->left;
                } else {
                    // у левого есть правый - там ищу наибольший
                    $found = &$this->getBiggestNode($node->left->right);
                    $node->value = $found->value;
                    $found = null;
                }

            } else {

                // у правого есть левый - там ищу наименьший
                $found = &$this->getSmallestNode($node->right->left);
                $node->value = $found->value;
                $found = null;
            }

        }
    }

    // поиск наименьшего в поддереве
    private function &getSmallestNode(BinaryNode &$subtree)
    {
        if (is_null($subtree->left) && is_null($subtree->right)) {
            return $subtree;
        } elseif (is_null($subtree->left)) {
            // в правом поддереве есть наименьший, но у него есть правый,
            // тогда наименьший на выход - будет вместо удаляемого,
            $temp = $subtree;
            // а на место наименьшего ставлю его правый
            // (предварительно изменив параметры отображения у узлов поднимаемого поддерева)
            $this->changeSubtree($subtree->right, ['upLevel', 'reduceXOffset']);
            $subtree = $subtree->right;
            return $temp;
        } else {
            return $this->getSmallestNode($subtree->left);
        }
    }

    // поиск наибольшего в поддереве
    private function &getBiggestNode(BinaryNode &$subtree)
    {
        if (is_null($subtree->left) && is_null($subtree->right)) {
            return $subtree;
        } elseif (is_null($subtree->right)) {
            // в левом поддереве есть наибольший, но у него есть левый,
            // тогда наибольший на выход - будет вместо удаляемого,
            $temp = $subtree;
            // а на место наибольшего ставлю его левый
            // (предварительно изменив параметры отображения у узлов поднимаемого поддерева)
            $this->changeSubtree($subtree->left, ['upLevel', 'increaseXOffset']);
            $subtree = $subtree->left;
            return $temp;
        } else {
            return $this->getBiggestNode($subtree->right);
        }
    }

    // переделать параметры отображения у узлов поддерева
    protected function changeSubtree(&$subtree, $commands)
    {
        // получить узлы поддерева в массив
        $nodes = $this->iterator->getNodes($subtree, 1);
        // применить к узлам команды (['upLevel', 'increaseXOffset'])
        foreach ($commands as $command) {
            $this->$command($nodes);
        }
    }

    // поднять узлы поддерева на уровень повыше (при удалении корня поддерева)
    protected function upLevel($nodes)
    {
        foreach ($nodes as $node) {
            $node->level -= 1;
        }
    }

    // уменьшить смещение по X узлов поддерева (при удалении корня правого поддерева)
    protected function reduceXOffset($nodes)
    {
        foreach ($nodes as $node) {
            $node->xOffset -= 1;
        }
    }

    // увеличить смещение по X узлов поддерева (при удалении корня левого поддерева)
    protected function increaseXOffset($nodes)
    {
        foreach ($nodes as $node) {
            $node->xOffset += 1;
        }
    }
}
