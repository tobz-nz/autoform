<?php namespace Tobz\Autoform\Contracts;

use Tobz\Autoform\Contracts\CollectionInterface;

interface CollectionInterface extends \IteratorAggregate, \Countable
{
    public function __construct($fields = []);

    /**
     * Add a new field to the collection. $field must either be an instance of FieldInterface, or an array with this footprint: ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra']
     *
     * @param Tobz\Autoform\Contracts\FieldInterface|array $field
     *
     * @return Tobz\Autoform\Contracts\CollectionInterface
     */
    public function add($field);

    /**
     * Merge another Collection into this one
     *
     * @param  Tobz\Autoform\Contracts\CollectionInterface $collection
     *
     * @return Tobz\Autoform\Contracts\CollectionInterface
     */
    public function merge(CollectionInterface $collection);

    /**
     * Create a field from an array
     *
     * @param  array $fieldArray The array must have this footprint: ['Field','Type','Null','Key','Default','Extra']
     *
     * @return Tobz\Autoform\Contracts\FieldInterface
     */
    public function createField($fieldArray);

    /**
     * Get a form field or attribute
     *
     * @param  string $value
     *
     * @return Tobz\Autoform\Contracts\FieldInterface|null
     */
    public function __get($value);

    public function __toString();
}
