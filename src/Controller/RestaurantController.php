<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    public function __construct(private RestaurantRepository $restaurantRepository)
    {
        # code...
    }

    #[Route('/restaurant', name: 'restaurant')]
    public function index(): Response
    {
        $restaurants = $this->restaurantRepository->findAll();
        return $this->render('restaurant/index.html.twig', [
            'restos' => $restaurants,
        ]);
    }

    #[Route('/restaurant/{id}', name: 'restaurant_details')]
    public function details(Restaurant $resto): Response
    {
        return $this->render('restaurant/details.html.twig', [
            'resto' => $resto
        ]);
    }
}
