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
        'multiple',
        'required',
    ];

    public function getTypes()
    {
        return static::$types;
    }

    public function setId($value)
    {
        $this->attributes['id'] = $value;

        return $this;
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setName($value)
    {
        $this->attributes['name'] = $value;

        return $this;
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
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

        return $this;
    }

    public function getLabel()
    {
        if ($this->getType() !== 'hidden') {
            return ucwords(str_replace('_', ' ', $this->label));
        }
    }

    public function wrap($before, $after = null)
    {
        if (is_array($before)) {
            $this->setBefore($before[0]);
            if (count($before)===2) {
                $this->setAfter($before[1]);
            }
        } else {
            $this->setBefore($before);
            if ($after) {
                $this->setAfter($after);
            }
        }

        return $this;
    }

    /**
     * Add a class to the class attribute
     *
     * @param string $class
     *
     * @return Tobz\Autoform\Contracts\FieldInterface
     */
    public function addClass($class)
    {
        if (!isset($this->attributes['class'])) {
            $this->attributes['class'] = $class;
        } else {
            $classes = explode(' ', $this->attributes['class']);
            if (!in_array($class, $classes)) {
                $this->attributes['class'] += " $class";
            }
        }

        return $this;
    }

    /**
     * Check if the field has the given classname
     *
     * @param  string  $class The class to check
     *
     * @return boolean
     */
    public function hasClass($class)
    {
        return isset($this->attributes['class']) && in_array($class, explode(' ', $this->attributes['class']));
    }

    /**
     * Remove a class from the class attribute
     *
     * @param  string $class
     *
     * @return Tobz\Autoform\Contracts\FieldInterface
     */
    public function removeClass($class)
    {
        if (isset($this->attributes['class'])) {
            $classes = explode(' ', $this->attributes['class']);
            $key = array_search($class, $classes);

            if ($key!==false) {
                unset($classes[$key]);
                $this->attributes['class'] = implode(' ', $classes);
            }
        }

        return $this;
    }

    public function setBefore($value)
    {
        $this->before .= $value;

        return $this;
    }

    public function getBefore()
    {
        return $this->before;
    }

    public function setAfter($value)
    {
        $this->after .= $value;

        return $this;
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
                $this->attributeString([], $attributes),
                $this->getLabel()
            );
        }
    }

    public function __toString()
    {
        try {
            $output = implode("\n", [
                $this->renderLabel(),
                $this->renderField(),
            ]);
            return trim($output, "\n");
        } catch (\Exception $e) {
            dd($e->getMessage() .' '. $e->getFile() .' #'. $e->getLine());
        }
    }

    /**
     * Generate an attribute string
     *
     * @param  array $attributes
     *
     * @return string
     */
    public function attributeString($exceptAttributes = [], $attributes = null)
    {
        $output = [];
        if ($attributes === null) {
            $attributes = $this->attributes;
        }

        foreach ($attributes as $key => $value) {
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

    /**
     * handle misc set* methods to set attributes
     *
     * @param  string $method The method name
     * @param  mixed $input  The method input
     *
     * @return Tobz\Autoform\Contracts\FieldInterface
     */
    public function __call($method, $input)
    {
        if (preg_match('/^set([A-Z][a-z]*)/ui', $method, $matches)) {
            $attribute = $matches[1];
            $this->attributes[strtolower($attribute)] = current($input);
        }

        return $this;
    }
}
