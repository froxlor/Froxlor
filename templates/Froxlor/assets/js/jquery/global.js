export default function () {
	$(function () {
		/*
		 * global
		 */
		$('#historyback').on('click', function (e) {
			e.preventDefault();
			history.back(1);
		})

		$('[data-bs-toggle="popover"]').each(function () {
			new bootstrap.Popover($(this));
		})

		$('.copyClipboard').on('click', function (e) {
			e.preventDefault();
			const source_element = $(this).data('clipboard-source').text();
			navigator.clipboard.writeText($('#' + source_element).text().trim());
		})

	});
}
