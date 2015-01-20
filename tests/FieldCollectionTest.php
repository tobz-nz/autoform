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

    public function testCollectionMerge()
    {
        $collection1 = new Collection([['Field' => 'test1'] + $this->fieldArray]);
        $collection2 = new Collection([['Field' => 'test2'] + $this->fieldArray]);
        $collection1->merge($collection2);
        $this->assertCount(2, $collection1);
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

    public function testCreateHiddenFieldFromPrimaryKeyFromTinyint()
    {
        $field = ['Type' => 'tinyint', 'Key' => 'PRI'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
    }

    public function testCreateTinyintCheckboxField()
    {
        $field = ['Type' => 'tinyint'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
    }

    public function testCreateHiddenFieldFromPrimaryKeyInt()
    {
        $field = ['Type' => 'int', 'Key' => 'PRI'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('hidden', $collection->get('test1')->getType());
    }

    public function testCreateHiddenFieldFromPrimaryKeyUUID()
    {
        $field = ['Type' => 'uuid', 'Key' => 'PRI'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('hidden', $collection->get('test1')->getType());
    }

    public function testCreateInputFieldFromUUID()
    {
        $field = ['Type' => 'uuid'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('text', $collection->get('test1')->getType());
    }

    public function testCreateInputFieldFromChar()
    {
        $field = ['Type' => 'char'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('text', $collection->get('test1')->getType());
    }

    public function testCreateInputFieldFromVarchar()
    {
        $field = ['Type' => 'varchar'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('text', $collection->get('test1')->getType());
    }

    public function testCreateInputFieldFromTinyblob()
    {
        $field = ['Type' => 'tinyblob'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('text', $collection->get('test1')->getType());
    }

    public function testCreateInputFieldByDefault()
    {
        $field = ['Type' => 'misc'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('text', $collection->get('test1')->getType());
    }

    public function testCreateNumberField()
    {
        $field = ['Type' => 'int'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('number', $collection->get('test1')->getType());
    }

    public function testCreateDateTimeFieldFromTimestamp()
    {
        $field = ['Type' => 'timestamp'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('datetime', $collection->get('test1')->getType());
    }

    public function testCreateDateTimeFieldFromDatetime()
    {
        $field = ['Type' => 'datetime'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('datetime', $collection->get('test1')->getType());
    }

    public function testCreateDateTimeLocalFieldFromTimetz()
    {
        $field = ['Type' => 'timetz'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('datetime-local', $collection->get('test1')->getType());
    }

    public function testCreateDateTimeLocalFieldFromTimestamptz()
    {
        $field = ['Type' => 'timestamptz'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('datetime-local', $collection->get('test1')->getType());
    }

    public function testCreateTimeFieldFromTime()
    {
        $field = ['Type' => 'time'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('time', $collection->get('test1')->getType());
    }

    public function testCreateDateFieldFromDate()
    {
        $field = ['Type' => 'date'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('date', $collection->get('test1')->getType());
    }

    public function testCreateDateFieldFromYear()
    {
        $field = ['Type' => 'year'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $collection->get('test1'));
        $this->assertEquals('date', $collection->get('test1')->getType());
    }

    public function testCreateSelectFieldFromEnum()
    {
        $field = ['Type' => "enum('test1','test2')"] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\SelectField', $collection->get('test1'));
        $this->assertCount(2, $collection->get('test1')->getOptions());
    }

    public function testCreateSelectFieldFromSet()
    {
        $field = ['Type' => "set('test1','test2')"] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\SelectField', $collection->get('test1'));
        $this->assertCount(2, $collection->get('test1')->getOptions());
    }

    public function testCreateTextareaFieldFromBlob()
    {
        $field = ['Type' => 'blob'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromText()
    {
        $field = ['Type' => 'text'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromMediumblob()
    {
        $field = ['Type' => 'mediumblob'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromMediumtext()
    {
        $field = ['Type' => 'mediumtext'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromLongblob()
    {
        $field = ['Type' => 'longblob'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromLongtext()
    {
        $field = ['Type' => 'longtext'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromXml()
    {
        $field = ['Type' => 'xml'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testCreateTextareaFieldFromTextarea()
    {
        $field = ['Type' => 'textarea'] + $this->fieldArray;
        $collection = new Collection([$field]);
        $this->assertInstanceOf('Tobz\Autoform\Fields\TextField', $collection->get('test1'));
    }

    public function testAddMaxlength()
    {
        $testField = [];
        $collection = new Collection();
        $collection->addMaxlength($testField, 'varchar(140)');
        $this->assertArrayHasKey('maxlength', $testField);
        $this->assertEquals(140, $testField['maxlength']);
    }

    public function testToString()
    {
        $collection = new Collection([
            ['Field' => 'test1'] + $this->fieldArray,
            ['Field' => 'test2'] + $this->fieldArray
        ]);
        $this->assertEquals(
            '<input type="text" id="test1" name="test1" value="" required maxlength="50" />
<input type="text" id="test2" name="test2" value="" required maxlength="50" />',
            (string) $collection
        );
    }
}
