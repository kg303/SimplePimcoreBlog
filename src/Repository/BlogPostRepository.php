<?php

namespace App\Repository;

use App\Service\BlogPostListingQueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Model\DataObject\BlogPost;
use Symfony\Component\HttpFoundation\Request;


class BlogPostRepository
{
    public function find($id): null|BlogPost
    {
        return BlogPost::getById($id);
    }

    public function paginate(Request $request, PaginatorInterface $paginator): PaginationInterface
    {
        $perPage = $request->get('perPage', 6);
        $page = $request->get('page', 1);

        $blogPosts = (new BlogPostListingQueryBuilder(new BlogPost\Listing(), $request))->getListing();

        return $paginator->paginate(
            $blogPosts,
            $page,
            $perPage
        );
    } 
}