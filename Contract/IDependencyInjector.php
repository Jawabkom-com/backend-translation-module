<?php

namespace Jawabkom\Standard\Contract;

interface IDependencyInjector
{
    public function make(string $type, array $arguments = []):mixed;
}