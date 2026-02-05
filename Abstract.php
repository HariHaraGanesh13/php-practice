<?php

Abstract class Visa{
  Public function visaPayment(){
	return "Payment Done";
  }

  abstract public function getPayment();
}

class BuyProduct extends Visa {
  public function getPayment(){
	return $this->visaPayment();
  }
}

$buyproduct = new BuyProduct();
echo $buyproduct->getpayment();
