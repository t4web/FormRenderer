# FormRenderer
Library for render forms

Just describe entity
```php
$formConfig = [
    'template' => 'application/form/create-news', 
    'elements' => [
        [
            'name' => 'name',
            'spec' => [
                'type' => 'T4WebFormRenderer\Form\Element\Text',
                'label' => 'Name',
                'attributes' => [
                    'id' => 'name',
                    'placeholder' => 'Enter name',
                    'data-bar' => 'baz'
                ]
            ],
        ],
        [
            'name' => 'link',
            'spec' => [
                'type' => 'T4WebFormRenderer\Form\Element\Text',
                'options' => [
                    'label' => 'Link',
                    'placeholder' => 'Enter link',
                ],
            ],
        ],
    ],
    'buttons' => [
        [
            'name' => 'send',
            'spec' => [
                'type'  => 'T4WebFormRenderer\Form\Element\Submit',
                'attributes' => [
                    'value' => 'Submit',
                    'id' => 'submit-btn',
                ],
            ],
        ],
        [
            'name' => 'send',
            'spec' => [
                'type'  => 'T4WebFormRenderer\Form\Element\Link',
                'label' => 'Cancel',
                'attributes' => [
                    'class' => 'btn btn-default',
                    'href' => '/admin/list',
                ],
            ],
        ],
    ],
];

$form = new Form($formConfig);
$form->render();
```

And create template application/form/create-news.phtml
```php
<form method="post">
    <div class="box-body">
        <?=$this->elements ?>
    </div>

    <div class="box-footer">
        <?=$this->buttons ?>
    </div>
</form>
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
