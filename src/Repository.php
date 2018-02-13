<?php

namespace Oghouz\RepoGenerate;

class Repository
{
    /**
     *  The model using for repository.
     *
     * @var
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
