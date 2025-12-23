<?php
require_once dirname(__FILE__, 2) . '/index.class.php';

class HyvorTalkManageManagerController extends HyvorTalkBaseManagerController
{

    public function process(array $scriptProperties = []): void
    {
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('hyvortalk');
    }

    public function loadCustomCssJs(): void
    {
        $this->addLastJavascript($this->hyvortalk->getOption('jsUrl') . 'mgr/widgets/manage.panel.js');
        $this->addLastJavascript($this->hyvortalk->getOption('jsUrl') . 'mgr/sections/manage.js');

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "hyvortalk-page-manage"});
                });
            </script>
        '
        );
    }

    public function getTemplateFile(): string
    {
        return $this->hyvortalk->getOption('templatesPath') . 'manage.tpl';
    }

}
