<?php namespace Tobz\Autoform\Fields;

use Tobz\Autoform\Contracts\CheckableFieldInterface;
use Tobz\Autoform\Contracts\InputFieldInterface;
use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Fields\InputField;
use Exception;

class CheckableField extends InputField implements CheckableFieldInterface, InputFieldInterface, FieldInterface
{

    public static $types = ['checkbox', 'radio'];
    protected $isCheckable = true;
    protected $before = '<div class="checkbox-field">';
    protected $after = '</div>';

    /**
     * Set required attributes
     *
     * @param string|array $name       The Fields name, or an array of attributes
     * @param string $value
     * @param string $id
     * @param array $attributes        An array of attributes
     * @param string $type
     */
    public function __construct($name, $value = 1, $type = 'checkbox', $attributes = [])
    {
        if (is_array($name) && !array_key_exists('label', $name) && !array_key_exists('label', $attributes)) {
            $this->setLabel(ucwords(is_array($name) ? $name['name'] : $name));
        }

        $this->boot($name, $value, $type, $attributes);
    }

    public function renderField()
    {
        return sprintf(
            '<input type="%s" id="%s" name="%s" value="%s"%s%s />',
            $this->getType(),
            $this->getId(),
            $this->getName(),
            $this->getValue(),
            $this->isChecked()?' checked':'',
            $this->attributeString(['type', 'id', 'name', 'value', 'checked'])
        );
    }

    /**
     * Render the field
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s<div class="%s-field">%s %s</div>%s',
            $this->getBefore(),
            $this->getType(),
            $this->renderField(),
            $this->renderLabel(),
            $this->getAfter()
        );
    }

    /**
     * Set the fields value & maybe checked status
     *
     * @param string|array $value Either a string value of array ['value', 'checked']. eg: ['active', true]
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            $this->attributes['value'] = $value[0];
            $this->check((boolean) $value[1]);
        } else {
            $this->attributes['value'] = $value?:1;
        }

        return $this;
    }

    /**
     * Toggle checked status
     *
     * @param  boolean $value
     */
    public function check($value)
    {
        $this->attributes['checked'] = (boolean) $value;
    }

    /**
     * Get checked status
     *
     * @return boolean
     */
    public function isChecked()
    {
        return isset($this->attributes['checked']) && $this->attributes['checked'];
    }
}
