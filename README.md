Yii2 Tagsinput
==============

Create a Bootstrap Tags Input Box

---------------------------------

## TODO
This fork is aimed at making a progressive enhancement to this wigdet. This include but not limited to:
- Make it support Bootstrap 5 and above
- Make it compatible with Yii2 and above
- Make it easy to use and customizable
- Support multiple input formats (e.g. comma-separated, array)


## Installation

To install, either run

```
$ php composer.phar require xililo/yii2-widget-tagsinput
```

or add

```
"xililo/yii2-widget-tagsinput": "*"
```

to the ```require``` section of your `composer.json` file.


## Usage

```php
use shubham\tagsinput\TagsInput;

// Usage with ActiveForm and model
echo $form->field($model, 'tags')->widget(TagsInput::classname(), [
    "options"=>[
        // Input Options Here
    ],
    'pluginOptions'=>[
        'allowClear'=>true; // default true
    ],
    'pluginEvents'=>[
       
    ]
]);


// Without model & without ActiveForm
echo TagsInput::widget([
    'name' => 'tags',
]);
```
