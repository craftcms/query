<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   MIT
 */

namespace craft\query\controllers;

use craft\web\Controller;

/**
 * Query controller class
 */
class DefaultController extends Controller
{
    /**
     * For executing the database query.
     *
     * @return \yii\web\Response
     */
    public function actionExecute()
    {
        $this->requirePermission('utility:query');
        $this->requireAcceptsJson();
        $sql = \Craft::$app->getRequest()->getRequiredBodyParam('sql');
        $success = true;

        try {
            if ($sql) {
                $result = \Craft::$app->getDb()->createCommand($sql)->queryAll();
            } else {
                $result = [];
            }
        } catch(\Exception $e) {
            $result = $e->getMessage();
            $success = false;
        }

        return $this->asJson([
            'result' => $result,
            'success' => $success,
        ]);
    }
}
