<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\RestaurantRepository;
use App\Repository\ReviewRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    public function __construct(
        private RestaurantRepository $restaurantRepository,
        private EntityManagerInterface $em,
        private ReviewRepository $reviewRepository
    ) {
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
    public function details(Restaurant $resto, Request $request): Response
    {
        $menus = $resto->getMenu();
        return $this->render('restaurant/details.html.twig', [
            'resto' => $resto,
            'menus' => $menus
        ]);
    }


    #[Route('api/restaurants/{lat}/{lon}', name: 'restos')]
    public function api_resto($lat, $lon, Request $request): Response
    {
        $restaurants = $this->restaurantRepository->findByLatLon($lat, $lon);
        $review = new Review();
        $rateForm = $this->createForm(ReviewType::class, $review)->handleRequest($request);
        foreach ($restaurants as $resto) {
            $userReview = $this->reviewRepository->findByUserAndresto($resto, $this->getUser());
            if (!$userReview) {
                if ($request->getMethod() == Request::METHOD_POST) {
                    if ($request->get('restoId') == $resto->getId()) {
                        $rate = trim($request->get('rate'));
                        $review->setCreatedAt(new DateTimeImmutable());
                        $review->setUser($this->getUser());
                        $review->setRestaurant($resto);
                        $review->setRate($rate);
                        $this->em->persist($review);
                        $this->em->flush();
                        return $this->redirectToRoute('restos', ['lat' => $resto->getLattitude(), 'lon' => $resto->getLongitude()]);
                    }
                };
            }
        }

        return $this->render('restaurant/restos.html.twig', [
            'restos' => $restaurants,
            'rateForm' => $rateForm->createView(),
        ]);
    }
}
