<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route(name="page-app", path="/", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('pages/app.html.twig');
    }
}
