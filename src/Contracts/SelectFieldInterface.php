<?php namespace Tobz\Autoform\Contracts;

interface SelectFieldInterface extends FieldInterface
{
    /**
     * Get options
     *
     * @return array ['value' => 'text']
     */
    public function getOptions();
}
