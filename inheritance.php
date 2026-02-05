<?php

class BasicCalculator
{
    protected float $a;
    protected float $b;

    public function __construct(int|float $a, int|float $b)
    {
        $this->a = (float)$a;
        $this->b = (float)$b;
    }

    public function add(): float
    {
        return $this->a + $this->b;
    }

    public function subtract(): float
    {
        return $this->a - $this->b;
    }
}


class AdvancedCalculator extends BasicCalculator
{
    public function multiply(): float
    {
        return $this->a * $this->b;
    }

    public function divide(): float
    {
        if ($this->b == 0.0) {
            throw new DivisionByZeroError('Cannot divide by zero.');
        }
        return $this->a / $this->b;
    }
}

$basic = new BasicCalculator(10, 20);
echo "Add: " . $basic->add();        
echo "Subtract: " . $basic->subtract();

$adv = new AdvancedCalculator(10, 5);
echo "Multiply: " . $adv->multiply();
echo "Divide: " . $adv->divide(); 
