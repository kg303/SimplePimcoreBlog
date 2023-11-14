<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends FrontendController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        return $this->render('home/index.html.twig');
    }

}
