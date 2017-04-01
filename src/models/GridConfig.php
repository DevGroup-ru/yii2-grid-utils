<?php

namespace DevGroup\GridUtils\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%grid_config}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $grid_id
 * @property resource $config
 */
class GridConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%grid_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['grid_id'], 'required'],
            [['config'], 'string'],
            [['grid_id'], 'string', 'max' => 40],
            [['grid_id', 'user_id'], 'unique', 'targetAttribute' => ['grid_id', 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('grid-utils', 'ID'),
            'user_id' => Yii::t('grid-utils', 'User ID'),
            'grid_id' => Yii::t('grid-utils', 'Grid ID'),
            'config' => Yii::t('grid-utils', 'Config'),
        ];
    }

    public static function getConfig($gridId, array $columns)
    {
        $userId = Yii::$app->user->id;
        $cacheKey = "GridConfig:$gridId:$userId";

        $columnsFromConfig = [];
        $model = Yii::$app->cache->get($cacheKey);
        if ($model === false) {
            $model = static::find()
                ->where([
                    'user_id' => $userId,
                    'grid_id' => $gridId,
                ])
                ->one();
            if ($model !== null) {
                Yii::$app->cache->set($cacheKey, $model, 86400);
            }

            try {
                $columnsFromConfig = Json::decode($model->config);
            } catch (\Exception $exception) {

            }
        }


        return ArrayHelper::merge($columns, $model);
    }

    public static function saveConfig($gridId, array $columns)
    {
        $userId = Yii::$app->user->id;
        $cacheKey = "GridConfig:$gridId:$userId";

        $model = Yii::$app->cache->get($cacheKey);
        if ($model === false) {
            $model = new static([
                'user_id' => $userId,
                'grid_id' => $gridId,
            ]);
        }
        $model->config = Json::encode($columns);
        $model->save();
        Yii::$app->cache->set($cacheKey, $model, 86400);
    }
}