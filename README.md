## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-switchinput/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require rbshubham/yii2-widget-tagsinput
```

or add

```
"rbshubham/yii2-widget-tagsinput": "*"
```

to the ```require``` section of your `composer.json` file.


## Usage

```php
use shubham\tagsinput\TagsInput;

// Usage with ActiveForm and model
echo $form->field($model, 'status')->widget(TagsInput::classname(), [
    //options
]);


// Without model & without ActiveForm
echo TagsInput::widget([
    'name' => 'status_1',
]);
```