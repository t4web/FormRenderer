<?php

namespace T4webFormRendererTest\Element;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class NumberTest extends \PHPUnit_Framework_TestCase
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

    public function testFromRenderWithNumber()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'count' => [
                    'template' => 't4web-form-renderer/element/number',
                    'variables' => [
                        'label' => 'Count'
                    ]
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
            'count' => 3
        ]);

        $form->setMessages([
            'count' => [
                "This field is required"
            ]
        ]);

        $rawHtml = $this->renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create">
                    <div class="box-body">
                        <div class="form-group has-error">
                            <label class="control-label">Count</label>
                            <input type="number" name="count" placeholder="" class="form-control" value="3">
                            <p class="help-block">This field is required</p>
                        </div>
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
