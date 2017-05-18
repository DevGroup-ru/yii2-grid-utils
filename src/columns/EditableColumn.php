<?php

namespace DevGroup\GridUtils\columns;

use Yii;
use yii\base\Model;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\Url;

class EditableColumn extends DataColumn
{
    public $cssClass = 'grid-input';
    public $route = 'edit';
    public $idAttribute = 'id';

    /** @var array */
    public $dropDownItems;
    /**
     * @param mixed|Model $model
     * @param mixed $key
     * @param int   $index
     *
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if (is_object($model)) {
            $options = [
                'class' => $this->cssClass,
                'data-route' => Url::to($this->route),
                'data-id' => $model->{$this->idAttribute},
                'data-attribute' => $this->attribute,
            ];
            if ($this->dropDownItems !== null) {
                return Html::activeDropDownList($model, $this->attribute, $this->dropDownItems, $options);
            }

            return Html::activeTextInput($model, $this->attribute, $options);
        }

        $options = [
            'class' => $this->cssClass,
            'data-route' => Url::to($this->route),
            'data-id' => $model[$this->idAttribute],
            'data-attribute' => $this->attribute,
        ];
        $fieldName = "GridView[$this->attribute]";

        if ($this->dropDownItems !== null) {
            return Html::dropDownList($fieldName, $model[$this->attribute], $this->dropDownItems, $options);
        }

        return Html::textInput(
            $fieldName,
            $model[$this->attribute],
            [
                'class' => $this->cssClass,
                'data-route' => Url::to($this->route),
                'data-id' => $model[$this->idAttribute],
                'data-attribute' => $this->attribute,
            ]
        );

    }
}
