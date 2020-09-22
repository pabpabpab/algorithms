<?php

include_once ("balanceClass.php");

/*
 * Этот алгоритм:
 * делаю explode('"', $inputString) по кавычкам исходной строки,
 * пространство внутри кавычек не проверяю на баланс скобок,
 * пространство снаружи кавычек проверяю на баланс скобок по алгоритму "машина" на уроке
 */

class BalanceValidator2 extends BalanceValidator {


   protected function isEvenNumberOfQuotationMark($data)
   {
       $frequency = array_count_values($data);
       if ($frequency['"'] % 2 === 0) {
           return true;
       }
       return false;
   }


   protected function checkBracketsBalance($inputString)
   {
       if (empty($inputString)) {
           return true;
       }

       $stack = $this->stack;
       $brackets = str_split($inputString);

       for ($i = count($brackets) - 1; $i >= 0 ; $i--) {
           $bracket = $brackets[$i];
           if (array_key_exists($bracket, $this->openingBrackets)) {
               if ($stack->isEmpty()) {
                   return false;
               }
               if ($stack->top() === $this->openingBrackets[$bracket]) {
                   $stack->pop();
                   continue;
               }
           }
           $stack->push($bracket);
       }

       if (!$stack->isEmpty()) {
           return false;
       }

       return true;
   }

    protected function checkBalance2($inputData)
    {
        if (!$this->isEvenNumberOfQuotationMark($inputData)) {
            return false;
        }

        $inputString = implode('', $inputData);
        // делим исходные данные на куски по границам равным = '"'
        $chunks = explode('"', $inputString);

        foreach ($chunks as $key => $chunk) {
            // не проверяем нечетные куски текста,
            // т.к. это пространство заключенное в кавычки
            if ($key % 2 !== 0) {
                continue;
            }
            if (!$this->checkBracketsBalance($chunk)) {
                return false;
            }
        }

        return true;
    }


    public function renderResult($originalString)
    {
        $this->setData($originalString);

        $result = "Алгоритм №2 - нет баланса скобок";
        if ($this->checkBalance2($this->inputData)) {
            $result = "Алгоритм №2 - есть баланс скобок";
        }

        echo "<br>" . $result;
    }
}
