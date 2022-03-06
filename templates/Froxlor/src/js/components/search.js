$(document).ready(function () {
	console.log('included search');

	$.typeahead({
		input: '.js-typeahead-search_v1',
		order: "desc",
		dynamic: true,
		display: ['data.title'],
		href: "{{url}}",
		emptyTemplate: "No results for {{query}}",
		debug: true,
		source: {
			settings: {
				ajax: {
					method: "post",
					url: "lib/ajax.php?action=searchsetting&theme=" + window.$theme + "&s=" + window.$session,
					path: "title",
					data: {
						searchtext: '{{query}}'
					},
				}
			},
		},
		callback: {
			onInit: function (node) {
				console.log('Typeahead Initiated');
			}
		}
	});
});
