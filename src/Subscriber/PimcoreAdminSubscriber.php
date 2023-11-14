<?php

namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Service\Blog\BlogPostService;
use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Model\DataObject\BlogPost;

class PimcoreAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private BlogPostService $blogPostService
    )
    {

    }

    public static function getSubscribedEvents()
    {
        return [
            DataObjectEvents::PRE_UPDATE => [
                ['setBlogPostSEO', 10]
            ]
        ];
    }

    public function setBlogPostSEO(DataObjectEvent $event)
    {
        $object = $event->getObject();

        if (!$object instanceof BlogPost) {
            return;
        }

        $this->blogPostService->setSEO($object); 
    }
}