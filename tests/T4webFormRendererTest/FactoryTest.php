<?php

namespace T4webFormRendererTest;

use T4webFormRenderer\Factory;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $formConfig;

    /**
     * @var PhpRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'name' => [
                    'template' => 't4web-form-renderer/element/text',
                    'variables' => [
                        'label' => 'Name',
                        'placeholder' => 'Enter name'
                    ]
                ],
                'link' => [
                    'template' => 't4web-form-renderer/element/text',
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

        $this->renderer = new PhpRenderer();
        $stack = new Resolver\TemplatePathStack(array(
            'script_paths' => array(
                dirname(dirname(__DIR__)) . '/view'
            )
        ));
        $this->renderer->setResolver($stack);
    }

    public function testEmptyFromRender()
    {
        $factory = new Factory();
        $form = $factory->create($this->formConfig);
        $rawHtml = $this->renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" placeholder="Enter name" class="form-control" value="">
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

    public function testFromRenderWithErrors()
    {
        $factory = new Factory();
        $form = $factory->create($this->formConfig);

        $form->setMessages([
            "Invalid type given. String expected",
            "Invalid type given. String expected 2",
            'name' => [
                "Invalid type given. String expected",
                "The input is less than 3 characters long",
            ],
            'link' => [
                "Value is required and can't be empty"
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
                            <label class="control-label">Name</label>
                            <input type="text" name="name" placeholder="Enter name" class="form-control" value="">
                            <p class="help-block">Invalid type given. String expected<br/>
                            The input is less than 3 characters long</p>
                        </div>
                        <div class="form-group has-error">
                            <label class="control-label">Link</label>
                            <input type="text" name="link" placeholder="Enter link" class="form-control" value="">
                            <p class="help-block">Value is required and can\'t be empty</p>
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

    public function testFromRenderWithData()
    {
        $factory = new Factory();
        $form = $factory->create($this->formConfig);

        $form->setData([
            'name' => 'Sample name',
            'link' => '/bar/baz'
        ]);

        $rawHtml = $this->renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" placeholder="Enter name" class="form-control" value="Sample name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Link</label>
                            <input type="text" name="link" placeholder="Enter link" class="form-control" value="/bar/baz">
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

    public function testFromRenderWithEnctype()
    {
        $this->formConfig['variables']['inputFileExists'] = true;

        $factory = new Factory();
        $form = $factory->create($this->formConfig);

        $form->setData([
            'name' => 'Sample name',
            'link' => '/bar/baz'
        ]);

        $rawHtml = $this->renderer->render($form);

        $this->assertEquals(
            preg_replace(
                '/\s+/',
                ' ',
                '<form method="post" action="/admin/news/create" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" placeholder="Enter name" class="form-control" value="Sample name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Link</label>
                            <input type="text" name="link" placeholder="Enter link" class="form-control" value="/bar/baz">
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
