<?php

/*
 * Алгоритм:
 * делаю 4 метода, каждый рисует свой маршрут (1, 2, 3, 4) в спирали,
 * в каждом методе входные параметры - это координаты начала и конца,
 * и номер текущего столбца или ряда.
 * Координаты начала и конца, и номер текущего столбца или ряда
 * определяются исходя из кол-ва уже нарисованных рядов и столбцов (в методе getCoordinates()).
 * Маршрут 1 - левый столобец сверху вниз,
 * Маршрут 2 - нижний ряд слева направо,
 * Маршрут 3 - правый столбец снизу вверх,
 * Маршрут 4 - верхний ряд справа налево.
 */


class Spiral {
    // заполняемый по спирали массив
    protected $spiral = [];
    // размерность спирали - ряды
    protected $rows = 0;
    // размерность спирали - столбцы
    protected $columns = 0;
    // текущее записываемое в спираль значение
    protected $currentValue = 0;
    // кол-во пройденных рядов
    protected $completedRows = 0;
    // кол-во пройденных столбцов
    protected $completedColumns = 0;

    // установить начальные данные
    protected function initData($rows, $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->initSpiral($rows, $columns);
        $this->currentValue = 1;
        $this->completedRows = 0;
        $this->completedColumns = 0;
    }

    // заполнить спираль нулями при старте
    protected function initSpiral($rows, $columns)
    {
        for ($y = 0; $y < $rows; $y++) {
            for ($x = 0; $x < $columns; $x++) {
                $this->spiral[$y][$x] = 0;
            }
        }
    }

    // Определение координат для маршрута номер $route:
    // координаты начала и конца, и номер текущего столбца или ряда
    // определяются исходя из кол-ва уже пройденных (нарисованных) рядов и столбцов, и размера спирали.
    protected function getCoordinates($route)
    {
        $coordinates = [];
        if ($route == 1) {
            $y1 = ceil($this->completedRows/2);
            $y2 = $this->rows - ceil($this->completedRows/2) - 1;
            $column = ceil($this->completedColumns/2);
            $coordinates = [$y1, $y2, $column];
        } elseif ($route == 2) {
            $x1 = ceil($this->completedColumns/2);
            $x2 = $this->columns - ceil($this->completedColumns/2);
            $row = $this->rows - ceil($this->completedRows/2) - 1;
            $coordinates = [$x1, $x2, $row];
        } elseif ($route == 3) {
            $y1 = $this->rows - ceil($this->completedRows/2) - 1;
            $y2 = ceil($this->completedRows/2) - 1;
            $column = $this->columns - ceil($this->completedColumns/2);
            $coordinates = [$y1, $y2, $column];
        } elseif ($route == 4) {
            $x1 = $this->columns - ceil($this->completedColumns/2) - 1;
            $x2 = ceil($this->completedColumns/2);
            $row = ceil($this->completedRows/2) - 1;
            $coordinates = [$x1, $x2, $row];
        }
        return $coordinates;
    }

    // заполнение спирали - маршрут 1 - левый столобец сверху вниз
    protected function makeRoute1()
    {
        if ($this->completedColumns >= $this->columns) {
            return;
        }

        list($y1, $y2, $column) = $this->getCoordinates(1);
        for ($y = $y1; $y <= $y2; $y++) {
            $this->spiral[$y][$column] = $this->currentValue;
            $this->currentValue += 1;
        }
        $this->completedColumns += 1;
    }

    // заполнение спирали - маршрут 2 - нижний ряд слева направо
    protected function makeRoute2()
    {
        if ($this->completedRows >= $this->rows) {
            return;
        }

        list($x1, $x2, $row) = $this->getCoordinates(2);
        for ($x = $x1; $x <= $x2; $x++) {
            $this->spiral[$row][$x] = $this->currentValue;
            $this->currentValue += 1;
        }
        $this->completedRows += 1;
    }

    // заполнение спирали - маршрут 3 - правый столбец снизу вверх
    protected function makeRoute3()
    {
        if ($this->completedColumns >= $this->columns) {
            return;
        }

        list($y1, $y2, $column) = $this->getCoordinates(3);
        for ($y = $y1; $y >= $y2; $y--) {
            $this->spiral[$y][$column] = $this->currentValue;
            $this->currentValue += 1;
        }
        $this->completedColumns += 1;
    }

    // заполнение спирали - маршрут 4 - верхний ряд справа налево
    protected function makeRoute4()
    {
        if ($this->completedRows >= $this->rows) {
            return;
        }

        list($x1, $x2, $row) = $this->getCoordinates(4);
        for ($x = $x1; $x >= $x2; $x--) {
            $this->spiral[$row][$x] = $this->currentValue;
            $this->currentValue += 1;
        }
        $this->completedRows += 1;
    }

    // заполнение спирали
    protected function makeSpiral($rows, $columns)
    {
        // определить кол-во циклов (кругов) исходя из размера спирали
        $cycles = ($rows <= $columns) ? $rows : $columns;
        $cycles = ceil($cycles/2);

        // рисовать маршруты в цикле
        for ($i = 1; $i <= $cycles; $i++) {
            $this->makeRoute1();
            $this->makeRoute2();
            $this->makeRoute3();
            $this->makeRoute4();
        }
    }

    // рисование заполненной спирали
    public function render($rows, $columns)
    {
        if ($rows < 1) {
            echo"<div>$rows * $columns - ошибка</div><br>";
            return;
        }
        if ($columns < 1) {
            echo"<div>$rows * $columns - ошибка</div><br>";
            return;
        }

        // установить начальные данные
        $this->initData($rows, $columns);
        // заполнить спираль
        $this->makeSpiral($rows, $columns);

        // вывести спираль
        echo "<table cellspacing=0 cellpadding=5 border=1>";
        for ($y = 0; $y < $rows; $y++) {
            echo "<tr>";
            for ($x = 0; $x < $columns; $x++) {
                echo "<td>";
                echo $this->spiral[$y][$x];
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table><br>";
    }
}



$spiral = new Spiral();
$spiral->render(1, 1);
$spiral->render(1, 2);
$spiral->render(1, 3);
$spiral->render(0, 7);
$spiral->render(3, 1);
$spiral->render(2, 3);
$spiral->render(2, 7);
$spiral->render(3, 7);
$spiral->render(3, 4);
$spiral->render(4, 4);
$spiral->render(5, 5);
$spiral->render(7, 8);
$spiral->render(13, 7);