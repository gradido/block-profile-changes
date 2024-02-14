<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\blockprofilechanges;

use humhub\components\Controller;
use humhub\modules\user\widgets\AccountMenu;
use humhub\modules\user\widgets\AccountProfileMenu;
use Yii;
use yii\base\ActionEvent;
use yii\base\WidgetEvent;
use yii\helpers\Url;
use yii\web\HttpException;

class Events
{
    public static function onControllerAction(ActionEvent $event)
    {
        /** @var Controller $controller */
        $controller = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('block-profile-changes');

        if (in_array($controller->id . '.' . $event->action->id, $module->forbiddenActions)) {
            $event->isValid = false;
            $event->result = Yii::$app->response->redirect(['/activity/user']);
        }
    }

    public static function onAccountMenu(WidgetEvent $event)
    {
        /** @var AccountMenu $accountMenu */
        $accountProfileMenu = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('block-profile-changes');
        if(isset($module->removeMenuEntries['AccountMenu'])) {
            foreach($module->removeMenuEntries['AccountMenu'] as $url) {
                $accountProfileMenu->deleteItemByUrl(Url::to([$url]));
            }
        }
    }

    public static function onAccountProfileMenu(WidgetEvent $event)
    {
        /** @var AccountProfileMenu $accountProfileMenu */
        $accountProfileMenu = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('block-profile-changes');
        if(isset($module->removeMenuEntries['AccountProfileMenu'])) {
            foreach($module->removeMenuEntries['AccountProfileMenu'] as $url) {
                $accountProfileMenu->deleteItemByUrl(Url::to([$url]));
            }
        }
    }
}
