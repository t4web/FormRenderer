<?php

namespace T4webFormRendererTest\Element;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class HiddenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PhpRenderer();
        $stack = new Resolver\TemplatePathStack(array(
            'script_paths' => array(
                dirname(dirname(dirname(__DIR__))) . '/view'
            )
        ));
        $this->renderer->setResolver($stack);
    }

    public function testFromRenderWithHidden()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'id' => [
                    'template' => 't4web-form-renderer/element/hidden',
                ],
            ],
            'variables' => [
                'action' => '/admin/news/create',
                'cancelLink' => '/admin/list'
            ],
        ];

        $factory = new Factory();
        $form = $factory->create($formConfig);

        $form->setData([
            'id' => 123
        ]);

        $rawHtml = $this->renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create">
                    <div class="box-body">
                        <input type="hidden" name="id" class="form-control" value="123">
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success" id="submit-btn">Submit</button>
                        <a class="btn btn-default" href="/admin/list">Cancel</a>
                    </div>
                </form>'
            ),
            preg_replace('/\s+/', ' ', $rawHtml)
        );
    }
}
