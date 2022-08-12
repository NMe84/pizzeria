<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Event\OrderStatusUpdateEvent;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route(path: '/admin', name: 'admin_')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route(path: '/', name: 'dashboard')]
    public function dashboard(Request $request, EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher): Response
    {
        $activeOrders = $em->getRepository(Order::class)->findAllActive();
        if ($request->isMethod('post')) {
            $newStatuses = $request->request->all('status');
            foreach ($activeOrders as $order) {
                if (array_key_exists($order->getId(), $newStatuses) && $newStatuses[$order->getId()] !== $order->getStatus()) {
                    $order->setStatus($newStatuses[$order->getId()]);
                    $eventDispatcher->dispatch(new OrderStatusUpdateEvent($order));
                }
            }
            $em->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin.html.twig', [
            'orders' => $activeOrders,
        ]);
    }
}