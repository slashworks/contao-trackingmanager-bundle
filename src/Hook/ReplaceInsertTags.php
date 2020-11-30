<?php

namespace Slashworks\ContaoTrackingManagerBundle\Hook;

use Symfony\Component\VarDumper\VarDumper;

class ReplaceInsertTags
{

    public function replaceTrackingManagerEditor(string $tag, $useCache, $cachedValue, $flags, $tags, $cache)
    {
        $parts = explode('::', $tag);
        if ($parts[0] === 'tm_editor') {
            $text = $parts[1] ?: $GLOBALS['TL_LANG']['MSC']['TM_EDITOR']['default'];

            return '<span class="trackingmanager-editor-custom" data-action="show_trackingmanager">' . $text . '</span>';
        }

        return false;
    }

}
