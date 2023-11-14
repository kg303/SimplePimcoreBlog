<?php

namespace App\DataMapper\Blog;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;


/**
* @propery BlogPost $resource
*/

class RelatedBlogPostsDataMapper extends AbstractDataMapper
{
    public function toArray($request): array
    {

        $linkGenerator = $this->resource->getClass()->getLinkGenerator();

        return [
            'id' => $this->resource->getID(),
            'image' => $this->resource->getImage() ?->getImage(),
            'title' => $this->resource->getTitle(),
            'short_description' => $this->resource->getShortDescription(),
            'posted' => $this->resource->getDate()->setTimezone('Europe/Berlin')->format('F j, Y'),
            'slug' => $linkGenerator->generate($this->resource),
            'tags' => BlogPostTagDataMapper::list($this->resource->getTags())->all($request)
        ];
    }
}