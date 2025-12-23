<?php
abstract class HyvorTalkBaseManagerController extends modExtraManagerController {
    /** @var \MatDave\HyvorTalk\Service $hyvortalk */
    public $hyvortalk;

    public function initialize(): void
    {
        if (!$this->modx->version) {
            $this->modx->getVersionData();
        }
        $version = (int) $this->modx->version['version'];
        if ($version > 2) {
            $this->hyvortalk = $this->modx->services->get('hyvortalk');
        } else {
            $corePath = $this->modx->getOption(
                'hyvortalk.core_path',
                null,
                $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/hyvortalk/'
            );
            $this->hyvortalk = $this->modx->getService(
                'hyvortalk',
                'HyvorTalk',
                $corePath . 'model/hyvortalk/',
                [
                    'core_path' => $corePath
                ]
            );
        }
        $this->addCss($this->hyvortalk->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->hyvortalk->getOption('jsUrl') . 'mgr/hyvortalk.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    hyvortalk.config = '.$this->modx->toJSON($this->hyvortalk->config).';
                });
            </script>
        ');

        parent::initialize();
    }

    public function getLanguageTopics(): array
    {
        return array('hyvortalk:default');
    }

    public function checkPermissions(): bool
    {
        return true;
    }
}
