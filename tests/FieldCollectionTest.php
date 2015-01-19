<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\Collection;
use Tobz\Autoform\Fields\InputField;

class FieldCollectionTest extends \PHPUnit_Framework_TestCase
{

    public $fieldArray = [
        'Field' => 'test1',
        'Type' => "varchar(50)",
        'Null' => 'NO',
        'Key' => '',
        'Default' => '',
        'Extra' => ''
    ];

    public function testNewCollection()
    {
        $collection = new Collection([
            ['Field' => 'test1'] + $this->fieldArray,
            ['Field' => 'test2'] + $this->fieldArray
        ]);
        $this->assertCount(2, $collection);
    }

    public function testCollectionAdd()
    {
        $this->fieldArray = [
            'Field' => 'test1',
            'Type' => "enum('user','admin')",
            'Null' => 'NO',
            'Key' => '',
            'Default' => '',
            'Extra' => ''
        ];

        $collection = new Collection([
            ['Field' => 'test1'] + $this->fieldArray,
            ['Field' => 'test2'] + $this->fieldArray
        ]);
        $this->assertCount(2, $collection);

        $collection->add(new InputField('field3'));
        $this->assertCount(3, $collection);
    }

    public function testFieldAccessor()
    {
        $collection = new Collection([['Field' => 'test1'] + $this->fieldArray]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->test1);
    }

    public function testHasField()
    {
        $collection = new Collection([['Field' => 'test1'] + $this->fieldArray]);
        $this->assertTrue($collection->has('test1'));
        $this->assertFalse($collection->has('test2'));
    }

    public function testGetField()
    {
        $collection = new Collection([['Field' => 'test1'] + $this->fieldArray]);
        $this->assertInstanceOf('Tobz\Autoform\Contracts\FieldInterface', $collection->get('test1'));
        $this->assertNull($collection->get('test2'));
    }

    /**
     * @expectedException     \Tobz\Autoform\Exceptions\InvalidFieldException
     */
    public function testNewCollectionInvalidFieldException()
    {
        $collection = new Collection(['invalid field declaration']);
    }

    /**
     * @expectedException     \Tobz\Autoform\Exceptions\InvalidFieldSignatureException
     */
    public function testNewCollectionInvalidFieldSignatureException()
    {
        $collection = new Collection([['invalid field declaration']]);
    }

    /**
     * @expectedException     \Tobz\Autoform\Exceptions\InvalidFieldSignatureException
     */
    public function testCollectionAddInvalidFieldArrayException()
    {
        $collection = new Collection();
        $collection->add(['invalid']);
    }

    public function testCollectionMerge()
    {
        $collection1 = new Collection([['Field' => 'test1'] + $this->fieldArray]);
        $collection2 = new Collection([['Field' => 'test2'] + $this->fieldArray]);
        $collection1->merge($collection2);
        $this->assertCount(2, $collection1);
    }

    public function testCreateField()
    {
    }

    public function testAddMaxlength()
    {
    }

    public function testToString()
    {
    }
}
