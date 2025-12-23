hyvortalk.combo.Memberships = function (config) {
    config = config || {};
    Ext.applyIf(config, {

        url: hyvortalk.config.connectorUrl,
        baseParams: {
            action: 'MatDave\\HyvorTalk\\Processors\\Memberships\\GetList'
        },
        fields: ['name'],
        pageSize: 20,
        valueField: 'name',
        displayField: 'name',
        mode: 'remote',
        triggerAction: 'all',
        editable:true,
    });
    hyvortalk.combo.Memberships.superclass.constructor.call(this, config);
}
Ext.extend(hyvortalk.combo.Memberships, MODx.combo.ComboBox);
Ext.reg('hyvortalk-combo-memberships', hyvortalk.combo.Memberships);