<?php

/*
 * задание номер 1 - сложение длинных чисел
 */
class LongSummer {

    protected function getOperands($filename)
    {
        $operands = explode('#', file_get_contents($filename));
        $n1 = trim($operands[0]);
        $n2 = trim($operands[1]);
        
        $len1 = strlen($n1);
        $len2 = strlen($n2);

        // заполнить у меньшего числа старшие разряды нулями до выравнивания по длине с большим
        // (для сложения чисел столбиком)
        if ($len1 < $len2) {
            for ($i = 1; $i <= $len2 - $len1; $i++) {
                $n1 = "0" . $n1;
            }
        } else {
            for ($i = 1; $i <= $len1 - $len2; $i++) {
                $n2 = "0" . $n2;
            }
        }

        return [$n1, $n2];
    }

    // сложение столбиком
    public function calcSum($filename = 'sum.txt')
    {
        list($n1, $n2) = $this->getOperands($filename);

        $sum = '';
        $stack = new SplStack();
        $stack->push(0);

        // складываю справа налево (без реверса), начиная с младших разрядов
        for ($i = strlen($n1) - 1; $i >= 0; $i--) {
            // вытаскиваю старший образовавшийся разряд с предыдущего цикла
            $upper = $stack->pop();
            // сложить разряды и добавить старший разряд с предыдущего цикла
            $temp = $n1[$i] + $n2[$i] + $upper;

            if ($temp >= 10) {
                // если при сложении появился старший разряд, то в стек его
                $stack->push(1);
                $temp = $temp - 10;
            } else {
                // если не появился, значит он равен нулю
                $stack->push(0);
            }

            // добавляю цифры впереди
            $sum = $temp . $sum;
        }

        // на выходе из цикла если есть сташий разряд - то добавить впереди
        $upper = $stack->pop();
        if ($upper > 0) {
            $sum = $upper . $sum;
        }

        // вывод слагаемых и результата сложения
        echo $n1 . "<br>" . $n2 . "<br>" . $sum;
    }

}


$math = new LongSummer();
$math->calcSum();