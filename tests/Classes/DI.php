<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Jawabkom\Standard\Contract\IDependencyInjector;

class DI implements IDependencyInjector
{

    public function make(string $type, array $arguments = []): mixed
    {
       return app()->make($type,$arguments);
    }
}