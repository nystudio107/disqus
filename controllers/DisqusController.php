<?php
namespace Craft;

class DisqusController extends BaseController
{
	protected $allowAnonymous = array('logoutRedirect');
	
    public function actionLogoutRedirect()
    {
        craft()->userSession->logout(false);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
?>