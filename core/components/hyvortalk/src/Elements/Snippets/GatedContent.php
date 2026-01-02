<?php

namespace MatDave\HyvorTalk\Elements\Snippets;

use MatDave\MODXPackage\Elements\Snippet\Snippet;

class GatedContent extends Snippet
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
        $encryptionKey = $this->modx->getOption('hyvortalk.encryption_key', $this->modx->config);
        if (empty($encryptionKey)) {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'HyvorTalk: Encryption key is not set.');
            return null;
        }
        $defaultTitle = $this->modx->getOption('defaultTitle', $this->scriptProperties, null, true) ?? $resource->get('pagetitle');
        $defaultContent = $this->modx->getOption('defaultContent', $this->scriptProperties, null, true) ?? $resource->get('introtext');
        $minimumPlan = $this->modx->getOption('minimumPlan', $this->scriptProperties, null);
        $pageId = $this->modx->getOption('hyvortalk.page_identifier', $this->modx->config, 'id');
        $tpl = $this->modx->getOption('tpl', $this->scriptProperties, null, true) ?? 'hyvortalk-gated-content';

        $content = [
            'page-id' => $resource->get($pageId),
            'timestamp' => time(),
            'content' => $resource->content,
            'minimum-plan' => $minimumPlan,
        ];
        $json = json_encode($content);
        $strong = false;
        $iv = openssl_random_pseudo_bytes(16, $strong);
        if (!$iv || !$strong) {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'HyvorTalk: Error generating encrypted content.');
            return null;
        }
        $encrypted = openssl_encrypt($json,
            'aes-256-cbc', base64_decode($encryptionKey),
            OPENSSL_RAW_DATA,
            $iv);

        $value = [
            'defaultTitle' => $defaultTitle,
            'defaultContent' => $defaultContent,
            'secure' => base64_encode($encrypted) . ':' . base64_encode($iv),
        ];

        return $this->modx->getChunk($tpl, $value);
    }
}