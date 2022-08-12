<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Pizza;
use App\Entity\PizzaBottom;
use App\Entity\PizzaTopping;
use App\Entity\Pizzeria;
use App\Form\Type\OrderType;
use App\Form\Type\PizzaSelectionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function home(Request $request): Response
    {
        $form = $this->createForm(PizzaSelectionType::class, null, ['mapped' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('order', [
                'pizzeria' => $data['pizzeria']->getId(),
                'topping' => $data['topping']->getId(),
                'bottom' => $data['bottom']->getId(),
            ]);
        }
        return $this->render('home.html.twig', [
            'form' => $form->createView(),
            'orderPlaced' => $request->query->has('thanks'),
        ]);
    }

    #[Route(path: '/order/{pizzeria}/{topping}/{bottom}', name: 'order')]
    public function order(Request $request, Pizzeria $pizzeria, PizzaTopping $topping, PizzaBottom $bottom, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OrderType::class,
            (new Order($pizzeria, new Pizza(bottom: $bottom, topping: $topping)))->setDelivery(!$pizzeria->isPickup()),
            [
                'allow_delivery' => $pizzeria->isDelivery(),
                'allow_pickup' => $pizzeria->isPickup()
            ],
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Order $order */
            $order = $form->getData();
            foreach ($order->getPizzas() as $pizza) {
                $em->persist($pizza);
            }
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('home', ['thanks' => true]);
        }

        return $this->render('order.html.twig', [
            'pizzeria' => $pizzeria,
            'topping' => $topping,
            'bottom' => $bottom,
            'order' => $form->getData(),
            'form' => $form->createView(),
        ]);
    }
}