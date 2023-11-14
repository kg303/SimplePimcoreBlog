<?php

namespace App\DataMapper\Blog;

use App\DataMapper\AbstractDataMapper;
use Pimcore\Model\DataObject\BlogPost;


/**
* @propery BlogPostTag $resource
*/

class BlogPostTagDataMapper extends AbstractDataMapper
{
    public function toArray($request): array
    {

        return [
            'id' => $this->resource->getID(),
            'name' => $this->resource->getName()
        ];
    }
}