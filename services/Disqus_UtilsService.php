<?php
namespace Craft;

class Disqus_UtilsService extends BaseApplicationComponent
{

/* --------------------------------------------------------------------------------
    Output the Disqus SSO Tag
-------------------------------------------------------------------------------- */

    public function outputSSOTag($userId = 0)
    {
        $result = "";
        $settings = craft()->plugins->getPlugin('disqus')->getSettings();
        $data = array();

        $currentUser = craft()->userSession->user;
        if ($currentUser)
        {
            $data['id'] = $currentUser->id;
            if (craft()->config->get('useEmailAsUsername'))
                $data['username'] = $currentUser->getFullName();
            else
                $data['username'] = $currentUser->username;
            $data['email'] = $currentUser->email;
            $data['avatar'] = $currentUser->getPhotoUrl();
        }

        $message = base64_encode(json_encode($data));
        $timestamp = time();
        $hmac = dsq_hmacsha1($message . ' ' . $timestamp, $settings['disqusSecretKey']);

        if ($settings['customLogin'])
        {
            $disqusPublicKey = $settings['disqusPublicKey'];
            $loginName = $settings['loginName'];
            $loginButton = $settings['loginButton'];
            $loginIcon = $settings['loginIcon'];
            $loginUrl = $settings['loginUrl'];
            $loginLogoutUrl = $settings['loginLogoutUrl'];
            $loginWidth = $settings['loginWidth'];
            $loginHeight = $settings['loginHeight'];

            echo <<<ENDBLOCK
<script type="text/javascript">
var _old_disqus_config = disqus_config ;
var disqus_config = function() {
    _old_disqus_config.apply(this);
    this.page.remote_auth_s3 = "$message $hmac $timestamp";
    this.page.api_key = "$disqusPublicKey";

    this.sso = {
          name:   "$loginName",
          button: "$loginButton",
          icon:   "$loginIcon",
          url:    "$loginUrl",
          logout: "$loginLogoutUrl",
          width:  "$loginWidth",
          height: "$loginHeight"
    };
};
</script>
ENDBLOCK;
        }
        else
        {
            $disqusPublicKey = $settings['disqusPublicKey'];
            echo <<<ENDBLOCK
<script type="text/javascript">
var _old_disqus_config = disqus_config ;
var disqus_config = function() {
    _old_disqus_config.apply(this);
    this.page.remote_auth_s3 = "$message $hmac $timestamp";
    this.page.api_key = "$disqusPublicKey";
};
</script>
ENDBLOCK;
        }
        return $result;
    } /* -- outputSSOTag */

/* --------------------------------------------------------------------------------
    Output the Disqus Tag
-------------------------------------------------------------------------------- */

    public function outputEmbedTag($disqusIdentifier = "", $disqusTitle = "", $disqusUrl = "", $disqusCategoryId = "")
    {
        $result = "";
        $settings = craft()->plugins->getPlugin('disqus')->getSettings();

        if ($settings['useSSO'])
            $this->outputSSOTag();

        $disqusShortname = $settings['disqusShortname'];
        echo <<<ENDBLOCK
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = '$disqusShortname';
    var disqus_identifier = '$disqusIdentifier';
    var disqus_title = '$disqusTitle';
    var disqus_url = '$disqusUrl';
    var disqus_category_id = '$disqusCategoryId';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';

        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>

<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
ENDBLOCK;

        return $result;
    } /* -- outputEmbedTag */

} /* -- Disqus_UtilsService */

/* --------------------------------------------------------------------------------
    HMAC->SHA1
    From: https://github.com/disqus/DISQUS-API-Recipes/blob/master/sso/php/sso.php
-------------------------------------------------------------------------------- */

    function dsq_hmacsha1($data, $key) {
        $blocksize=64;
        $hashfunc='sha1';
        if (strlen($key)>$blocksize)
            $key=pack('H*', $hashfunc($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                    'H*',$hashfunc(
                        ($key^$opad).pack(
                            'H*',$hashfunc(
                                ($key^$ipad).$data
                            )
                        )
                    )
                );
        return bin2hex($hmac);
    } /* -- dsq_hmacsha1 */
