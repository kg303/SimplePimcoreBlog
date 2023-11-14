<?php

namespace App\DataMapper\Blog;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Model\User;

/**
* @propery BlogPost $resource
*/

class BlogPostShowDataMapper extends AbstractDataMapper
{
    public function toArray($request): array
    {
        $postedBy = User::getById($this->resource->getPostedBy());

        $seoImage = $this->resource->getSeoImage();

        if (empty($seoImage)) {
            $seoImage = $this->resource->getImage();
        }

        return [
            'id' => $this->resource->getID(),
            'image' => $this->resource->getImage() ?->getImage(),
            'title' => $this->resource->getTitle(),
            'short_description' => $this->resource->getShortDescription(),
            'content' => $this->resource->getContent(),
            'posted' => $this->resource->getDate()->setTimezone('Europe/Berlin')->format('F j, Y'),
            'posted_by' => $postedBy->getFirstname(),
            'about' => $this->resource->getAbout(),
            'ad' => $this->resource->getAd(),
            'canonical_url' => $this->resource->getCannonicalUrl(),
            'seo_title' => $this->resource->getSeoTitle(),
            'seo_description' => $this->resource->getSeoDescription(),
            'og_url' => $this->resource->getOgUrl(),
            'og_locale' => $this->resource->getOgLocale(),
            'seo_image' => $seoImage ?->getImage(),
            'tags' => BlogPostTagDataMapper::list($this->resource->getTags())->all($request),
            'related_blog_posts' => RelatedBlogPostsDataMapper::list($this->resource->getRelatedBlogPosts())->all($request)
        ];
    }
}