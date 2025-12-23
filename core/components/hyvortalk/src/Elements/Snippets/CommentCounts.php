<?php

namespace MatDave\HyvorTalk\Elements\Snippets;

use MatDave\MODXPackage\Elements\Snippet\Snippet;

class CommentCounts extends Snippet
{
    public function run()
    {
        $page = (int) ($this->modx->getOption('page', $this->scriptProperties, 0, true) ?? $this->modx->resource->id);
        if (!$page) {
            $page = $this->modx->resource->id;
        }
        $resource = $this->modx->resource;
        if ($page !== $this->modx->resource->id) {
            $resource = $this->modx->getObject('modResource', $page);
            if (!$resource) {
                $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'HyvorTalk: Resource not found for page ID ' . $page . '.');
                return null;
            }
        }
        $pageId = $this->modx->getOption('hyvortalk.page_identifier', $this->modx->config, 'id');
        $websiteId = $this->modx->getOption('hyvortalk.website_id', $this->modx->config);
        $tpl = $this->modx->getOption('tpl', $this->scriptProperties, null, true) ?? 'hyvortalk-comment-counts';
        $addJS = (bool) $this->modx->getOption('addJS', $this->scriptProperties, true);
        $language = $this->modx->getOption('language', $this->scriptProperties, null, true) ?? $this->modx->getOption('cultureKey', $this->modx->config, 'en');
        $mode = $this->modx->getOption('mode', $this->scriptProperties, null, true) ?? 'number';
        if ($addJS) {
            $this->modx->regClientScript('https://talk.hyvor.com/embed/comment-counts.js');
            $this->modx->regClientHTMLBlock('
                <script>
                hyvorTalkCommentCounts.load({
                    "website-id": '.$websiteId.',
                    "mode": "'.$mode.'",
                    "language": "'.$language.'"
                })
                </script>
            ');
        }

        $values = [
            'pageId' => $resource->get($pageId),
        ];

        return $this->modx->getChunk($tpl, $values);
    }
}