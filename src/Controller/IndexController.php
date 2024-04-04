<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CartService $cartService
    ) {
        $this->productRepository = $productRepository;
        $this->cartService = $cartService;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/add-to-cart/{id}', name: 'app_add_cart')]
    public function addCart(Product $product): Response
    {
        $this->cartService->addToCart($product);

        return $this->redirectToRoute('app_index');
    }

    #[Route('/cart', name: 'app_cart')]
    public function showCart(): Response
    {
        return $this->render('index/cart.html.twig', [
            'cart' => $this->cartService->getCartDetails()[0],
            'total' => $this->cartService->getCartDetails()[1],
        ]);
    }

    #[Route('/remove-from-cart/{id}', name: 'app_remove_cart')]
    public function removeCart(Product $product): Response
    {
        $this->cartService->removeFromCart($product);

        return $this->redirectToRoute('app_cart');
    }
}
