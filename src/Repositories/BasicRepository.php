<?php

namespace Jawabkom\Backend\Module\Translation\Repositories;

use Illuminate\Database\Eloquent\Model;
use Jawabkom\Standard\Contract\IRepository;

abstract class BasicRepository implements IRepository
{

    protected Model $model;

    public function __construct(Model $model)
    {

        $this->model = $model;
    }
}