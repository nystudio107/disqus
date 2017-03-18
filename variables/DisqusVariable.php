<?php
namespace Craft;

class DisqusVariable
{

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
     *
     * @return mixed
     */
    public function disqusEmbed(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = ""
    ) {
        return craft()->disqus->outputEmbedTag(
            $disqusIdentifier,
            $disqusTitle,
            $disqusUrl,
            $disqusCategoryId
        );
    }
}