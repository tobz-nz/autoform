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
    public function boot($name, $value = '', $id = null, $attributes = [], $type = 'text')
    {
        if (is_array($name)) {
            if (!isset($name['name'])) {
                throw new Exception('A name is required');
            }

            $this->attributes = array_merge($this->attributes, $name) + $attributes;
        } else {
            $this->attributes = array_merge($attributes, $this->attributes);
        }

        if (!$this->getType()) {
            $this->setType($type);
        }

        if (!$this->getName()) {
            $this->setName($name ?: $this->attributes['name']);
        }

        if ($id || !$this->getId()) {
            $this->setId($id?:$this->getName());
        }

        if ($value || !$this->getValue()) {
            $this->setValue($value);
        }
    }
}
