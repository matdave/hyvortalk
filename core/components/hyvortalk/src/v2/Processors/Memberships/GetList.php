<?php

namespace MatDave\HyvorTalk\v2\Processors\Memberships;

use MatDave\MODXPackage\Traits\Curl;
class GetList extends \modProcessor
{
    use Curl;

    private string $api = 'https://talk.hyvor.com/api';

    /**
     * @inheritDoc
     */
    public function process()
    {
        $cache = $this->modx->getCacheManager()->get('htmemberships');
        if (empty($cache)) {
            $apiKey = $this->modx->getOption('hyvortalk.console_key');
            $websiteId = $this->modx->getOption('hyvortalk.website_id');
            if (empty($apiKey)) {
                return $this->failure('No Console Api Key Set');
            }
            if (empty($websiteId)) {
                return $this->failure('No website ID found.');
            }
            $version = $this->modx->getVersionData();
            $editor = "MODX; Revolution; rv:" . $version['full_version'];
            $USER_AGENT = "MODX/HyvorTalk ($editor)";
            $response = $this->curl(
                '/console/v1/'.$websiteId.'/membership-plans',
                'GET',
                [],
                [
                    'Accept: application/json',
                    'X-API-KEY: ' . $apiKey,
                ],
                [
                    CURLOPT_USERAGENT => $USER_AGENT,
                ]
            );

            $cache = json_decode($response, true);
            $this->modx->getCacheManager()->set('htmemberships', $cache);
        }
        return $this->outputArray($cache);
    }
}