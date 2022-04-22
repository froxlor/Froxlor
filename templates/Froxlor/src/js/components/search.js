$(function() {
	let search = $('#search')

	search.on('submit', function (e) {
		e.preventDefault();
	});

	search.find('input').on('keyup', function () {
		let query = $(this).val();
		let dropdown = $('#search .search-results');
		// Hide search if query is empty
		if (!query.length) {
			dropdown.hide().html('');
			return;
		}
		// Show notification for short search query
		if (query.length && query.length < 3) {
			dropdown.show().html('<li class="list-group-item text-muted">Please enter more than 2 characters</li>');
			return;
		}
		// Search
		$.ajax({
			url: "lib/ajax.php?action=searchglobal&theme=" + window.$theme,
			type: "POST",
			data: {
				searchtext: query
			},
			dataType: "json",
			success: data => {
				// Show notification if we got no results
				if (Object.keys(data).length === 0) {
					dropdown.show().html('<li class="list-group-item text-muted">Nothing found!</li>');
					return;
				}

				// Clear dropdown and show results
				dropdown.show().html('');
				Object.keys(data).forEach(key => {
					dropdown.append('<li class="list-group-item text-muted text-capitalize">' + key + '</li>');
					data[key].forEach(item => {
						dropdown.append('<li class="list-group-item"><a href="' + item.href + '" class="text-decoration-none">' + item.title + '</a></li>');
					});
				});
			},
			error: function (a, b) {
				console.log(a, b);
				dropdown.show().html('<li class="list-group-item text-muted">Whoops we got some errors!</li>');
			}
		});
	});
});
