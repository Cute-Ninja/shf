<?php

namespace App\Controller;

use App\Domain\DataInteractor\DataProvider\Tag\TagDataProvider;
use App\Domain\Entity\Tag\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WaitingController extends AbstractController
{
    /**
     * @Route(name="page-waiting", path="/", methods={"GET"})
     */
    public function index(\Swift_Mailer $mailer, TagDataProvider $dataProvider): Response
    {
        $tags = $dataProvider->getManyByCriteria(['status' => Tag::STATUS_ACTIVE]);

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('wod.plan@gmail.com')
            ->setTo('wod.plan@gmail.com')
            ->setBody(
                $this->renderView(
                    'emails/registration.html.twig',
                    ['name' => 'Quentin']
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->render('waiting/index.html.twig', ['tags' => $tags]);
    }
}
