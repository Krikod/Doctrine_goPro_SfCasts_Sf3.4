<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
//        $filters = $em->getFilters()
//            ->enable('fortune_cookie_discontinued');
//        $filters->setParameter('discontinued', true);

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

        $fortunesData = $this->getDoctrine()
            ->getRepository('AppBundle:FortuneCookie')
            ->countNumberPrintedForCategory($category);
        $fortunesPrinted = $fortunesData['fortunesPrinted'];
        $averagePrinted = $fortunesData['fortunesAverage'];
        $categoryName = $fortunesData['name'];

//var_dump($fortunesPrinted);die;
        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunesPrinted' => $fortunesPrinted,
            'averagePrinted' => $averagePrinted,
            'categoryName' => $categoryName
        ]);
    }
}
