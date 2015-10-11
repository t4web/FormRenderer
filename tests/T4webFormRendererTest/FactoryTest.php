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

    public function testFromRenderWithCheckbox()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'terms' => [
                    'template' => 't4web-form-renderer/element/checkbox',
                    'variables' => [
                        'label' => 'Terms'
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
            'terms' => 1
        ]);

        $form->setMessages([
            'terms' => [
                "You must read and check"
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
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="terms" value="1"> Terms
                                </label>
                            </div>
                            <p class="help-block">You must read and check</p>
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

    public function testFromRenderWithDate()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'date' => [
                    'template' => 't4web-form-renderer/element/date',
                    'variables' => [
                        'label' => 'Date'
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
            'date' => '2015-10-11'
        ]);

        $form->setMessages([
            'date' => [
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
                            <label class="control-label">Date</label>
                            <input type="date" name="date" class="form-control" value="2015-10-11">
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

    public function testFromRenderWithMonth()
    {
        $formConfig = [
            'template' => 't4web-form-renderer/element/form',
            'children' => [
                'month' => [
                    'template' => 't4web-form-renderer/element/month',
                    'variables' => [
                        'label' => 'Month'
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
            'month' => '2015-10'
        ]);

        $form->setMessages([
            'month' => [
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
                            <label class="control-label">Month</label>
                            <input type="month" name="month" class="form-control" value="2015-10">
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
