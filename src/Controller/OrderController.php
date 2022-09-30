<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Repository\OrderRepository;
use App\Services\CalcPriceService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

class OrderController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository,
        private EntityManagerInterface $em,
        private CalcPriceService $calcPriceService
    ) {
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
    #[Route('/orders/{id}', name: 'order_creation')]
    public function create(Menu $menu, Request $request): Response
    {
        $order = new Order();

        if ($request->getMethod() == Request::METHOD_POST) {
            // if ($request->get('menuId') == $menu->getId()) {
            $order->setCreatedAt(new DateTimeImmutable());
            $order->setOrderNumber(rand(1, 1200) . '-' . substr($menu->getName(), 0, 3) . '-' . $menu->getId());
            $order->addMenu($menu);
            $order->setPrice($menu->getPrice());
            $order->setStatus('created');
            $order->setUser($this->getUser());
            $this->em->persist($order);
            $this->em->flush();

            return $this->redirectToRoute('order_recap', ['id' => $order->getId()]);
            // }
        } else {
            throw new Exception('Page does not exist');
        }
    }

    #[Route('/order/{id}', name: 'order_recap')]
    public function order_recap(Order $order): Response
    {
        $percentage = 0.1;
        $percentage = $this->calcPriceService->calcPecentage($order->getPrice(), $percentage);
        $finalPrice = $this->calcPriceService->calcPrice($order->getPrice(), $percentage);
        return $this->render('order/details.html.twig', [
            'order' => $order,
            'percentage' => $percentage,
            'finalPrice' => $finalPrice
        ]);
    }
}
