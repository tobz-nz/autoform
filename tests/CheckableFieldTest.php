<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\CheckableField;

class CheckableFieldTest extends \PHPUnit_Framework_TestCase
{

    public function testIsCheckable()
    {
        $field = new CheckableField('test');
        $this->assertTrue($field->isCheckable());
    }

    public function testSetValue()
    {
        $field = new CheckableField('test');
        $this->assertEquals(1, $field->getValue());

        $instance = $field->setValue('test');
        $this->assertInstanceOf('Tobz\Autoform\Fields\CheckableField', $instance);
        $this->assertEquals('test', $field->getValue());
        $this->assertFalse($field->isChecked());

        $field->setValue(['test2', true]);
        $this->assertEquals('test2', $field->getValue());
        $this->assertTrue($field->isChecked());
    }

    public function testIsChecked()
    {
        $field = new CheckableField('test');
        $field->check(false);
        $this->assertFalse($field->isChecked());

        $field->check(true);
        $this->assertTrue($field->isCheckable());
    }
}
