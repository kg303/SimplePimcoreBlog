<?php

namespace App\Sitemaps;


use Pimcore\Model\DataObject\BlogPost;
use Pimcore\Sitemap\Element\AbstractElementGenerator;
use Pimcore\Sitemap\Element\GeneratorContext;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlogPostGenerator extends AbstractElementGenerator
{
    public function populate(UrlContainerInterface $urlContainer, string $section = null): void
    {
        if (null !== $section && $section !== 'blog_post') {
            // do not add entries if section doesn't match
            return;
        }

        $section = 'blog_post';

        $list = new BlogPost\Listing();
        $list->setOrderKey('date');
        $list->setOrder('DESC');

        // the context contains metadata for filters/processors
        // it contains at least the url container, but you can add additional data
        // with the params parameter
        $context = new GeneratorContext($urlContainer, $section);

        /** @var BlogPost $blogPost */
        foreach ($list as $blogPost) {
            // only add element if it is not filtered
            if (!$this->canBeAdded($blogPost, $context)) {
                continue;
            }

            // use a link generator to generate an URL to the article
            // you need to make sure the link generator generates an absolute url
            $link = $blogPost->getClass()->getLinkGenerator()->generate($blogPost, [
                'referenceType' => UrlGeneratorInterface::ABSOLUTE_URL
            ]);

            // create an entry for the sitemap
            $url = new UrlConcrete($link);

            // run url through processors
            $url = $this->process($url, $blogPost, $context);

            // processors can return null to exclude the url
            if (null === $url) {
                continue;
            }

            // Add the url to the container
            $urlContainer->addUrl($url, $section);
        }
    }
}