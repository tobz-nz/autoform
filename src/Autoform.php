<?php namespace Tobz\Autoform;

use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Contracts\TextFieldInterface;
use Tobz\Autoform\Contracts\InputFieldInterface;
use Tobz\Autoform\Contracts\SelectFieldInterface;
use Tobz\Autoform\Contracts\DescribableInterface;
use Tobz\Autoform\Fields\Collection;
use IteratorAggregate;
use Countable;

class Autoform implements IteratorAggregate, Countable
{

    private $fields;
    private $attributes = [
        'action' => '',
        'method' => 'post',
    ];

    /**
     * Create instance
     *
     * @param array $attributes                          Attributes for the form element
     * @param Tobz\Autoform\Fields\Collection $fields    A Collection of fields
     */
    public function __construct($attributes = [], $fields = null)
    {
        $this->attributes = $attributes + $this->attributes;

        // add/create fields
        if ($fields instanceof Collection) {
            $this->fields = $fields;
        } else {
            $this->fields = new Collection();
        }
    }

    /**
     * Generate an attribute string
     *
     * @param  array $attributes
     *
     * @return string
     */
    public function attributeString($attributes)
    {
        $output = [];
        foreach ($attributes as $key => $value) {
            $output[] = $key.'="'.$value.'"';
        }

        if (count($output)) {
            return ' '.implode(' ', $output);
        }
    }

    /**
     * Open the form
     *
     * @param  array $attributes
     *
     * @return string
     */
    public function open($attributes = [], $sendFiles = false)
    {
        $attributes = array_merge($attributes, $this->attributes);

        if ($sendFiles) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        return sprintf("<form%s>\n", $this->attributeString($attributes));
    }

    /**
     * Close the form
     *
     * @param  string $after
     *
     * @return string
     */
    public function close()
    {
        return "</form>\n";
    }

    /**
     * Add a field
     *
     * @param Tobz\Autoform\Contracts\FieldInterface $field
     */
    public function add(FieldInterface $field)
    {
        $this->fields->add($field);
    }

    /**
     * Bind a Describable objects fields
     *
     * @param Tobz\Autoform\Contracts\DescribableInterface $model
     *
     * @return Autoform
     */
    public function bind(DescribableInterface $model)
    {
        foreach ($model->describe() as $field) {
            $this->add($newFIeld);
        }

        return $this;
    }

    /**
     * Get all or a subset of the forms fields
     *
     * @param  array $list list of field id's get
     *
     * @return array
     */
    public function getFields($list = [])
    {
        $output = [];
        foreach ($this->fields as $field) {
            if (!count($list) || in_array($field->getName(), $list)) {
                $output[] = $field;
            }
        }

        return $output;
    }

    /**
     * Render the forms fields
     *
     * @param  array $renderList list of field id's to render
     *
     * @return string
     */
    public function renderFields($renderList = [])
    {
        $output = $this->getFields($renderList);
        return implode("\n", $output);
    }

    /**
     * Output the whole form in one go
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s\n%s\n%s", [
            $this->open(),
            $this->fields(),
            $this->close()
        ]);
    }

    /**
     * Get a form field or attribute
     *
     * @param  string $value
     *
     * @return FieldInterface|string|null
     */
    public function __get($value)
    {
        if (array_key_exists($value, $this->fields)) {
            // find field & return it
            return (string) $this->fields[$value];
        } elseif (array_key_exists($value, $this->attributes)) {
            // else find a form attribute & return it
            return $this->attributes[$value];
        } else {
            return null;
        }
    }

    /**
     * Implement the IteratorAggregate interface
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return $this->fields->getIterator();
    }

    /**
     * Implement the Countable interface
     *
     * @return integer
     */
    public function count()
    {
        return count($this->fields);
    }
}
