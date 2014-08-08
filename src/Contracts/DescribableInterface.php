<?php namespace Tobz\Autoform\Contracts;

interface DescribableInterface
{

    /**
     * Describe The models fields
     *
     * @return Tobz\Autoform\Fields\Collection
     */
    public function describe();
}
