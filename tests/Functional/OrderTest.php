<?php

/**
 * I have not bothered with creating data fixtures or the usual structuring of tests
 * because of the time constraints on this assignment.
 */

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Order;
use App\Entity\Pizza;
use App\Entity\PizzaBottom;
use App\Entity\PizzaTopping;
use App\Entity\Pizzeria;
use App\Enum\OrderStatus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTest extends KernelTestCase
{
    public function testOrderAfterCreation()
    {
        $pizzeria = (new Pizzeria())->setName('Test');
        $topping = (new PizzaTopping())->setName('Topping 1');
        $bottom = (new PizzaBottom())->setName('Bottom 1');

        $order = new Order($pizzeria, new Pizza(bottom: $bottom, topping: $topping));

        $this->assertEquals(OrderStatus::NEW, $order->getStatus());
        $this->assertCount(1, $order->getPizzas());
    }
}
