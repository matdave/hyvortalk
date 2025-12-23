<?php

namespace MatDave\HyvorTalk\Elements\Snippets;

use MatDave\MODXPackage\Elements\Snippet\Snippet;

class Memberships extends Snippet
{
    public function run()
    {
        $sso = (bool) $this->modx->getOption('hyvortalk.sso_enabled', $this->modx->config, false);
        $privateKey = $this->modx->getOption('hyvortalk.private_key', $this->modx->config);
        if ($sso && empty($privateKey)) {
            $this->modx->log(\xPDO::LOG_LEVEL_ERROR, 'HyvorTalk: SSO enabled, but private key is not set.');
            return null;
        }
        $websiteId = $this->modx->getOption('hyvortalk.website_id', $this->modx->config);
        $tpl = $this->modx->getOption('tpl', $this->scriptProperties, null, true) ?? 'hyvortalk-memberships';
        $addJS = (bool) $this->modx->getOption('addJS', $this->scriptProperties, true);
        $language = $this->modx->getOption('language', $this->scriptProperties, null, true) ?? $this->modx->getOption('cultureKey', null, 'en');

        $user = $this->modx->user;
        $userHash = null;
        $ssoHash = null;
        if ($user->isAuthenticated($this->modx->resource->get('context_key')) && $sso) {
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
            $this->modx->regClientScript('https://talk.hyvor.com/embed/memberships.js');
        }

        return $this->modx->getChunk($tpl, [
            'user' => $userHash ? "sso-user=\"{$userHash}\"" : "",
            'hash' => $ssoHash ? "sso-hash=\"{$ssoHash}\"" : "",
            'websiteId' => $websiteId,
            'language' => $language,
        ]);
    }
}