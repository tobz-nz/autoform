<?php namespace Tobz\Autoform\Traits;

use Exception;

trait InputFieldTrait
{
    use FieldTrait;

    /**
     * Set required attributes
     *
     * @param string|array $name       The Fields name, or an array of attributes
     * @param string $value
     * @param string $id
     * @param array $attributes        An array of attributes
     * @param string $type
     */
    public function boot($name, $value = '', $type = 'text', $attributes = [])
    {
        if (is_array($name)) {
            if (!isset($name['name'])) {
                throw new Exception('A name is required');
            }

            $this->attributes = $name + $attributes + $this->attributes;
        } else {
            $this->attributes = $attributes + $this->attributes;
        }

        if (!$this->getType()) {
            $this->setType($type);
        }

        if (!$this->getName()) {
            $this->setName($name);
        }

        // set the label
        if (array_key_exists('label', $this->attributes)) {
            $this->setLabel($this->attributes['label']);
            unset($this->attributes['label']);
        }

        if (!$this->getId()) {
            $this->setId($this->getName());
        }

        if ($value) {
            $this->setValue($value);
        }
    }

    /**
     * Set the type. Can only be from defined values
     *
     * @param string $value
     */
    public function setType($value)
    {
        if (in_array($value, $this->getTypes())) {
            $this->attributes['type'] = $value;
        }

        return $this;
    }

    /**
     * Get the type
     *
     * @return string
     */
    public function getType()
    {
        return isset($this->attributes['type']) ? $this->attributes['type'] : null;
    }
}
