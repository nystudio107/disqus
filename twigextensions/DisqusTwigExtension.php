<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

class DisqusTwigExtension extends Twig_Extension
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Disqus';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return array(
            'disqusSSO' => new Twig_Filter_Method($this, 'disqusSSO'),
            'disqusEmbed' => new Twig_Filter_Method($this, 'disqusEmbed'),
        );
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array(
            'disqusSSO' => new Twig_Function_Method($this, 'disqusSSO'),
            'disqusEmbed' => new Twig_Function_Method($this, 'disqusEmbed'),
        );
    }

    /**
     * @return mixed
     */
    public function disqusSSO()
    {
        return craft()->disqus->outputSSOTag();
    }

    /**
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     * @param string $disqusLanguage
     *
     * @return mixed
     */
    public function disqusEmbed(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = "",
        $disqusLanguage = ""
    ) {
        return craft()->disqus->outputEmbedTag(
            $disqusIdentifier,
            $disqusTitle,
            $disqusUrl,
            $disqusCategoryId,
            $disqusLanguage
        );
    }
}
