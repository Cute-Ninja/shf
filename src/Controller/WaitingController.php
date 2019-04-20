<?php

namespace App\Controller;

use App\Entity\Tag;
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
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();

        return $this->render('waiting/index.html.twig', ['tags' => $tags]);
    }
}