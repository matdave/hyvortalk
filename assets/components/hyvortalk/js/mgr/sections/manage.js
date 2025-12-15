hyvortalk.page.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: 'hyvortalk-panel-manage',
                renderTo: 'hyvortalk-panel-manage-div'
            }
        ]
    });
    hyvortalk.page.Manage.superclass.constructor.call(this, config);
};
Ext.extend(hyvortalk.page.Manage, MODx.Component);
Ext.reg('hyvortalk-page-manage', hyvortalk.page.Manage);
