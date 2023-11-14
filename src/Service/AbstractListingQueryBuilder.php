<?php

namespace App\Service;

use Pimcore\Model\Listing\AbstractListing;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractListingQueryBuilder
{
    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $query;

    public function __construct(
        private AbstractListing $listing,
        private Request $request
    )
    {
        $this->listing->onCreateQueryBuilder(function (QueryBuilder $builder) {
            $this->query = $builder;

            $this->addQueryBefore();

            foreach ($this->all() as $key => $value) {
                $method = $this->getMethodName($key);

                if (!method_exists($this, $method) || !is_callable([$this, $method])) {
                    continue;
                }

                //testParameter
                call_user_func([$this, $method], $value);
            }


            $this->addQueryAfter();
        });
    }

    protected function all(): array
    {
        return array_merge(
            $this->request->request->all(),
            $this->request->query->all(),
            $this->request->attributes->all()    
        );
    }

    private function getMethodName($key): string
    {

        //test_name_parameter
        //TestNameParameter

        return lcfirst(
            implode('',
                array_map(function ($part) {
                    return ucfirst($part);
                }, explode('_', $key))
            )
        );
    }

    public function __call(string $name, array $arguments): array|AbstractListing
    {
        return call_user_func_array([$this->listing, $name], $arguments);
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->listing->getQueryBuilder();
    }

    public function getListing(): AbstractListing
    {
        return $this->listing;
    }

    protected function sortBy($sortBy) 
    {
        //?sortBy=name-desc

        $elements = explode('-', $sortBy);
        $sortOrder = array_pop($elements);
        $sortBy = strtolower(implode('-', $elements));

        if (!in_array($sortOrder, ['asc', 'desc']) || empty($sortBy)) {
            return;
        }

        $method = 'sortBy'.ucwords($sortBy); 

        if (method_exists($this, $method) && is_callable([$this, $method])) {
            $this->{$method}($sortOrder);
        }

    }

    protected function addQueryBefore()
    {
        
    }

    protected function addQueryAfter()
    {

    }

   
}