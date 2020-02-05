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
     * @var array the JQuery plugin options for the bootstrap-tagsinput plugin.
     * @see http://timschlechter.github.io/bootstrap-tagsinput/examples/#options
     */
    public $clientOptions = [];
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var string the hashed variable to store the pluginOptions
     */
    protected $_hashVar;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();

        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }
    }

    protected function hashPluginOptions($view)
    {
        $encOptions = empty($this->clientOptions) ? '{}' : Json::encode($this->clientOptions);
        $this->_hashVar = self::PLUGIN_NAME . '_' . hash('crc32', $encOptions);
        $this->options['data-plugin-' . self::PLUGIN_NAME] = $this->_hashVar;
        $view->registerJs("var {$this->_hashVar} = {$encOptions};\n", View::POS_HEAD);
    }

   
    public function registerClientScript()
    {
        $js = '';
        $view = $this->getView();
        $this->hashPluginOptions($view);
        $id = $this->options['id'];
        $js .= '$("#' . $id . '").' . self::PLUGIN_NAME . "(" . $this->_hashVar . ");\n";
        TagsInputAsset::register($view);
        $view->registerJs($js);
    }
}