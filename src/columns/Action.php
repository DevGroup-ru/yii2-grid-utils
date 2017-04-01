<?php

namespace DevGroup\GridUtils\columns;

use Yii;
use yii\grid\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class ActionColumn is an advanced ActionColumn for modern bootstrap admin grids
 *
 * @package DevGroup\AdminUtils\columns
 */
class Action extends Column
{
    public $buttons = [];

    private $defaultButtons = [];

    public $appendReturnUrl = true;

    public $buttonSizeClass = 'btn-xs';

    /**
     * @var array Params to append to every button's URL if button doesn't redefine it.
     */
    public $appendUrlParams = [];

    public $contentOptions = [
        'class' => 'grid-view__action-column'
    ];

    public function init()
    {
        parent::init();
        $this->defaultButtons = [
            'edit' => [
                'url' => 'edit',
                'icon' => 'pencil',
                'class' => 'btn-primary',
                'label' => Yii::t('app', 'Edit'),
            ],
            'delete' => [
                'url' => 'delete',
                'icon' => 'trash-o',
                'class' => 'btn-danger',
                'label' => Yii::t('app', 'Delete'),
                'options' => [
                    'data-action' => 'delete'
                ],
            ],
        ];
        if (empty($this->buttons) === true) {
            $this->buttons = $this->defaultButtons;
        }
    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     *
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param bool $appendReturnUrl custom return url for each button
     * @param array $urlAppend custom append url for each button
     * @param string $keyParam custom param if $key is string
     * @param array $attrs list of model attributes used in route params
     *
     * @return string the created URL
     */
    public function createUrl(
        $action,
        $model,
        $key,
        $urlAppend,
        $keyParam = 'id',
        $attrs = []
    ) {
        $params = [];
        if (is_array($key)) {
            $params = $key;
        } else {
            if (is_null($keyParam) === false) {
                $params = [$keyParam => (string)$key];
            }
        }
        $params[0] = $action;
        foreach ($attrs as $attrName) {
            if ($attrName === 'model') {
                $params['model'] = $model;
            } else {
                $params[$attrName] = $model->getAttribute($attrName);
            }
        }
        $params = ArrayHelper::merge($params, $urlAppend);

        return Url::toRoute($params);

    }

    /**
     * Renders cell content(buttons)
     *
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     *
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $data = Html::beginTag('div', ['class' => 'btn-group grid-utils']);
        if ($this->buttons instanceof \Closure) {
            $buttons = call_user_func($this->buttons, $model, $key, $index, $this);
        } else {
            $buttons = $this->buttons;
        }
        foreach ($buttons as $buttonName => $button) {
            if ($buttonName === 'delete' &&
                ArrayHelper::getValue($button, 'options.data-action') === 'delete'
            ) {
                $button = ArrayHelper::merge(
                    [
                        'options' => [
                            'data-title' => Yii::t('app', 'Delete'),
                            'data-close' => Yii::t('app', 'Close'),
                            'data-text' => Yii::t('app', 'Are you sure you want to delete this item?')
                        ]
                    ],
                    $button
                );
            }
            $urlAppend = ArrayHelper::getValue($button, 'urlAppend', $this->appendUrlParams);
            $keyParam = ArrayHelper::getValue($button, 'keyParam', 'id');
            $attrs = ArrayHelper::getValue($button, 'attrs', []);
            Html::addCssClass($button, 'btn');
            Html::addCssClass($button, $this->buttonSizeClass);
            $buttonText = isset($button['text']) ? ' ' . $button['text'] : '';
            $icon = empty($button['icon']) ? '' : "<i class=\"fa fa-{$button['icon']}\"></i>";
            if (!empty($icon) && !empty($buttonText)) {
                $buttonText = '&nbsp;' . $buttonText;
            }
            $data .= Html::a(
                    $icon . $buttonText,
                    $this->createUrl(
                        $button['url'],
                        $model,
                        $key,
                        $urlAppend,
                        $keyParam,
                        $attrs
                    ),
                    ArrayHelper::merge(
                        isset($button['options']) ? $button['options'] : [],
                        [
                            'class' => $button['class'],
                            'title' => $button['label'],
                        ]
                    )
                ) . ' ';
        }
        $data .= '</div>';
        return $data;
    }
}