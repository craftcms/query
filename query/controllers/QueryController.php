<?php
namespace Craft;

/**
 * Query controller class
 */
class QueryController extends BaseController
{
	public function actionExecute()
	{
		$this->requirePostRequest();
		craft()->userSession->requireAdmin();

		$sql = craft()->request->getRequiredPost('sql');

		if ($sql)
		{
			$result = craft()->db->createCommand()->setText($sql)->queryAll();

			craft()->urlManager->setRouteVariables(array(
				'sql'    => $sql,
				'result' => $result
			));
		}
	}
}
