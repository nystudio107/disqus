<?php
namespace Craft;

class DisqusController extends BaseController
{
    /**
     * @var array
     */
    protected $allowAnonymous = array('logoutRedirect');

    /**
     * Log the current user out
     */
    public function actionLogoutRedirect()
    {
        craft()->userSession->logout(false);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
