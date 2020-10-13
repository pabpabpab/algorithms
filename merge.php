<?php


/*
 * Сортирвка слиянием.
 * метод sort() - сортировка массива длиной меньше 3-х.
 * метод merge() - слияние двух отсортированных массивов любой длины.
 * метод sort3() - попытка собрвть все воедино. И кажется получилось!:)
 */




class MergeSorter {

    public function sort($row)
    {
        $start = 0;
        $end = count($row);
        $length = $end - $start;

        if ($length < 2) {
            return $row;
        }

        if ($length == 2) {
            if ($row[0] > $row[1]) {
                list($row[0], $row[1]) = [$row[1], $row[0]];
            }
            return $row;
        }
    }


    public function merge($a1, $a2)
    {
        $i1 = 0;
        $i2 = 0;
        $len1 = count($a1);
        $len2 = count($a2);
        $res = [];

        while(($i1 < $len1) and ($i2 < $len2)) {
            for($k = $i2; $k < $len2; $k++) {
                if ($a1[$i1] <= $a2[$k]) {
                    $res[] = $a1[$i1];
                    $i1++;
                    break;
                } else {
                    $res[] = $a2[$k];
                    $i2 = $k + 1;
                }
            }
        }

        if ($i2 < $len2) {
            for($k = $i2; $k < $len2; $k++) {
                $res[] = $a2[$k];
            }
        }

        if ($i1 < $len1) {
            for($k = $i1; $k < $len1; $k++) {
                $res[] = $a1[$k];
            }
        }

        return $res;
    }


    public function sort3($row)
    {
        if (count($row) < 5) {
            $newRow = array_chunk($row, 2);
            $a1 = $this->sort($newRow[0]);
            $a2 = $this->sort($newRow[1]);
            return $this->merge($a1, $a2);
        }

        $length = count($row);
        $size = ceil($length / 2);

        $newRow = array_chunk($row, $size);
        $a1 = $this->sort3($newRow[0]);
        $a2 = $this->sort3($newRow[1]);

        return $this->merge($a1, $a2);
    }
}


$sorter = new MergeSorter();
echo implode(", ", $sorter->sort3([15, 13, 7, 6, 9, 4, 5, 12]));
echo "<br><br>";






