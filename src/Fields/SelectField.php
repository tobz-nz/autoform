<?php namespace Tobz\Autoform\Fields;

use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Contracts\SelectFieldInterface;
use Tobz\Autoform\Fields\Field;
use Exception;

class SelectField implements FieldInterface, SelectFieldInterface
{
    use \Tobz\Autoform\Traits\FieldTrait;

    protected $isCheckable = false;
    protected $isSelectable = true;
    protected $hasEmptyValue = false;
    static public $types = ['select'];

    protected $attributes = [
        'id' => null,
        'name' => null,
        'value' => null
    ];

    protected $options = [];

    /**
     * Set required attributes
     *
     * @param string|array $name       The Fields name, or an array of attributes
     * @param array $options           Array of <options> ['value' => 'text']
     * @param string $value            Key of the selected option
     * @param string $id
     * @param array $attributes        An array of attributes
     * @param string $type
     */
    public function __construct($name, $options, $value = '', $attributes = [])
    {
        $attributes = $this->attributes + $attributes; // Include default attribute
        $this->boot($name, $value, 'select', $attributes);
        $this->options = $options;
    }

    /**
     * Set the hasEmptyValue setting
     *
     * @param  boolean  $value
     *
     * @return Tobz\Autoform\Fields\SelectField
     */
    public function hasEmptyValue($value)
    {
        $this->hasEmptyValue = $value;

        return $this;
    }

    /**
     * Render the field
     *
     * @return string
     */
    public function renderField()
    {
        return sprintf(
            "%s<select id=\"%s\" name=\"%s\"%s>\n%s\n</select>%s",
            $this->getBefore(),
            $this->getId(),
            $this->getName(),
            $this->attributeString(['id', 'name', 'value']),
            $this->renderOptions(),
            $this->getAfter()
        );
    }

    /**
     * Render the <options≥ markup
     *
     * @return string
     */
    public function renderOptions()
    {
        $output = [];
        foreach ($this->options as $key => $value) {
            $selected = ($this->isSelected($key) ? ' selected' : '');

            if ($key === 0 && $this->hasEmptyValue === true) {
                $output[] = sprintf('<option%s>%s</option>', $selected, $value);
            } else {
                $output[] = sprintf('<option value="%s"%s>%s</option>', $key, $selected, $value);
            }
        }

        return implode("\n", $output);
    }

    /**
     * Check if a key/value should be selected
     *
     * @param  string|array  $key
     *
     * @return boolean
     */
    public function isSelected($key)
    {
        $value = $this->getValue();

        if (is_array($value)) {
            return in_array($key, $value);
        }

        return $this->getValue() == $key;
    }

    /**
     * Get the options array
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
