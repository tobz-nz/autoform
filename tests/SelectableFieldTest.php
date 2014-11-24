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
        $field = new SelectField('test', [], 0);
        $instance = $field->hasEmptyValue(true);
        $this->assertInstanceOf('Tobz\Autoform\Fields\SelectField', $instance);
        // $this->assertEquals('', $field->getValue());

    }

    public function testIsSelected()
    {
        $field = new SelectField('test', []);

    }

    public function testGetOptions()
    {
        $field = new SelectField('test', []);

    }

    public function testRenderOptions()
    {
        $field = new SelectField('test', []);

    }
}
