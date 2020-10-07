<?php

/*
 * Алгоритм:
 * используя бинарный поиск сравню Индекс (с большой буквы И, равный индекс + 1) опорного элемента с его значением:
 *
 * 1) Если значение опорного элемента больше его Индекса, значит отсутствующий элемент остался слева,
 * и для соседнего левого элемента сделаю: проверю совпадение Индекса с его значением,
 * если у него Индекс равен его значению, значит пропущенный элемент между этими двумя и его значение равно Индексу опорного.
 *
 * 2) Если значение опорного элемента равен Индексу, значит отсутствующий элемент находится справа,
 * и для соседнего правого элемента сделаю: проверю совпадение Индекса с его значением,
 * если у него Индекс меньше его значения, значит пропущенный элемент между этими двумя и равен Индексу этого элемента справа.
 *
 * 3) Если пропущенный элемент не найден, меняю опорный элемент по принципу бинарного поиска, и на следующей итерации
 * те же действия.
 */

class MissingNumber {

    public function find($row)
    {
        echo implode(", ", $row) . "<br>";

        $iteration = 0;
        $bigIndex = 1;
        $start = 0;
        $end = count($row) - 1;
        $length = $end - $start;

        while ($length > 0) {
            $iteration++;
            $pivotIndex = $start + floor($length/2);
            $pivotValue = $row[$pivotIndex];
            $bigIndex = $pivotIndex + 1;

            if ($pivotValue > $bigIndex) {
                $leftIndex = $pivotIndex - 1;
                $leftBigIndex = $leftIndex + 1;
                $leftValue = $row[$leftIndex];
                if ($leftValue == $leftBigIndex) {
                    return "итераций - " . $iteration . "<br>найдено слева от опорного отсутствующее число - " . $bigIndex;
                }
                $end = $pivotIndex - 1;
            }

            if ($pivotValue == $bigIndex) {
                $rightIndex = $pivotIndex + 1;
                $rightBigIndex = $rightIndex + 1;
                $rightValue = $row[$rightIndex];
                if ($rightBigIndex < $rightValue) {
                    return "итераций - " . $iteration . "<br>найдено справа от опорного отсутствующее число - " . $rightBigIndex;
                }
                $start = $pivotIndex + 1;
            }

            $length = $end - $start;
        }

        return "итераций - " . $iteration . "<br>отсутствующее число не найдено или по умолчанию равно - " . $bigIndex;
    }
}


$missing = new MissingNumber();
$row = [1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15, 16];
echo $missing->find($row);

echo "<br><br>";
$row = [1, 2, 3, 5, 6];
echo $missing->find($row);

echo "<br><br>";
$row = [1, 2, 4, 5, 6];
echo $missing->find($row);


echo "<br><br>";
$row = [1, 2, 3, 4, 5, 6, 7, 8, 9, 11];
echo $missing->find($row);


echo "<br><br>";
$row = [];
echo $missing->find($row);

echo "<br><br>";
$row = [1, 3];
echo $missing->find($row);

echo "<br><br>";
$row = [1, 2 ,3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 36];
echo $missing->find($row);

echo "<br><br>";
$row = [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
echo $missing->find($row);