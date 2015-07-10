<?php

namespace frontend\widgets\StoreForm;

use common\models\User;
use frontend\models\Exception\UserStoreOwnerUndefinedException;
use frontend\models\StoreForm;
use Psr\Log\LogLevel;
use Yii;
use yii\base\Widget;

/**
 * Class StoreFormWidget
 * @package frontend\widgets
 */
class StoreFormWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $post = Yii::$app->request->post();
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $storeForm = new StoreForm();
        if ($storeForm->load($post)) {
            if ($storeForm->validate()) {
                try {
                    $storeForm->save($user);
                    Yii::$app->controller->redirect(['your-stores/index']);
                } catch (UserStoreOwnerUndefinedException $e) {
                    $storeForm->addError($storeForm->activeAttributes()[0], sprintf(
                        'User %s has not store owner', $e->getUser()->username
                    ));
                    Yii::getLogger()->log($e->getMessage(), LogLevel::ERROR);
                }
            }
        } else {
            $storeId = Yii::$app->request->get('storeId');
            if ($storeId) {
                $storeForm->setData($storeId);
            }
        }
        return $this->render('default', ['model' => $storeForm]);
    }
}