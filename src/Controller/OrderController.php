<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public function __construct(private OrderRepository $orderRepository)
    {
        # code...
    }

    #[Route('/orders', name: 'orders')]
    public function index(): Response
    {
        $orders = $this->orderRepository->findAll();
        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/orders/{id}', name: 'order_recap')]
    public function order_recap(Order $order): Response
    {
        return $this->render('order/details.html.twig', [
            'order' => $order
        ]);
    }
}
