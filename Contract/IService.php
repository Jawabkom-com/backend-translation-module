<?php

namespace Jawabkom\Standard\Contract;

interface IService
{
    public function process():static;

    public function input(string $key, mixed $value): static;

    public function inputs(array $inputs):static;

    public function output(string $key):mixed;

    public function outputs(): array;
}