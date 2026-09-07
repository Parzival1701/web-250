<?php
class Guitar
{
    public string $brand;
    protected float $price;
    public function  setPrice(float $amount): void
    {
        $this->price = $amount;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }
}

$guitar = new Guitar();
$guitar->setBrand("Fender");
$guitar->setPrice(800);

echo $guitar->brand . " guitar costs $" . $guitar->getPrice();

class ElectricGuitar extends Guitar
{
    public function applyDiscount(float $percent): void
    {
        $discount = $this->price * ($percent / 100);
        $this->price = $this->price - $discount;
    }
}

$electric = new ElectricGuitar();
$electric->setBrand("Gibson");
$electric->setPrice(1200);
$electric->applyDiscount(10);

echo "<br>";
echo $electric->getBrand() . " guitar now costs $" . $electric->getPrice();
