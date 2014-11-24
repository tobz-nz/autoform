<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\InputField;

class InputFieldTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicCreate()
    {
        $field = new InputField('test', 'test1', 'email', ['class' => 'test-class']);
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test1', $field->getValue());
        $this->assertEquals('email', $field->getType());
        $this->assertEquals('test-class', $field->getClass());
    }

    public function testArrayCreate()
    {
        $field = new InputField(['name' => 'test', 'value' => 'test1', 'class' => 'test-class']);
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test1', $field->getValue());
        $this->assertEquals('test-class', $field->getClass());
    }

    public function testSetAndGetType()
    {
        $field = new InputField('test');
        $this->assertEquals('text', $field->getType());

        // valid type
        $instance = $field->setType('email');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('email', $field->getType());

        // invalid type
        $instance = $field->setType('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('email', $field->getType());
    }

    public function testSetAndGetId()
    {
        $field = new InputField('test');
        $instance = $field->setId('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('tested', $field->getId());
    }

    public function testSetAndGetName()
    {
        $field = new InputField('test');
        $instance = $field->setName('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('tested', $field->getName());
    }

    public function testSetAndGetValue()
    {
        $field = new InputField('test');
        $instance = $field->setValue('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('tested', $field->getValue());
    }

    public function testSetAndGetLabel()
    {
        $field = new InputField('test');
        $instance = $field->setLabel('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('Tested', $field->getLabel());
    }

    public function testSetAndGetCallable()
    {
        $field = new InputField('test');
        $instance = $field->setTest('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('tested', $field->getTest());
    }

    public function testSetAndGetDataTag()
    {
        $field = new InputField('test');
        $instance = $field->setDataTest('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('tested', $field->getDataTest());
        $this->assertEquals(' data-test="tested"', $field->attributeString(['type', 'id', 'name', 'value']));
    }

    public function testRenderLabel()
    {
        $field = new InputField('test');
        $instance = $field->setLabel('tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('<label for="test">Tested</label>', $field->renderLabel());
    }

    public function testBefore()
    {
        $field = new InputField('test');
        $instance = $field->setBefore('test');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('test', $field->getBefore());
        $this->assertEquals('test<input type="text" id="test" name="test" value="" />', $field->renderField());
    }

    public function testAfter()
    {
        $field = new InputField('test');
        $instance = $field->setAfter('test');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('test', $field->getAfter());
        $this->assertEquals('<input type="text" id="test" name="test" value="" />test', $field->renderField());
    }

    public function testWrap()
    {
        $field = new InputField('test');
        $instance = $field->wrap('test', 'tested');
        $this->assertInstanceOf('Tobz\Autoform\Fields\InputField', $instance);
        $this->assertEquals('test<input type="text" id="test" name="test" value="" />tested', $field->renderField());

        $field->wrap('outerTest|', '|outerTested');
        $this->assertEquals('outerTest|test', $field->getBefore());
        $this->assertEquals('tested|outerTested', $field->getAfter());
        $this->assertEquals('outerTest|test<input type="text" id="test" name="test" value="" />tested|outerTested', $field->renderField());
    }

    public function testAttributeString()
    {
        $field = new InputField('test');
        $this->assertEquals(
            ' class="test-class" name="test"',
            $field->attributeString([], ['class'=>'test-class', 'name' => 'test'])
        );
        $this->assertEquals(' name="test"', $field->attributeString(
            ['class'],
            ['class'=>'test-class', 'name' => 'test']
        ));
    }

    public function testBooleanAttributes()
    {
        $field = new InputField('test');
        $this->assertEquals(' required', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['required' => true]
        ));
        $this->assertEquals(' spellcheck', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['spellcheck' => true]
        ));
        $this->assertEquals(' checked', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['checked' => true]
        ));
        $this->assertEquals(' disabled', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['disabled' => true]
        ));
        $this->assertEquals(' draggable', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['draggable' => true]
        ));
        $this->assertEquals(' hidden', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['hidden' => true]
        ));
        $this->assertEquals(' novalidate', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['novalidate' => true]
        ));
        $this->assertEquals(' readonly', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['readonly' => true]
        ));
        $this->assertEquals(' multiple', $field->attributeString(
            ['id', 'name', 'type', 'value'],
            ['multiple' => true]
        ));
    }

    public function testIsCheckable()
    {
        $field = new InputField('test');
        $this->assertFalse($field->isCheckable());
    }

    public function testIsSelectable()
    {
        $field = new InputField('test');
        $this->assertFalse($field->isSelectable());
    }

    public function testClassMethods()
    {
        $field = new InputField('test');
        $this->assertFalse($field->hasClass('test-class'));

        $field->addClass('test-class');
        $this->assertEquals('test-class', $field->getClass());
        $this->assertTrue($field->hasClass('test-class'));

        $field->removeClass('test-class');
        $this->assertFalse($field->hasClass('test-class'));
    }

    public function testRender()
    {
        $field = new InputField('test', 'test1', 'email', ['required' => true, 'class' => 'my-class']);
        $this->assertEquals('test', $field->getName());
        $this->assertEquals('test1', $field->getValue());

        $this->assertEquals(
            '<input type="email" id="test" name="test" value="test1" required class="my-class" />',
            (string) $field
        );
    }
}
