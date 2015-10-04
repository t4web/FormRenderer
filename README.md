# FormRenderer
ZF2 Module for render form

Just describe entity
```php
$formConfig = [
    'elements' => array(
        array(
            'name' => 'name',
            'spec' => array(
                'type' => 'T4WebFormRenderer\Form\Element\Text',
                'label' => 'Name',
                'attributes' => [
                    'id' => 'name',
                    'placeholder' => 'Enter name',
                    'data-bar' => 'baz'
                ]
            ),
        ),
        array(
            'name' => 'link',
            'spec' => array(
                'type' => 'T4WebFormRenderer\Form\Element\Text',
                'options' => array(
                    'label' => 'Link',
                    'placeholder' => 'Enter link',
                ),
            ),
        ),
        array(
            'name' => 'send',
            'spec' => array(
                'type'  => 'T4WebFormRenderer\Form\Element\Submit',
                'attributes' => array(
                    'value' => 'Submit',
                    'id' => 'submit-btn',
                ),
            ),
        ),
    ),
];
```

will be render as
```html
<form method="post">
    <div class="box-body">
        <div class="form-group">
            <label class="control-label">Name</label>
            <input type="text" name="name" placeholder="Enter name" class="form-control" data-bar="baz" value="">
        </div>

        <div class="form-group">
            <label class="control-label">Link</label>
            <input type="text" name="link" placeholder="Enter link" class="form-control" value="">
        </div>
    </div>

    <div class="box-footer">
        <button type="submit" class="btn btn-success" id="submit-btn">Submit</button>
        <a class="btn btn-default" href="/admin/news-sm">Cancel</a>
    </div>
</form>
```
