<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FortuneController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction()
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $categories = $repo->findAll();

        return $this->render('fortune/homepage.html.twig', array(
            'categories' => $categories
        ));
    }
}
