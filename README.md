# FormRenderer
Library for render forms

## Contents
- [Quick start](#quick-start)
- [Form with data](#form-with-data)
- [Form with validation messages](#form-with-validation-messages)
- [Default-templates](#default-templates)
- [Customizing](#customizing)
- [Element configuring](#element-configuring)

## Quick start
Just describe entity
```php
$formConfig = [
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

$factory = new Factory($formConfig);
$form = $factory->create();
$renderer->render($form);
```

will be render as
```html
<form method="post" action="/admin/news/create">
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
</form>
```

## Form with data
For adding values
```php
$form->setData([
    'name' => 'Sample name',
    'link' => '/bar/baz'
]);

$renderer->render($form);
```

will be render as
```html
<form method="post" action="/admin/news/create">
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
</form>
```

## Form with validation messages

For adding validation messages
```php
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

$renderer->render($form);
```

will be render as
```html
<form method="post" action="/admin/news/create">
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
</form>
```

## Default templates

- `t4web-form-renderer/element/form` for form rendering
- `t4web-form-renderer/element/text` for input type=text
- `t4web-form-renderer/element/checkbox` for input type=checkbox
- `t4web-form-renderer/element/date` for input type=date
- `t4web-form-renderer/element/month` for input type=month
- `t4web-form-renderer/element/file` for input type=file
- `t4web-form-renderer/element/hidden` for input type=hidden
- `t4web-form-renderer/element/number` for input type=number
- `t4web-form-renderer/element/password` for input type=password

## Customizing

Default templates designed for [AdminLTE theme](https://github.com/almasaeed2010/AdminLTE), but you cat overload any from it, just configure path resolver
```php
$stack = new Resolver\TemplatePathStack(array(
    'script_paths' => array(
        dirname(dirname(__DIR__)) . '/view'  // your templates
    )
));
$renderer->setResolver($stack);
```

!["Form Presentation"] (http://t4web.com.ua/var/form-renderer.png "Form Presentation")

## Element configuring

Each element must contain template
```php
$element = [
    // element name will be extract to $name variable in template
    'link' => [
        'template' => 't4web-form-renderer/element/text',
        
        // class, with responsibility render template(element), default T4webFormRenderer\Element
        'type' => 'T4webFormRenderer\Element',
        
        // variables, each will be extract in template
        'variables' => [
            'label' => 'Link',
            'placeholder' => 'Enter link'
        ]
        
        // array of child elements
        'children' => []
    ]
]
```