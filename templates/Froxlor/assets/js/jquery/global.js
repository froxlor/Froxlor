export default function () {
	$(function () {
		/*
		 * global
		 */
		$('#historyback').on('click', function (e) {
			e.preventDefault();
			history.back(1);
		})

		$('#copySysInfo').on('click', function (e) {
			e.preventDefault();
			navigator.clipboard.writeText($('#ccSysInfo').text().trim());
		})

		$('[data-bs-toggle="popover"]').each(function () {
			new bootstrap.Popover($(this));
		})
	});
}
