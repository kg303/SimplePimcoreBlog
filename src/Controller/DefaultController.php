<?php

namespace App\Controller;

use Pimcore\Bundle\AdminBundle\Controller\Admin\LoginController;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\BlogPost;
use App\DataMapper\Areas\LatestBlogPostsDataMapper;
use App\Website\LinkGenerator\BlogPostLinkGenerator;

class DefaultController extends FrontendController
{

    /**
     * @Route ("/testing-url", name="testing_url")
     */
    public function test(Request $request)
    {
        $test = BlogPost::getById(3);

        dd((new LatestBlogPostsDataMapper($test))->toArray($request));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('default/default.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function footerAction(Request $request): Response
    {
        return $this->render('include/footer.html.twig');
    }

    /**
     * Forwards the request to admin login
     */
    public function loginAction(): Response
    {
        return $this->forward(LoginController::class.'::loginCheckAction');
    }

    public function errorAction(Request $request): Response
    {
        return $this->render('error/404.html.twig');
    }
}
