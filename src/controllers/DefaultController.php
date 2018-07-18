<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license MIT
 */

namespace craft\query\controllers;

use Craft;
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

        $sql = Craft::$app->getRequest()->getRequiredBodyParam('sql');
        try {
            if ($sql) {
                $result = Craft::$app->getDb()->createCommand($sql)->queryAll();
            } else {
                $result = [];
            }
        } catch (\Exception $e) {
            return $this->asJson([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return $this->asJson([
            'success' => true,
            'result' => $result,
            'formattedTotal' => Craft::$app->getFormatter()->asInteger(count($result)),
        ]);
    }
}
