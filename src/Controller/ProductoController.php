<?php

namespace App\Controller;

use App\Entity\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $e)
    {
        $this->em = $e;
    }

    #[Route('/', name: 'ver_producto')]
    public function index(): Response
    {
        $productos = $this->em->getRepository(Producto::class)->findAll();
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
        ]);
    }
}
