<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/",  name="home")
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('base_vue.html.twig', []);
        // return $this->redirectToRoute('vue');
    }

    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(ads).*"}, name="vue")
     * @return Response
     */
    public function vueAction(): Response
    {
        return $this->render('base_vue.html.twig', []);
    }
}
