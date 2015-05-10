<?php
namespace Craft;

class DisqusPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Disqus');
    }

    function getVersion()
    {
        return '1.0.0';
    }

    function getDeveloper()
    {
        return 'Megalomaniac';
    }

    function getDeveloperUrl()
    {
        return 'http://www.megalomaniac.com';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.disqus.twigextensions.DisqusTwigExtension');

        return new DisqusTwigExtension();
    }

	protected function defineSettings()
	{
		return array(
			'disqusShortname' => array(AttributeType::String, 'label' => 'Disqus Site Short Name', 'default' => ''),
			'useSSO' => array(AttributeType::Bool, 'label' => 'Use Single Sign On', 'default' => false),
			'disqusPublicKey' => array(AttributeType::String, 'label' => 'Disqus Public Key', 'default' => ''),
			'disqusSecretKey' => array(AttributeType::String, 'label' => 'Disqus Secret Key', 'default' => ''),
			'customLogin' => array(AttributeType::Bool, 'label' => 'Use Custom Login/Logout URLs', 'default' => false),
			'loginName' => array(AttributeType::String, 'label' => 'name', 'default' => ''),
			'loginButton' => array(AttributeType::String, 'label' => 'button', 'default' => ''),
			'loginIcon' => array(AttributeType::String, 'label' => 'icon', 'default' => ''),
			'loginUrl' => array(AttributeType::String, 'label' => 'url', 'default' => ''),
			'loginLogoutUrl' => array(AttributeType::String, 'label' => 'logout', 'default' => ''),
			'loginWidth' => array(AttributeType::String, 'label' => 'width', 'default' => '800'),
			'loginHeight' => array(AttributeType::String, 'label' => 'height', 'default' => '400'),
		);
	}

    public function getSettingsHtml()
	{
       return craft()->templates->render('disqus/settings', array(
           'settings' => $this->getSettings()
       ));
	}

}