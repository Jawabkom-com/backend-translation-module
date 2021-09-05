<?php

namespace Jawabkom\Standard\Abstract;

use Jawabkom\Standard\Contract\IService;

abstract class AbstractService implements IService
{
    private $input = [];
    private $output = [];

    protected function setOutput(string $key, mixed $value):static {
        $this->output[$key] = $value;
        return $this;
    }

    public function output(string $key): mixed
    {
        return $this->output[$key] ?? null;
    }

    public function outputs(): array
    {
        return $this->output;
    }

    public function input(string $key, mixed $value): static
    {
        $this->input[$key] = $value;
        return $this;
    }

    public function inputs(array $inputs):static
    {
        $this->input = array_merge($this->input, $inputs);
        return $this;
    }

    protected function getInput($key):mixed
    {
        return $this->input[$key] ?? null;
    }

}