<?php

namespace App\Controller;

use App\Form\AddType;
use App\Entity\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductoController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $e)
    {
        $this->em = $e;
    }

    #[Route('/', name: 'ver_producto')]
    public function index(Request $request): Response
    {
        $producto = new Producto();
        $form = $this->createForm(AddType::class, $producto);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $numeroExistencias = (int) $producto->getExistencia();
            $producto->setExiste(0);
            if ($numeroExistencias) {
                $producto->setExiste(1);
            }
            $producto->setFecha(new \DateTime());
            $this->em->persist($producto);
            $this->em->flush();
            return $this->redirectToRoute('ver_producto');
        }
        $productos = $this->em->getRepository(Producto::class)->findAll();
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/borrar/{id}', name: 'borrar_producto', methods:['GET'])]
    public function borrar(int $id): Response
    {
        $producto = $this->em->getRepository(Producto::class)->find($id);
        $this->em->remove($producto);
        $this->em->flush();
        $productos = $this->em->getRepository(Producto::class)->findAll();
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
        ]); 
    }

    #[Route('/editar/{id}', name: 'editar_producto')]
    public function editar(Request $request, int $id, Producto $producto): Response
    {
        $form = $this->createForm(AddType::class, $producto);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $producto = $this->em->getRepository(Producto::class)->find($id);
            $numeroExistencias = (int) $producto->getExistencia();
            $producto->setExiste(0);
            if ($numeroExistencias) {
                $producto->setExiste(1);
            }
            $this->em->flush();
            return $this->redirectToRoute('ver_producto');
        }
        return $this->render('producto/editar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
