<?php

/*
 * НЕ СДЕЛАНО.
 * Все что придумал это найти минимальные делитель,
 * из него получить максимальный делитель, как диапазон поиска.
 */


class SimpleNumber {

    public function isSimple($num)
    {
         $half = ($num - 1) / 2;
         for ($i = 3; $i < $half; $i += 2) {
             if ($num % $i === 0) {
                 return false;
             }
         }
         return true;
    }

    public function getMinimumDivider($N)
    {
        $limit = (($N - 1) / 2) - 1;
        for ($d = 3; $d <= $limit; $d += 2) {
            if ($N % $d === 0) {
                return $d;
            }
        }
        return 0;
    }

    public function getMaxSimpleDivider($N)
    {
        $minimumDivider = $this->getMinimumDivider($N);
        $searchLimit = $N/$minimumDivider;

        for ($d = $searchLimit; $d >= $minimumDivider; $d -= 2) {
            if ($N % $d === 0) {
                if ($this->isSimple($d)) {
                    return $d;
                }
            }
        }
        return 0;
    }
}



$start = microtime(true);
$before = memory_get_usage();


$numbers = new SimpleNumber();
//echo $numbers->getMaxSimpleDivider(600851475143);
echo $numbers->getMaxSimpleDivider(213);

echo "<br>";
echo microtime(true) - $start;
echo " ms<br>";
echo memory_get_usage() - $before;


