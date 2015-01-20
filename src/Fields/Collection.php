<?php namespace Tobz\Autoform\Fields;

use IteratorAggregate;
use ArrayIterator;
use Countable;
use Tobz\Autoform\Contracts\FieldInterface;
use Tobz\Autoform\Contracts\CollectionInterface;
use Tobz\Autoform\Exceptions\InvalidFieldException;
use Tobz\Autoform\Exceptions\InvalidFieldSignatureException;

class Collection implements CollectionInterface
{
    protected $fields = [];

    /**
     * Create new Tobz\Autoform\Fields\Collection instance
     *
     * @param array $fields An array of Tobz\Autoform\Contracts\FieldInterface's or arrays
     *
     * @return Tobz\Autoform\Fields\Collection
     */
    public function __construct($fields = [])
    {
        foreach ($fields as $field) {
            $this->add($field);
        }

        return $this;
    }

    /**
     * Add a new field to the collection. $field must either be an instance of FieldInterface,
     * or an array with this footprint: ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra']
     *
     * @param Tobz\Autoform\Contracts\FieldInterface|array $field
     *
     * @return Tobz\Autoform\Fields\Collection
     */
    public function add($field)
    {
        if (is_array($field)) {
            $field = $this->createField($field);
        }

        if (!$field instanceof FieldInterface) {
            throw new InvalidFieldException('Cannot create field, Invalid Input');
        }

        $this->fields[$field->getId()] = $field;

        return $this;
    }

    /**
     * Check if a field exists
     *
     * @param  string  $value The name of the field
     *
     * @return boolean
     */
    public function has($value)
    {
        return array_key_exists($value, $this->fields);
    }

    /**
     * Get a field if it exists
     *
     * @param  string $value The name of the field
     *
     * @return Tobz\Autoform\Contracts\FieldInterface|null
     */
    public function get($value)
    {
        if (array_key_exists($value, $this->fields)) {
            return $this->fields[$value];
        } else {
            return null;
        }
    }

    /**
     * Merge another Collection into this one
     *
     * @param  Tobz\Autoform\Fields\Collection $collection
     *
     * @return Tobz\Autoform\Fields\Collection
     */
    public function merge(CollectionInterface $collection)
    {
        foreach ($collection->fields as $field) {
            $this->add($field);
        }

        return $this;
    }

    /**
     * Create a field from an array
     *
     * @param  array $fieldArray The array must have this signature: ['Field','Type','Null','Key','Default','Extra']
     *
     * @return Tobz\Autoform\Contracts\FieldInterface
     */
    public function createField($fieldArray)
    {

        // validate $fieldArray signature
        $requiredKeys = ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'];
        $fieldKeys = array_keys($fieldArray);
        sort($requiredKeys);
        sort($fieldKeys);

        if ($requiredKeys !== $fieldKeys) {
            throw new InvalidFieldSignatureException('Cannot create field, Invalid Field Input');
        }

        // guess field attributes
        $field = [
            'id' => $fieldArray['Field'],
            'name' => $fieldArray['Field'],
            'value' => $fieldArray['Default'],
            'required' => (boolean) ($fieldArray['Null']=="NO")
        ];

        // strip length
        $type = preg_replace('/\(.+$/ui', '', $fieldArray['Type']);

        // take an educated guess at the correct field type
        switch (strToLower($type)) {
            case 'tinyint':
                $field['type'] = $fieldArray['Key'] == 'PRI' ? 'hidden' : 'checkbox';
                return new CheckableField($field);
                break;

            case 'smallint':
            case 'mediumint':
            case 'integer':
            case 'int':
            case 'bigint':
            case 'float':
            case 'double':
            case 'double precision':
            case 'real':
            case 'decimal,':
            case 'numeric':
            case 'serial':
                if ($fieldArray['Key'] == 'PRI') {
                    $field['type'] = 'hidden';
                    return new InputField($field);
                } else {
                    $field['type'] = 'number';
                    $this->addMaxLength($field, $fieldArray['Type']);
                    return new InputField($field);
                }
                break;

            case 'datetime':
            case 'timestamp':
                $field['type'] = 'datetime';
                return new InputField($field);
                break;

            case 'timetz':
            case 'timestamptz':
                $field['type'] = 'datetime-local';
                return new InputField($field);
                break;

            case 'time':
                $field['type'] = 'time';
                return new InputField($field);
                break;

            case 'date':
            case 'year':
                $field['type'] = 'date';
                return new InputField($field);
                break;

            case 'enum':
            case 'set':

                // get options
                preg_match('/\((.+)\)$/', $fieldArray['Type'], $matches);
                $options = explode("','", trim($matches[1], "'"));
                $options = array_combine($options, $options);
                return new SelectField($field, $options);
                break;

            case 'blob':
            case 'text':
            case 'mediumblob':
            case 'mediumtext':
            case 'longblob':
            case 'longtext':
            case 'xml':
            case 'texetarea':
                $this->addMaxLength($field, $fieldArray['Type']);
                return new TextField($field, 'text');
                break;

            case 'uuid':
                if ($fieldArray['Key'] == 'PRI') {
                    $field['type'] = 'hidden';
                    return new InputField($field);
                } else {
                    $field['type'] = 'text';
                    $this->addMaxLength($field, $fieldArray['Type']);
                    return new InputField($field);
                }
                break;

            case 'char':
            case 'varchar':
            case 'tinyblob':
            default:
                $this->addMaxLength($field, $fieldArray['Type']);
                $field['type'] = in_array($type, InputField::$types) ? $type : 'text';
                return new InputField($field);
                break;
        }
    }

    public function addMaxLength(&$field, $type)
    {
        // get length
        if (preg_match('/\(([0-9]+)\)$/ui', $type, $matches)) {
            $field['maxlength'] = $matches[1];
        }
    }

    /**
     * Output all rendered Fields
     *
     * @return string
     */
    public function __toString()
    {
        $output = [];
        foreach ($this as $field) {
            $output[] = (string) $field;
        }

        return implode("\n", $output);
    }

    /**
     * Get a form field or attribute
     *
     * @param  string $value
     *
     * @return FieldInterface|null
     */
    public function __get($value)
    {
        return $this->get($value);
    }

    /**
     * Implement the IteratorAggregate interface
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->fields);
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
