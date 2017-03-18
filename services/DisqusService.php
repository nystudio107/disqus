<?php
namespace Craft;

class DisqusService extends BaseApplicationComponent
{
    /**
     * Output the Disqus Tag
     *
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     *
     * @return string
     */
    public function outputEmbedTag(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = ""
    ) {
        $settings = craft()->plugins->getPlugin('disqus')->getSettings();
        $disqusShortname = $settings['disqusShortname'];

        if ($settings['useSSO']) {
            $this->outputSSOTag();
        }

        $vars = array(
            'disqusShortname' => $disqusShortname,
            'disqusIdentifier' => $disqusIdentifier,
            'disqusTitle' => $disqusTitle,
            'disqusUrl' => $disqusUrl,
            'disqusCategoryId' => $disqusCategoryId,
        );
        $result = $this->renderPluginTemplate('disqusEmbedTag', $vars);

        return $result;
    }

    /**
     * Output the Disqus SSO Tag
     *
     * @return string
     */
    public function outputSSOTag()
    {
        $settings = craft()->plugins->getPlugin('disqus')->getSettings();
        $data = array();

        // Set the data array
        $currentUser = craft()->userSession->user;
        if ($currentUser) {
            $data['id'] = $currentUser->id;
            if (craft()->config->get('useEmailAsUsername')) {
                $data['username'] = $currentUser->getFullName();
            } else {
                $data['username'] = $currentUser->username;
            }
            $data['email'] = $currentUser->email;
            $data['avatar'] = $currentUser->getPhotoUrl();
        }

        // Encode the data array and generate the hMac
        $message = base64_encode(json_encode($data));
        $timestamp = time();
        $hMac = $this->disqusHmacSha1(
            $message
            . ' '
            . $timestamp,
            $settings['disqusSecretKey']
        );

        // Set the vars for the template
        $vars = array(
            'message' => $message,
            'hmac' => $hMac,
            'timestamp' => $timestamp,
            'disqusPublicKey' => $disqusPublicKey,
        );

        // Render the SSO custom login template
        if ($settings['customLogin']) {
            $vars = array_merge($vars, array(
                'loginName' => $settings['loginName'],
                'loginButton' => $settings['loginButton'],
                'loginIcon' => $settings['loginIcon'],
                'loginUrl' => $settings['loginUrl'],
                'loginLogoutUrl' => $settings['loginLogoutUrl'],
                'loginWidth' => $settings['loginWidth'],
                'loginHeight' => $settings['loginHeight'],
            ));
            $result = $this->renderPluginTemplate('disqusSsoCustomLogin', $vars);
        } else {
            // Render the SSO template
            $result = $this->renderPluginTemplate('disqusSso', $vars);
        }

        return $result;
    }

    /**
     * Render a plugin template
     *
     * @param $templatePath
     * @param $vars
     *
     * @return string
     */
    protected function renderPluginTemplate($templatePath, $vars)
    {
        // Stash the old template path, and set it to our plugin's templates folder
        $oldPath = method_exists(craft()->templates, 'getTemplatesPath')
            ? craft()->templates->getTemplatesPath()
            : craft()->path->getTemplatesPath();
        $newPath = craft()->path->getPluginsPath() . 'disqus/templates';
        method_exists(craft()->templates, 'setTemplatesPath')
            ? craft()->templates->setTemplatesPath($newPath)
            : craft()->path->setTemplatesPath($newPath);

        // Render the template with our vars passed in
        try {
            $htmlText = craft()->templates->render($templatePath, $vars);
        } catch (\Exception $e) {
            $htmlText = 'Error rendering template ' . $templatePath . ' -> ' . $e->getMessage();
            DisqusPlugin::log($htmlText, LogLevel::Error);
        }

        // Restore the old template path
        method_exists(craft()->templates, 'setTemplatesPath')
            ? craft()->templates->setTemplatesPath($oldPath)
            : craft()->path->setTemplatesPath($oldPath);

        return TemplateHelper::getRaw($htmlText);
    }

    /**
     * HMAC->SHA1
     * From: https://github.com/disqus/DISQUS-API-Recipes/blob/master/sso/php/sso.php
     *
     * @param $data
     * @param $key
     *
     * @return string
     */
    protected function disqusHmacSha1($data, $key)
    {
        $blockSize = 64;
        $hashFunc = 'sha1';
        if (strlen($key) > $blockSize) {
            $key = pack('H*', $hashFunc($key));
        }
        $key = str_pad($key, $blockSize, chr(0x00));
        $iPad = str_repeat(chr(0x36), $blockSize);
        $oPad = str_repeat(chr(0x5c), $blockSize);
        $hMac = pack(
            'H*',
            $hashFunc(
                ($key ^ $oPad).pack(
                    'H*',
                    $hashFunc(
                        ($key ^ $iPad).$data
                    )
                )
            )
        );

        return bin2hex($hMac);
    }
}
