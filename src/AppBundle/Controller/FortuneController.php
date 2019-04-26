<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FortuneController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $categories = $repo->findAllOrdered();

//        //*** Search toolbar, after adding param Request $request
        $search = $request->query->get('q');
        if ($search) {
            $categories = $repo->search($search);
        } else {
            $categories = $repo->findAllOrdered();
        }

        return $this->render('fortune/homepage.html.twig', array(
            'categories' => $categories
        ));
    }     //***

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function showCategoryAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Category');

        $category = $categoryRepository->findWithFortunesJoin($id);

        if (!$category) {
            throw $this->createNotFoundException();
        }

        $fortunesPrinted = $this->getDoctrine()
            ->getRepository('AppBundle:FortuneCookie')
            ->countNumberPrintedForCategory($category);
//var_dump($fortunesPrinted);die();
        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunesPrinted' => $fortunesPrinted
        ]);
    }
}
