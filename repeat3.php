<?php


/*
НЕ ВО ВСЕХ СЛУЧАЯХ РАБОТАЕТ (ГДЕ-ТО ОШИБКА в ЛОГИКЕ, не нашел, можно не засчитывать:)).

Найти кол-во повторений известного числа в отсортированном массиве.
 *
 * Алгоритм:
 * бинарным поиском нахожу первое попавшееся искомое число,
 * далее,
 * читаю значение предыдущего элемента,
 * читаю значение следующего элемента,
 *
 * если предыдущее равно искомому, то запускаю бинарный поиск для левой границы,
 * (в том поиске условие выхода из цикла - левый соседний не равен искомому)
 *
 * если следующий элемент равен искомому, то запускаю бинарный поиск для правой границы,
 * (в том поиске условие выхода из цикла - правый соседний не равен искомому)
 *
 * Число повторений считаю как правая граница минус левая.
 */



class Repetitions {

    protected $iteration = 0;

    // поиск первого опорного на совпадение искомому
    public function find($row, $search)
    {
        $start = 0;
        $end = count($row);
        $length = $end - $start;

        while ($length > 0) {

            $this->iteration++;

            $pivotIndex = $start + floor($length/2);
            $pivotValue = $row[$pivotIndex];

            if ($pivotValue === $search) {
                 return "Кол-во повторений числа " . $search . " = " . $this->getRepetitions($row, $search, $pivotIndex) . "<br>Всего итераций - " . $this->iteration;
            }

            if ($pivotValue > $search) {
                $end = $pivotIndex;
            }

            if ($pivotValue < $search) {
                $start = $pivotIndex;
            }

            $length = $end - $start;
        }

        return "Нет вхождений числа " . $search . "<br>Всего итераций " . $this->iteration;

    }


    // получить кол-во повторений
    protected function getRepetitions($row, $search, $pivotIndex)
    {
        $leftIndex = $pivotIndex - 1;
        $rightIndex = $pivotIndex + 1;

        if ($row[$pivotIndex - 1] === $search) {
            $newEnd = $leftIndex;
            $leftBord = $this->findLeft($row, $search, 0, $newEnd);
            if ($leftBord == -1) {
                $leftBord = $pivotIndex;
            }
        } else {
            $leftBord = $pivotIndex;
        }

        if ($row[$rightIndex] === $search) {
            $newEnd = count($row) - 1;
            $newStart = $rightIndex;
            $rightBord = $this->findRight($row, $search, $newStart, $newEnd);
            if ($rightBord == -1) {
                $rightBord = $pivotIndex;
            }
        } else {
            $rightBord = $pivotIndex;
        }

        return $rightBord - $leftBord + 1;
    }


    // поиск левой границы
    protected function findLeft($row, $search, $start, $end)
    {
        $length = $end - $start;

        while ($length > 0) {
            $this->iteration++;

            if (empty($pivotIndex)) {
                $pivotIndex = 0;
            }

            $newPivotIndex = $start + floor($length/2);
            if ($newPivotIndex > $pivotIndex) {
                $pivotIndex = $newPivotIndex;
            } else {
                $pivotIndex -= 1;
            }

            $pivotValue = $row[$pivotIndex];

            if ($pivotValue === $search) {
                if ($pivotIndex <= 0) {
                    return 0;
                }
                if ($row[$pivotIndex - 1] != $search) {
                    return $pivotIndex;
                }
                $end = $pivotIndex - 2;
            }

            if ($pivotValue < $search) {
                $start = $pivotIndex - 1;
            }

            $length = $end - $start;
        }

        return -1;
    }


    // поиск правой границы
    protected function findRight($row, $search, $start, $end)
    {
        $length = $end - $start;

        while ($length > 0) {
            $this->iteration++;

            if ($this->iteration > 25) {
                return -1;
            }

            if (empty($pivotIndex)) {
                $pivotIndex = 0;
            }

            $newPivotIndex = $start + floor($length/2);
            if ($newPivotIndex > $pivotIndex) {
                $pivotIndex = $newPivotIndex;
            } else {
                $pivotIndex -= 1;
            }

            $pivotValue = $row[$pivotIndex];
            if ($pivotValue === $search) {
                if ($pivotIndex >= (count($row) - 1)) {
                    return count($row) - 1;
                }
                if ($row[$pivotIndex + 1] != $search) {
                    return $pivotIndex;
                }
                $start = $pivotIndex + 1;
            }

            if ($pivotValue > $search) {
                $end = $pivotIndex;
            }

            $length = $end - $start;
        }

        return -1;
    }

}


$repetitions = new Repetitions();
$row = [1, 2, 3, 4, 5, 5, 5, 5, 5, 5, 5, 6, 7, 8, 9, 15];
$search = 5;
echo $repetitions->find($row, $search);
echo "<br><br>";

$row = [1, 2, 5, 5, 5, 5, 5, 5, 5, 6, 7, 8, 9, 15];
$search = 5;
echo $repetitions->find($row, $search);
echo "<br><br>";

$row = [1, 2, 3, 5, 5, 5, 5, 6, 7, 8, 9, 10, 11, 12, 13];
$search = 5;
echo $repetitions->find($row, $search);
echo "<br><br>";
