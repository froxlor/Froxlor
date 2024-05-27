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

		if (!window.isSecureContext) {
			// hide all copyClipboard buttons as this only works in a secure context
			$('.copyClipboard').hide();
		}

		$('.copyClipboard').on('click', function (e) {
			e.preventDefault();
			const source_element = $(this).data('clipboard-source');
			navigator.clipboard.writeText($('#' + source_element).text().trim());
		})

	});
}
