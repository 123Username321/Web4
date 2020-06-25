<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Feedback;
use App\Entity\Product;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product")
     */
    public function index(Request $request, $id)
    {
        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

        $form = $this->createFormBuilder()
            ->add('content', TextareaType::class, array('label' => 'Текст отзыва'))
            ->add('raiting', NumberType::class, array('label' => 'Рейтинг', 'attr' => ['min' => 1, 'max' => 5]))
            ->add('save', SubmitType::class, array('label' => 'Добавить отзыв'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $newFeedback = new Feedback();
            $newFeedback->setUserId($this->getUser());
            $newFeedback->setContent($form->getData()["content"]);
            $newFeedback->setRaiting((int)$form->getData()["raiting"]);
            $newFeedback->setProductId($product);
            $newFeedback->setAddDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($newFeedback);
            $em->flush();

            return $this->redirectToRoute('product', ['id' => $id]);
        }
    
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'title' => 'Главная',
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/{id}/delete", name="product_delete")
     */
    public function productDelete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getDoctrine()->getRepository(Product::class)->find($id));
        $em->flush();

        return $this->redirectToRoute('start_page');
    }

    /**
     * @Route("/product/{p_id}/feedback/{f_id}/delete", name="feedback_delete")
     */
    public function feedbackDelete(Request $request, $p_id, $f_id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getDoctrine()->getRepository(Feedback::class)->find($f_id));
        $em->flush();

        return $this->redirectToRoute('product', ['id' => $p_id]);
    }
}
