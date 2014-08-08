<?php namespace Tobz\Autoform\Traits;

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
        if (in_array($value, $this->types)) {
            $this->attributes['type'] = $value;
        }
    }
}
