<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\StringHelper;

/**
 * BoxWidget is a widget to create box (panel in bs3) based on adminLte2 template
 *
 * @author Heru Arief Wijaya <heru@belajararief.com>
 * @param string title
 * @param html body
 * play it like this
 * use app\widgets\BoxWidget;
 * echo BoxWidget::widget(['title' => 'Judul', 'body' => $yourHtmlBodyContent])
 * to fill $yourHtmlBodyContent you can use ob_get_content method like below example
 */
/*
<div class="{colSizeClass}"> // default col-md-3
    <div class="card border-left-{cardBorder} shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{bigLabel}</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{smallLabel}</div>
                </div>
            <div class="col-auto">
                <i class="fas fa-{faIcon} fa-2x text-gray-300"></i> // default {fa-calendar}
            </div>
            </div>
        </div>
    </div>
</div>  
Card::widget([
    'type' => 'cardBorder',
    'label' => 'Label',
    'sLabel' => '1000',
    'icon' => 'fa-calendar',
    'options' => [
        'colSizeClass' => 'col-md-3',
        'borderColor' => 'primary',
    ]
]);
*/
class Card extends Widget
{
    /**
     * headerMenu is an array
     * it contain header for first column (main menu), second (sub Menu). and third (sub sub menu)
     * it end with akses
     */
    public $type;
    public $label;
    public $sLabel;
    public $icon;
    public $options;
    public $labelOptions;
    public $colSizeClassDefault = 'col-xl-3 col-md-6 mb-4';
    public $borderColorDefault = 'primary';

    public $cardBorderTemplate = '
        <div class="{colSizeClass}">
            <div class="card border-left-{cardBorder} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{bigLabel}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{smallLabel}</div>
                        </div>
                    <div class="col-auto">
                        <i class="fas fa-{faIcon} fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
            </div>
        </div>    
    ';

    public function init() {
        parent::init();
        if(!$this->type) $this->type = 'cardBorder';
        if(!$this->options){
            $this->options['colSizeClass'] = $this->colSizeClassDefault;
            $this->options['borderColor'] = $this->borderColorDefault;
        }
        if(isset($this->options)){
            if(!isset($this->options['colSizeClass'])) $this->options['colSizeClass'] = $this->colSizeClassDefault;
            if(!isset($this->options['borderColor'])) $this->options['borderColor'] = $this->borderColorDefault;
        }
    }

    /**
     * Renders the menu.
     */
    public function run()
    {
        return $this->renderCardBorder();
    }

    public function renderCardBorder()
    {
        if($this->labelOptions['truncateWords']){
            $this->label = StringHelper::truncateWords($this->label, $this->labelOptions['numberOfWords'], '...', true);
            $this->sLabel = StringHelper::truncateWords($this->sLabel, $this->labelOptions['numberOfWords'], '...', true);
        }
        return strtr($this->cardBorderTemplate, [
            '{colSizeClass}' => $this->options['colSizeClass'],
            '{cardBorder}' => $this->options['borderColor'],
            '{bigLabel}' => $this->label,
            '{smallLabel}' => $this->sLabel,
            '{faIcon}' => $this->icon
        ]);
    }
}
