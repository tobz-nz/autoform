<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\InputField;
use Tobz\Autoform\Fields\CheckableField;
use Tobz\Autoform\Fields\TextField;
use Tobz\Autoform\Fields\SelectField;
use Tobz\Autoform\Fields\Collection;
use Tobz\Autoform\Autoform;
use User;

class FieldTest extends \TestCase
{
    public function baseTests($field)
    {
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test', $field->getId());
        $this->assertEquals('test1', $field->getValue());
        $this->assertFalse($field->isCheckable());
        $this->assertFalse($field->isSelectable());
        $this->assertObjectHasAttribute('isCheckable', $field);
        $this->assertObjectHasAttribute('isSelectable', $field);
    }

    public function testInputField()
    {
        $field = new InputField('test', 'test1');
        $this->baseTests($field);

        $field->setType('search');
        $this->assertEquals('search', $field->getType());

        $field->setType('monkeys');
        $this->assertEquals('search', $field->getType());

        $field = new InputField([
            'id' => 'test2',
            'name' => 'test2',
            'value' => 'test2',
        ]);
        $this->assertEquals('test2', $field->getName());
        $this->assertEquals('test2', $field->getId());
        $this->assertEquals('test2', $field->getValue());
        $this->assertEquals('<input type="text" id="test2" name="test2" value="test2" />', (string) $field);

        $field = new InputField([
            'id' => 'id3',
            'name' => 'name3',
            'value' => 'value3',
        ], 'myValue', 'myId', ['data-test' => 'yes', 'name' => 'teset4']);
        $this->assertEquals('name3', $field->getName());
        $this->assertEquals('myId', $field->getId());
        $this->assertEquals('myValue', $field->getValue());
        $this->assertEquals('<input type="text" id="myId" name="name3" value="myValue" data-test="yes" />', (string) $field);
    }

    public function testCheckableInputFIeld()
    {
        $field = new CheckableField('test', 'test');
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test', $field->getId());
        $this->assertEquals('test', $field->getValue());
        $this->assertEquals('checkbox', $field->getType());
        $this->assertFalse($field->isChecked());
        $this->assertFalse($field->isSelectable());


        $field->setType('radio');
        $this->assertEquals('radio', $field->getType());

        $field->setType('text');
        $this->assertEquals('radio', $field->getType());

        $field = new CheckableField('test', ['test', true]);
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test', $field->getId());
        $this->assertEquals('test', $field->getValue());
        $this->assertTrue($field->isChecked());

        $field->setValue('test2');
        $this->assertEquals('test2', $field->getValue());

        $field->setValue(['test3', false]);
        $this->assertEquals('test3', $field->getValue());
        $this->assertFalse($field->isChecked());
    }

    public function testTextField()
    {
        $field = new TextField('test', 'test1');
        $this->baseTests($field);
        $this->assertEquals('<textarea id="test" name="test" rows="5" cols="30">test1</textarea>', (string) $field);
    }

    public function testSelectField()
    {
        $field = new SelectField('test', ['test1' => 'Test 1', 'test2' => 'Test 2']);
        $this->assertTrue($field->isSelectable());
        $this->assertFalse($field->isCheckable());
        $this->assertEquals(
            '<select id="test" name="test">
<option value="test1">Test 1</option>
<option value="test2">Test 2</option>
</select>',
            (string) $field
        );

        $field->setValue('test2');
        $this->assertEquals(
            '<select id="test" name="test">
<option value="test1">Test 1</option>
<option value="test2" selected>Test 2</option>
</select>',
            (string) $field
        );
    }

    public function testFIeldCollection()
    {
        $collection = new Collection(['field1' => new InputField('field1'), 'field2' => new CheckableField('field2')]);
        $this->assertCount(2, $collection);

        $collection->add(new SelectField('field4', ['value']));
        $collection->add(new TextField('field5'));
        $this->assertCount(4, $collection);

        $collection->add([
            'Field' => 'test1',
            'Type' => "enum('user','admin')",
            'Null' => 'NO',
            'Key' => '',
            'Default' => '',
            'Extra' => ''
        ]);

        $this->assertInstanceOf('Tobz\Autoform\Fields\SelectField', $collection->test1);
        // dd((string) $selectField);
    }
}
