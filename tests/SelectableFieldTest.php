<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\SelectField;

class SelectableFieldTest extends \PHPUnit_Framework_TestCase
{

    public function testIsCheckable()
    {
        $field = new SelectField('test', []);
        $this->assertFalse($field->isCheckable());
    }

    public function testIsSelectable()
    {
        $field = new SelectField('test', []);
        $this->assertTrue($field->isSelectable());
    }

    public function testSetValue()
    {
        $field = new SelectField('test', ['value1', 'value2', 'value3'], 'value2');

        $this->assertEquals('value2', $field->getValue());
    }

    public function testHasEmptyValue()
    {
        $field = new SelectField('test', ['--no value--', 'a value', 'another value'], 0);
        $instance = $field->hasEmptyValue(true);
        $this->assertInstanceOf('Tobz\Autoform\Fields\SelectField', $instance);
        $this->assertEquals(0, $field->getValue());
        $this->assertEquals(
            '<select id="test" name="test">
<option selected>--no value--</option>
<option value="1">a value</option>
<option value="2">another value</option>
</select>',
            (string) $field
        );

    }

    public function testIsSelected()
    {
        $field = new SelectField('test', ['test 1', 'test 2', 'test 3'], 1);
        $this->assertFalse($field->isSelected(0));
        $this->assertFalse($field->isSelected(2));
        $this->assertTrue($field->isSelected(1));

        $field->setValue(2);
        $this->assertFalse($field->isSelected(1));
        $this->assertFalse($field->isSelected(3));
        $this->assertTrue($field->isSelected(2));

    }

    public function testGetOptions()
    {
        $field = new SelectField('test', ['test 1', 'test 2', 'test 3'], 1);
        $this->assertEquals(['test 1', 'test 2', 'test 3'], $field->getOptions());

    }

    public function testRenderOptions()
    {
        $field = new SelectField('test', ['test 1', 'test 2', 'test 3'], 1);
        $this->assertEquals(
            '<option value="0">test 1</option>
<option value="1" selected>test 2</option>
<option value="2">test 3</option>',
            $field->renderOptions()
        );
    }
}
