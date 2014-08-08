<?php namespace Tobz\Autoform\Fields;

use Tobz\Autoform\Contracts\InputFieldInterface;
use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Fields\Field;
use Exception;

class TextField implements InputFieldInterface, FieldInterface
{
    use \Tobz\Autoform\Traits\FieldTrait;

    protected $types = ['textarea'];

    protected $isCheckable = false;
    protected $isSelectable = false;

    protected $attributes = [
        'id' => null,
        'name' => null,
        'value' => null,
        'rows' => 5,
        'cols' => 30
    ];

    /**
     * Set required attributes
     *
     * @param string|array $name       The Fields name, or an array of attributes
     * @param string $value
     * @param string $id
     * @param array $attributes        An array of attributes
     * @param string $type
     */
    public function __construct($name, $value = '', $type = 'textarea', $attributes = [])
    {
        $attributes = $this->attributes + $attributes; // Include default attribute
        $this->boot($name, $value, 'textarea', $attributes);
    }

    /**
     * Render the field
     *
     * @return string
     */
    public function renderField()
    {
        return sprintf(
            '<textarea id="%s" name="%s"%s>%s</textarea>',
            $this->getId(),
            $this->getName(),
            $this->attributeString(['id', 'name', 'value']),
            $this->getValue()
        );
    }

    public function setType($value)
    {

    }

    public function getType()
    {
        return 'textarea';
    }
}
