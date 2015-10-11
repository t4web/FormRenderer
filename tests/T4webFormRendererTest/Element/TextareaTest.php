<?php

namespace T4webFormRendererTest\Element;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class TextareaTest extends \PHPUnit_Framework_TestCase
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
                'body' => [
                    'template' => 't4web-form-renderer/element/textarea',
                    'variables' => [
                        'label' => 'Body'
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
            'body' => 'The France coach insists that he did not force Benzema to play when the player was not 100 per cent.'
        ]);

        $form->setMessages([
            'body' => [
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
                            <label>Body</label>
                            <textarea name="body" rows="3" placeholder=""
                                class="form-control">The France coach insists that he did not force Benzema to play when the player was not 100 per cent.</textarea>
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
