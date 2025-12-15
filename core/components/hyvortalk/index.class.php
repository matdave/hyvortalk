<?php
abstract class HyvorTalkBaseManagerController extends modExtraManagerController {
    /** @var \\Matdave\HyvorTalk\HyvorTalk $hyvortalk */
    public $hyvortalk;

    public function initialize(): void
    {
        $this->hyvortalk = $this->modx->services->get('hyvortalk');

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
