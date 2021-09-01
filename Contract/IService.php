<?php

namespace Jawabkom\Standard\Contract;

interface IService
{
    public function process():static;

    public function input(string $key, mixed $value): static;

    public function output(string $key):mixed;
}