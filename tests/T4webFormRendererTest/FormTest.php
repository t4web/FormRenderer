<?php

namespace T4webFormRendererTest;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $formConfig = [
            'type' => 'T4webFormRenderer\Element\Form',
            'children' => [
                'name' => [
                    'type' => 'T4webFormRenderer\Element\Text',
                    'variables' => [
                        'label' => 'Name',
                        'placeholder' => 'Enter name'
                    ]
                ],
                'link' => [
                    'type' => 'T4webFormRenderer\Element\Text',
                    'variables' => [
                        'label' => 'Link',
                        'placeholder' => 'Enter link'
                    ]
                ]
            ],
            'variables' => [
                'action' => '/admin/news/create',
                'cancelLink' => '/admin/list'
            ],
        ];

        $renderer = new PhpRenderer();
        $stack = new Resolver\TemplatePathStack(array(
            'script_paths' => array(
                dirname(dirname(__DIR__)) . '/view'
            )
        ));
        $renderer->setResolver($stack);

        $factory = new Factory();
        $form = $factory->create($formConfig);
        $rawHtml = $renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" placeholder="Enter name" class="form-control"
                            value="">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Link</label>
                            <input type="text" name="link" placeholder="Enter link" class="form-control" value="">
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
