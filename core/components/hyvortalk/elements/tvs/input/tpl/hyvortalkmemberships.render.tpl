<div id="tv{$tv->id}"></div>

<script type="text/javascript">
    // <![CDATA[
    {literal}
    Ext.onReady(function() {
        MODx.load({
            {/literal}
            xtype: 'hyvortalk-combo-memberships'
            ,renderTo: 'tv{$tv->id}'
            ,name: 'tv{$tv->id}'
            ,hiddenName: 'tv{$tv->id}'
            ,value: '{$tv->get('value')}'
            ,width: '99%'
            {literal}
        });
        {/literal}
        {literal}
    });
    {/literal}
    // ]]>
</script>
