<?php

/*
 * Этот алгоритм как со словом "машина на уроке"
 */


class BalanceValidator {

    protected $allowedQuotes = ['"'];

    protected $openingBrackets = [
        '(' => ')',
        '[' => ']',
        '{' => '}'
    ];

    protected $originalString = '';
    protected $inputData = [];
    protected $stack;


    protected function setData($originalString)
    {
        $this->originalString = $originalString;
        $this->inputData = $this->getInputBrackets($originalString);
        $this->stack = new SplStack();
    }

    protected function getInputBrackets($originalString)
    {
        $inputData = [];
        for ($i = 0; $i < strlen($originalString); $i++) {
            $letter = mb_substr($originalString, $i, 1);
            if (in_array($letter, $this->openingBrackets) or array_key_exists($letter, $this->openingBrackets)) {
                array_push($inputData, $letter);
            }
            if (in_array($letter, $this->allowedQuotes)) {
                array_push($inputData, $letter);
            }
        }
        return $inputData;
    }

    protected function checkBalance($inputData, $stack)
    {
        for ($i = count($inputData) - 1; $i >= 0 ; $i--) {

            $letter = $inputData[$i];

            if (in_array($letter, $this->allowedQuotes)) {
                if ($stack->isEmpty()) {
                    $stack->push($letter);
                    continue;
                }
                if (in_array($stack->top(), $this->allowedQuotes)) {
                    $stack->pop();
                    continue;
                }
                $stack->push($letter);
                continue;
            }

            if (array_key_exists($letter, $this->openingBrackets)) {
                if ($stack->isEmpty()) {
                    return false;
                }
                if ($stack->top() === $this->openingBrackets[$letter]) {
                    $stack->pop();
                    continue;
                }
            }

            $stack->push($letter);
        }

        if (!$stack->isEmpty()) {
            return false;
        }

        return true;
    }


    public function renderResult($originalString)
    {
        $this->setData($originalString);

        $result = "Алгоритм №1 - нет баланса скобок";
        if ($this->checkBalance($this->inputData, $this->stack)) {
            $result = "Алгоритм №1 - есть баланс скобок";
        }

        echo $originalString . "<br>" . $result;
    }
}

