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
        return '1.0.4';
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