<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Feedback;
use App\Entity\Product;
use DateTimeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StartPageController extends AbstractController
{
    
    /**
     * @Route("/", name="start_page")
     */
    public function index(Request $request)
    {
        $products = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();

        if (count($products) > 1) {
            usort($products, function ($a, $b) {
                if ($a->getAddDate() == $b->getAddDate()) {
                    return 0;
                }
                return ($a->getAddDate() < $b->getAddDate()) ? -1 : 1;
            });
        }

        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => 'Название товара'))
            ->add('description', TextareaType::class, array('label' => 'Описание товара'))
            ->add('save', SubmitType::class, array('label' => 'Добавить товар'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newProduct = new Product();
            $newProduct->setName($form->getData()["name"]);
            $newProduct->setDescription($form->getData()["description"]);
            $newProduct->setRaiting(0);
            $newProduct->setAddDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newProduct);
            $em->flush();

            return $this->redirectToRoute('start_page');
        }

        return $this->render('start_page/index.html.twig', [
            'controller_name' => 'StartPageController',
            'title' => 'Главная',
            'products' => $products,
            'form' => $form->createView()
        ]);
    }
}
