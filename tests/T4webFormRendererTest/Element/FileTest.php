<?php

namespace T4webFormRendererTest\Element;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class FileTest extends \PHPUnit_Framework_TestCase
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

    public function testFromRenderWithFile()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'file' => [
                    'template' => 't4web-form-renderer/element/file',
                    'variables' => [
                        'label' => 'File'
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

        $form->setMessages([
            'file' => [
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
                            <label class="control-label">File</label>
                            <input type="file" name="file" class="form-control">
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
