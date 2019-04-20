<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WaitingController extends AbstractController
{
    /**
     * @Route(name="page-waiting", path="/", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('waiting/index.html.twig');
    }
}