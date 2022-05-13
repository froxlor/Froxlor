$(function () {
	/*
	 * switch between basic and advanced install mode
	 */
	$('#switchInstallMode').on('click', function () {
		var checked = $(this).prop('checked');
		window.location = '/install/install.php' + replaceQueryParam('extended', +checked, window.location.search);
	});

	function replaceQueryParam(param, newval, search) {
		var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
		if (search.match(regex)) {
			search = search.replace(regex, "$1").replace(/&$/, '');
		}
		return search + '&' + param + '=' + newval;
	}
});
