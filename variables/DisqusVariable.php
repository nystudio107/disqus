<?php
namespace Craft;

class DisqusVariable
{

/* --------------------------------------------------------------------------------
	Variables
-------------------------------------------------------------------------------- */

    function disqusSSO($userId = 0)
    {
		return craft()->disqus_utils->outputSSOTag($userId);
    } /* -- disqusSSO */

    function disqusEmbed($disqusIdentifier = "", $disqusTitle = "", $disqusUrl = "", $disqusCategoryId = "")
    {
		return craft()->disqus_utils->outputEmbedTag($disqusIdentifier, $disqusTitle, $disqusUrl, $disqusCategoryId);
    } /* -- disqusEmbed */
	
    function getSettings() {
        return craft()->plugins->getPlugin('disqus')->getSettings();
    }
}
