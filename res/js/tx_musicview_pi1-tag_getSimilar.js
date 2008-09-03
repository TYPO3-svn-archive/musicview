
Ext.onReady(function() {
	Ext.get('tag.getSimilar-search').on('click', function(){
		
		var msg = Ext.get('tag.getSimilar-result');
		msg.load({
			url: 'http://walnut-walnut/typo3conf/ext/musicview/test.php', // <-- change if necessary
			params: 'name=' + Ext.get('tag.getSimilar-input').dom.value + '&PATH_tslib=' + Ext.get('tag.getSimilar-PATH_tslib').dom.value,
			text: 'Updating...'
		});
		msg.show();
	});
});