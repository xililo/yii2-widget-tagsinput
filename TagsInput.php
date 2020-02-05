<?php
/**
 * @link      https://github.com/rbshubham/yii2-widget-tagsinput
 * @copyright Copyright (c) 2020 Shubham Garg
 * @license   Redblink.com
 */
namespace shubham\tagsinput;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * The yii2-widget-tagsinput is a Yii 2 wrapper for bootstrap-tagsinput.
 * See more: https://github.com/timschlechter/bootstrap-tagsinput
 *
 * @author Shuhbham Garg <shubham.garg@redblink.net>
 */
class TagsInput extends \yii\widgets\InputWidget
{
    /**
     * The name of the jQuery plugin to use for this widget.
     */
    const PLUGIN_NAME = 'tagsinput';

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        $this->options['data-role']= self::PLUGIN_NAME;
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        TagsInputAsset::register($view);
    }
}