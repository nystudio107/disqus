<?php
namespace Craft;

class DisqusPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Disqus');
    }

    public function getDescription()
    {
        return 'A simple plugin for integrating Disqus into Craft CMS websites, including Single Sign On (SSO) and custom login/logout URLs.';
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/khalwat/disqus/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/khalwat/disqus/master/releases.json';
    }

    public function getVersion()
    {
        return '1.0.3';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    function getDeveloper()
    {
        return 'nystudio107';
    }

    function getDeveloperUrl()
    {
        return 'http://nystudio107.com';
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
            'disqusShortname' => array(AttributeType::String, 'label' => 'Disqus Site Short Name', 'default' => craft()->config->get('disqusShortname', 'disqus')),
            'useSSO' => array(AttributeType::Bool, 'label' => 'Use Single Sign On', 'default' => craft()->config->get('useSSO', 'disqus')),
            'disqusPublicKey' => array(AttributeType::String, 'label' => 'Disqus Public Key', 'default' => craft()->config->get('disqusPublicKey', 'disqus')),
            'disqusSecretKey' => array(AttributeType::String, 'label' => 'Disqus Secret Key', 'default' => craft()->config->get('disqusSecretKey', 'disqus')),
            'customLogin' => array(AttributeType::Bool, 'label' => 'Use Custom Login/Logout URLs', 'default' => craft()->config->get('customLogin', 'disqus')),
            'loginName' => array(AttributeType::String, 'label' => 'name', 'default' => craft()->config->get('loginName', 'disqus')),
            'loginButton' => array(AttributeType::String, 'label' => 'button', 'default' => craft()->config->get('loginButton', 'disqus')),
            'loginIcon' => array(AttributeType::String, 'label' => 'icon', 'default' => craft()->config->get('loginIcon', 'disqus')),
            'loginUrl' => array(AttributeType::String, 'label' => 'url', 'default' => craft()->config->get('loginUrl', 'disqus')),
            'loginLogoutUrl' => array(AttributeType::String, 'label' => 'logout', 'default' => craft()->config->get('loginLogoutUrl', 'disqus')),
            'loginWidth' => array(AttributeType::String, 'label' => 'width', 'default' => craft()->config->get('loginWidth', 'disqus')),
            'loginHeight' => array(AttributeType::String, 'label' => 'height', 'default' => craft()->config->get('loginHeight', 'disqus')),
        );
    }

    public function getSettings()
    {
        $settings = parent::getSettings();
        $base = $this->defineSettings();

        foreach ($base as $key => $row) {
            $override = craft()->config->get($key, 'disqus');

            if (!is_null($override)) {
                $settings->$key = $override;
            }
        }

        return $settings;
    }

    public function getSettingsHtml()
    {
       return craft()->templates->render('disqus/settings', array(
           'settings' => $this->getSettings()
       ));
    }

}
