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
    public function __construct($name, $options, $value = '', $id = null, $attributes = [], $type = 'text')
    {
        $attributes = $this->attributes + $attributes; // Include default attribute
        $this->boot($name, $value, $id, $attributes, $type);
        $this->options = $options;
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
            $selected = ($this->attributes['value'] == $key ? ' selected' : '');
            $output[] = sprintf('<option value="%s"%s>%s</option>', $key, $selected, $value);
        }

        return implode("\n", $output);
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
