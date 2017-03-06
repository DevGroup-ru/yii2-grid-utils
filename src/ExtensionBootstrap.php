<?php

namespace DevGroup\GridUtils;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Widget;
use yii\grid\GridView;

class ExtensionBootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        var_dump($app->controllerMap);die();
        Event::on(GridView::class, Widget::EVENT_INIT, function ($event) {
            /** @var GridView $gridView */
            $gridView = $event->sender;

            foreach ($gridView->columns as $i => $column) {

            }
        });
    }
}
