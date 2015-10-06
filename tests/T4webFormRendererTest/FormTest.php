<?php

namespace T4webFormRendererTest;

use T4webFormRenderer\Form;

class FormTest extends \PHPUnit_Framework_TestCase
{
    private $form;

    public function setUp()
    {
        $this->form = new Form();
    }

    public function testRender()
    {
        $rawHtml = $this->form->render();

        $this->assertEquals('<form></form>', $rawHtml);
    }
}
