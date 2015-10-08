# FormRenderer
Library for render forms

Just describe entity
```php
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
