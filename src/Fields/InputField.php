<?php namespace Tobz\Autoform\Fields;

use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Fields\Field;
use Exception;

class InputField implements FieldInterface
{
    use \Tobz\Autoform\Traits\InputFieldTrait;

    protected $types = [
        'text',
        'image',
        'button',
        'submit',
        'search',
        'email',
        'url',
        'tel',
        'number',
        'range',
        'date',
        'month',
        'week',
        'time',
        'datetime',
        'datetime-local',
        'color',
    ];

    protected $attributes = [
        'id' => null,
        'name' => null,
        'value' => null,
        'type' => null,
    ];

    protected $isCheckable = false;
    protected $isSelectable = false;

    /**
     * Set required attributes
     *
     * @param string|array $name       The Fields name, or an array of attributes
     * @param string $value
     * @param string $id
     * @param array $attributes        An array of attributes
     * @param string $type
     */
    public function __construct($name, $value = '', $id = null, $attributes = [], $type = 'text')
    {
        $this->boot($name, $value, $id, $attributes, $type);
    }

    /**
     * Render the field
     *
     * @return string
     */
    public function renderField()
    {
        return sprintf(
            '<input type="%s" id="%s" name="%s" value="%s"%s />',
            $this->getType(),
            $this->getId(),
            $this->getName(),
            $this->getValue(),
            $this->attributeString(['type', 'id', 'name', 'value'])
        );
    }

    public function setType($value)
    {
        if (in_array($value, $this->types)) {
            $this->attributes['type'] = $value;
        }
    }

    public function getType()
    {
        return isset($this->attributes['type']) ? $this->attributes['type'] : null;
    }
}
