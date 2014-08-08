<?php namespace Tobz\Autoform\tests;

use Tobz\Autoform\Fields\InputField;
use Tobz\Autoform\Fields\CheckableField;
use Tobz\Autoform\Fields\TextField;
use Tobz\Autoform\Fields\SelectField;
use Tobz\Autoform\Fields\Collection;
use Tobz\Autoform\Autoform;
use User;

class FormTest extends \TestCase
{

    public function testForm()
    {
        $autoform = new Autoform(['action' => '/save']);

        $this->assertEquals('/save', $autoform->action);
        $this->assertEquals('post', $autoform->method);
        $this->assertEquals('<form action="/save" method="post">'."\n", $autoform->open());
        $this->assertEquals("</form>\n", $autoform->close());
        $this->assertCount(0, $autoform);


        $field = [
            'Field' => 'test1',
            'Type' => "int(100)",
            'Null' => 'NO',
            'Key' => 'PRI',
            'Default' => '0',
            'Extra' => ''
        ];

        $autoform = new Autoform(['action' => '/save'], new Collection([$field]));
        $this->assertCount(1, $autoform);
        $this->assertEquals('<input type="hidden" id="test1" name="test1" value="0" required />', $autoform->renderFields());
    }
}
