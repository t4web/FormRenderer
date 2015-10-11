<?php

namespace T4webFormRendererTest\Element;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class RadioTest extends \PHPUnit_Framework_TestCase
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

    public function testFromRenderWithPassword()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'options' => [
                    'template' => 't4web-form-renderer/element/radio',
                    'variables' => [
                        'labels' => [
                            1 => 'Option one',
                            2 => 'Option two',
                            3 => 'Option three',
                        ]
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
            'options' => 2
        ]);

        $form->setMessages([
            'options' => [
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
                            <div class="radio">
                                <label>
                                    <input type="radio" name="options" value="1" >
                                    Option one
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="options" value="2" checked="">
                                    Option two
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="options" value="3" >
                                    Option three
                                </label>
                            </div>
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
