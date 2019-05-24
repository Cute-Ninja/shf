<?php

namespace App\Controller\Page;

use App\Domain\DataInteractor\DataProvider\Tag\TagDataProvider;
use App\Domain\Entity\Tag\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WaitingController extends AbstractController
{
    /**
     * @Route(name="page-waiting", path="/waiting", methods={"GET"})
     */
    public function index(TagDataProvider $dataProvider): Response
    {
        $tags = []; //$dataProvider->getManyByCriteria(['status' => Tag::STATUS_ACTIVE]);

        return $this->render('pages/waiting.html.twig', ['tags' => $tags]);
    }
}
