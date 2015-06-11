<?php namespace Tobz\Autoform\Contracts;

interface SelectFieldInterface extends FieldInterface
{
    /**
     * Get options
     *
     * @return array ['value' => 'text']
     */
    public function getOptions();

    /**
     * Set options
     *
     * @param array $options ['value' => 'text']
     *
     * @return Tobz\Autoform\SelectFieldInterface
     */
    public function setOptions(array $options);
}
