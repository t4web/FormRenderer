# FormRenderer
Library for render forms

Just describe entity
```php
$formConfig = [
    'type' => 'Form',
    'template' => 'application/form/create-news',
    'children' => [
        'name' => [
            'type' => 'Input',
            'vars' => [
                'label' => 'Enter name'
            ]
        ],
        'link' => [
            'type' => 'Input',
            'vars' => [
                'label' => 'Enter link'
            ]
        ]
    ],
    'vars' => [
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
<form method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" placeholder="Enter name" class="form-control" data-bar="baz" id="name" value="">
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
