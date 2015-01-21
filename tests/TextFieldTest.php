<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\TextField;

class TextFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $field = new TextField('test', 'test1', null, ['class' => 'tested', 'required' => true]);
        $this->assertEquals(
            '<textarea id="test" name="test" rows="5" cols="30" class="tested" required>test1</textarea>',
            (string) $field
        );
    }

    public function testCols()
    {
        $field = new TextField('test', 'test1');
        $field->setCols(28);
        $this->assertEquals(28, $field->getCols());
        $this->assertEquals(
            '<textarea id="test" name="test" rows="5" cols="28">test1</textarea>',
            (string) $field
        );
    }

    public function testRows()
    {
        $field = new TextField('test', 'test1');
        $field->setRows(6);
        $this->assertEquals(6, $field->getRows());
        $this->assertEquals(
            '<textarea id="test" name="test" rows="6" cols="30">test1</textarea>',
            (string) $field
        );
    }
}
