$(function() {

	var filebrowserDataUrl = '/routing/mediafebrowser/';
	var isFolderRequested = false;

	//
	// React on history changes
	//
	if (typeof(window.history.pushState) == 'function') {
		window.onpopstate = function () {
			var folder = document.location.hash.substr(1);
			$mediaFrontendFilebrowser.ajax.url('/routing/mediafebrowser/' + folder).load();
		};
	}

	//
	// Append folder to file browser data URL when a folder is pre-selected
	//
	if (document.location.hash) {
		filebrowserDataUrl += document.location.hash.substr(1);
		isFolderRequested = true;
	}

	//
	// Load the file browser
	//
	var $mediaFrontendFilebrowser = $('#mediaFrontend-filebrowser').DataTable({
		"ajax": {
			url: filebrowserDataUrl
		},
		"pageLength": 25,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
		},
		"columnDefs": [
			{
				"render": function(data, type, row) {
					return '<i class="' + row.fileTypeIconClass + '"></i>';
				},
				"orderable": false,
				"targets": 0
			},
			{
				"render": function(data, type, row) {
					return '<a target="_blank" href="' + row.publicUrl + '">' + row.name + '</a>';
				},
				"targets": 1
			},
			{
				"render": function(data, type, row) {
					return row.modificationTime;
				},
				"targets": 2
			}
		]
	});

	//
	// Load the tree view
	//
	var $mediaFrontendTree = $("#mediaFrontend-tree").fancytree({
		source: {
			url: "/routing/mediafetree/" + MediaFrontend.configurationContentUid
		},
		init: function(event, data) {
			if (!isFolderRequested) {
				// Activate the first node on initialization
				var firstNode = data.tree.getFirstChild();
				data.tree.activateKey(firstNode.key);
			}
		},
		activate: function(event, data){
			// A node was activated: display its title:
			var node = data.node;

			if (typeof(window.history.pushState) == 'function') {
				var currentUrl = document.location.href.match(/(^[^#]*)/)[0];
				var hash = '#' + node.key;
				window.history.pushState(null, '', currentUrl + hash);
			}
			$mediaFrontendFilebrowser.ajax.url('/routing/mediafebrowser/' + node.key).load();
		}
	});
});