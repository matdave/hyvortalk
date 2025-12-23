<?php

namespace MatDave\HyvorTalk\Elements\Snippets;

use MatDave\MODXPackage\Elements\Snippet\Snippet;

class Comments extends Snippet
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
        $sso = (bool) $this->modx->getOption('hyvortalk.sso_enabled', $this->modx->config, false);
        $privateKey = $this->modx->getOption('hyvortalk.private_key', $this->modx->config);
        if ($sso && empty($privateKey)) {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'HyvorTalk: SSO enabled, but private key is not set.');
            return null;
        }
        $pageId = $this->modx->getOption('hyvortalk.page_identifier', $this->modx->config, 'id');
        $websiteId = $this->modx->getOption('hyvortalk.website_id', $this->modx->config);
        $tpl = $this->modx->getOption('tpl', $this->scriptProperties, null, true) ?? 'hyvortalk-comments';
        $settings = $this->modx->getOption('settings', $this->scriptProperties, null, true) ?? '{}';
        $addJS = (bool) $this->modx->getOption('addJS', $this->scriptProperties, true);
        $pageTitle = $this->modx->getOption('pageTitle', $this->scriptProperties, null, true) ?? $resource->get('pagetitle');
        $pageTitle = strip_tags($pageTitle);
        $pageTitle = str_replace('"', "'", $pageTitle);
        $language = $this->modx->getOption('language', $this->scriptProperties, null, true) ?? $this->modx->getOption('cultureKey', $this->modx->config, 'en');
        $loading = $this->modx->getOption('loading', $this->scriptProperties, null, true) ?? 'default';

        $user = $this->modx->user;
        $userHash = null;
        $ssoHash = null;
        if ($user->isAuthenticated($resource->get('context_key')) && $sso) {
            $profile = $user->getOne('Profile');
            $userData = [
                'timestamp' => time(),
                'id' => $user->id,
                'name' => $user->username,
                'email' => $profile->email
            ];
            $json = json_encode($userData);
            $userHash = base64_encode($json);
            $ssoHash = hash_hmac('sha256', $userHash, $privateKey);
        }

        if ($addJS) {
            $this->modx->regClientScript('https://talk.hyvor.com/embed/embed.js');
        }

        $values = [
            'user' => $userHash ? "sso-user=\"{$userHash}\"" : "",
            'hash' => $ssoHash ? "sso-hash=\"{$ssoHash}\"" : "",
            'pageId' => $resource->get($pageId),
            'websiteId' => $websiteId,
            'settings' => $settings,
            'language' => $language,
            'pageTitle' => $pageTitle,
            'loading' => $loading
        ];

        return $this->modx->getChunk($tpl, $values);
    }
}