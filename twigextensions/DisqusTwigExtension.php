<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class DisqusTwigExtension extends \Twig_Extension
{

/* --------------------------------------------------------------------------------
	Expose our filters and functions
-------------------------------------------------------------------------------- */

    public function getName()
    {
        return 'Disqus';
    }

/* -- Return our twig filters */

    public function getFilters()
    {
        return array(
            'disqusSSO' => new \Twig_Filter_Method($this, 'disqusSSO_filter'),
            'disqusEmbed' => new \Twig_Filter_Method($this, 'disqusEmbed_filter'),
        );
    } /* -- getFilters */

/* -- Return our twig functions */

    public function getFunctions()
    {
        return array(
            'disqusSSO' => new \Twig_Function_Method($this, 'disqusSSO_filter'),
            'disqusEmbed' => new \Twig_Function_Method($this, 'disqusEmbed_filter'),
        );
    } /* -- getFunctions */

/* --------------------------------------------------------------------------------
	Filters
-------------------------------------------------------------------------------- */

    function disqusSSO_filter($userId = 0)
    {
		return craft()->disqus_utils->outputSSOTag($userId);
    } /* -- disqusSSO_filter */

    function disqusEmbed_filter($disqusIdentifier = "", $disqusTitle = "", $disqusUrl = "", $disqusCategoryId = "")
    {
		return craft()->disqus_utils->outputEmbedTag($disqusIdentifier, $disqusTitle, $disqusUrl, $disqusCategoryId);
    } /* -- disqusEmbed_filter */

} /* -- DisqusTwigExtension */
