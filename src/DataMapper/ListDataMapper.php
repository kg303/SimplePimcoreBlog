<?php

namespace App\DataMapper;

final class ListDataMapper extends AbstractDataMapper
{
    protected string $classname;

    protected array $arguments;

    public function __construct(array $list, string $classname, array $arguments = [])
    {
        parent::__construct($list);

        $this->className = $classname;
        $this->arguments = $arguments;
    }

    public function toArray($request): array
    {
        return $this->all($request);
    }

    public function all($request)
    {
        $list = [];

        foreach ($this->resource as $data) {
            $list[] = (new $this->className($data, ...$this->arguments))->all($request);
        }

        return $list;
    }


}