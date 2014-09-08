<?php namespace Tobz\Autoform\Traits;

trait FieldTrait
{

    protected $label = null;
    protected $before = '';
    protected $after = '';
    protected $booleanAttributes = [
        'spellcheck',
        'checked',
        'disabled',
        'draggable',
        'hidden',
        'novalidate',
        'readonly',
        'required',
    ];

    public function setId($value)
    {
        $this->attributes['id'] = $value;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setName($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;
    }

    public function getValue()
    {
        return $this->attributes['value'];
    }

    public function setLabel($value)
    {
        if (array_key_exists('label', $this->attributes)) {
            unset($this->attributes['label']);
        }

        $this->label = $value;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function wrap($before, $after = null)
    {
        if (is_array($before)) {
            $this->setBefore($before[0]);
            $this->setAfter($before[1]);
        } else {
            $this->setBefore($before);
            if ($after) {
                $this->setAfter($after);
            }
        }
    }

    public function setBefore($value)
    {
        $this->before = $value;
    }

    public function getBefore()
    {
        return $this->before;
    }

    public function setAfter($value)
    {
        $this->after = $value;
    }

    public function getAfter()
    {
        return $this->after;
    }

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
        // set the attributes array
        if (is_array($name)) {
            if (!isset($name['name'])) {
                throw new Exception('A name is required');
            }

            $this->attributes = $name + $this->attributes + $attributes;
        } else {
            $this->attributes = $attributes + $this->attributes;
        }

        // set the label
        if (array_key_exists('label', $this->attributes)) {
            $this->setLabel($this->attributes['label']);
            unset($this->attributes['label']);
        }

        // set the name
        if (!$this->getName()) {
            $this->setName($name ?: $this->attributes['name']);
        }

        // set the id
        if (!$this->getId()) {
            $this->setId($this->getName());
        }

        // set the value
        if ($value !== false || $this->getValue() !== false) {
            $this->setValue($value);
        }
    }

    /**
     * Render the fields label element
     *
     * @param  string $value Set the label
     *
     * @return string
     */
    public function renderLabel($attributes = [], $value = null)
    {
        if ($value) {
            $this->setLabel($value);
        }

        if ($this->label) {
            return sprintf(
                '<label for="%s"%s>%s</Label>',
                $this->getId(),
                $this->attributeString($attributes),
                $this->getLabel()
            );
        }
    }

    public function __toString()
    {
        $output = implode("\n", [
            $this->renderLabel(),
            $this->renderField(),
        ]);
        return trim($output, "\n");
    }

    /**
     * Generate an attribute string
     *
     * @param  array $attributes
     *
     * @return string
     */
    public function attributeString($exceptAttributes = [])
    {
        $output = [];
        foreach ($this->attributes as $key => $value) {
            if (!in_array($key, $exceptAttributes)) {
                // add filtered attribute
                if (in_array($key, $this->booleanAttributes)) {
                    if ($value === true) {
                        $output[] = $key;
                    }
                } else {
                    $output[] = $key.'="'.$value.'"';
                }
            }
        }

        if (count($output)) {
            return ' '.implode(' ', $output);
        }
    }

    /**
     * Is this a checkable field?
     *
     * @return boolean
     */
    public function isCheckable()
    {
        return $this->isCheckable;
    }

    /**
     * Is this a checkable field?
     *
     * @return boolean
     */
    public function isSelectable()
    {
        return $this->isSelectable;
    }
}
