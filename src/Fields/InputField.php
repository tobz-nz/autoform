<?php namespace Tobz\Autoform\Fields;

use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Fields\Field;
use Exception;

class InputField implements FieldInterface
{
    use \Tobz\Autoform\Traits\InputFieldTrait;

    static public $types = [
        'text',
        'password',
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
    public function __construct($name, $value = '', $type = 'text', $attributes = [])
    {
        $this->boot($name, $value, $type, $attributes);
    }

    /**
     * Render the field
     *
     * @return string
     */
    public function renderField()
    {
        return sprintf(
            '%s<input type="%s" id="%s" name="%s" value="%s"%s />%s',
            $this->getBefore(),
            $this->getType(),
            $this->getId(),
            $this->getName(),
            $this->getValue(),
            $this->attributeString(['type', 'id', 'name', 'value']),
            $this->getAfter()
        );
    }
}
