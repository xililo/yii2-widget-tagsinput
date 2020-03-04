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
    
    const VALID_PLUGIN_EVENTS = [
        'itemAddedOnInit',
        'beforeItemAdd',
        'itemAdded',
        'beforeItemRemove',
        'itemRemoved',
    ];
    const VALID_PLUGIN_OPTONS = [
        'tagClass',
        'itemValue',
        'itemText',
        'confirmKeys',
        'maxTags',
        'maxChars',
        'trimValue',
        'allowDuplicates',
        'focusClass',
        'freeInput',
        'typeahead',
        'cancelConfirmKeysOnEmpty',
        'onTagExists',
        'allowClear'
    ];
    
    public $pluginOptions = [
        'allowClear'=>true,
    ];
    public $pluginEvents = [];

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
        $this->setPluginOptions();
        $this->registerClientScript();
       
        $this->options['data-role']= self::PLUGIN_NAME;
        echo "<div class='col-md-12 p-0'>";
        if ($this->hasModel()) {
            if($this->pluginOptions['allowClear']){
                
                echo Html::tag('span', 'x',['class'=>'tagsinput_clear-all','id'=>$this->options['id'].'-remove-all']);
                
            }
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            
            
        } else {
            if($this->pluginOptions['allowClear']){
                echo Html::tag('span', '<i class="fa fa-trash" aria-hidden="true"></i>',['class'=>'tagsinput_clear-all','id'=>$this->options['id'].'-remove-all']);
            }
            echo Html::textInput($this->name, $this->value, $this->options);
            
        }
        echo "</div>";
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        $options = $this->addPluginOptions();
        
        $this->addPluginEvents($view);
        $js =  <<< JS
           $('#{$this->options['id']}').tagsinput({$options});
           var \$elt = $('#{$this->options['id']}').tagsinput('input');
           var prevent = false;
            \$elt.focus(function() {
               prevent = true;
            }).blur(function() {
                prevent = false;
            });
           $("#{$this->field->form->id}").on('submit', function(){
                if (prevent){return false;}
           });
           if($("#{$this->options['id']}-remove-all").length){
            $("#{$this->options['id']}-remove-all").on('click', function(){
                 $('#{$this->options['id']}').tagsinput('removeAll');
            });
           }
           
           
           
JS;
        $view->registerJs($js, \yii\web\View::POS_END); 
        TagsInputAsset::register($view);
    }
    
    private function addPluginOptions(){
       
        foreach ($this->pluginOptions as $key=>$option){
            if(!in_array($key, self::VALID_PLUGIN_OPTONS)){
                unset($this->pluginOptions[$key]);
            }
        }
        return  empty($this->pluginOptions) ? '{}' : Json::encode($this->pluginOptions);
        
        
    }
    private function addPluginEvents($view){
        $js = '';
        foreach ($this->pluginEvents as $key=>$value){
            if(!in_array($key, self::VALID_PLUGIN_EVENTS)){
                unset($this->pluginEvents[$key]);
            }else{
                $js .= "$('#{$this->options['id']}').on('$key',$value);\n";
            }
        }
        $view->registerJs($js, \yii\web\View::POS_END); 
        
    }
    public function setPluginOptions(){
        $this->pluginOptions['allowClear'] = $this->pluginOptions['allowClear']??true;
    }
}