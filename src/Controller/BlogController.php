<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\DataMapper\Blog\BlogPostCategoryDataMapper;
use App\DataMapper\Blog\BlogPostListingDataMapper;
use App\DataMapper\Pagination\PaginationDataMapper;
use App\Repository\BlogPostCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\BlogPost;
use App\DataMapper\Pagination\PaginatorDataMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\DataMapper\Blog\BlogPostShowDataMapper;

class BlogController extends FrontendController
{
    public function __construct(
        private BlogPostRepository $blogPostRepository,
        private BlogPostCategoryRepository $blogPostCategoryRepository
    )
    {

    }

    /**
     * @Route("/blog", name="blog_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        $paginator = $this->blogPostRepository->paginate($request, $paginator);
        $blogPostCategories = $this->blogPostCategoryRepository->all();

        $paginatorData = (new PaginatorDataMapper($paginator))->toArray($request);
        $blogPostsData = BlogPostListingDataMapper::list([...$paginator->getItems()])->all($request);
        $blogPostCategoriesData = BlogPostCategoryDataMapper::list($blogPostCategories)->all($request);

        return $this->render('blog/index.html.twig', [
            'paginator' => $paginatorData,
            'blog_posts' => $blogPostsData,
            'blog_post_categories' => $blogPostCategoriesData,
        ]);
    }

    /**
     * @Route ("/blog/{slug}--{blogPostId}", name="blog_post_show", requirements={"slug"="[\w-]+", "blogPostId"="\d+"})
     * @param Request $request
     * @param int $blogPostId
     * @return Response
     * @throws \Exception
     */

    public function showAction(
        Request $request,
        int $blogPostId
    )
    {
        $blogPost = $this->blogPostRepository->find($blogPostId);

        if (empty($blogPost)) {
            throw new \Exception('No blog post found');
        }

        return $this->render('blog/show.html.twig',
            [
                'blog_post' => (new BlogPostShowDataMapper($blogPost))->toArray($request)
            ]
        );
    }

}
