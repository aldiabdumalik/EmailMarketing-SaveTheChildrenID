export function loading_start () {
	$('body').loading({
		theme: 'dark'
	});
}
export function loading_stop() {
	$('body').loading('stop');
}
export function myurl(url=null) {
	return `${$('.base-url').data('baseurl')}${url}`
}
export function toast(ress) {
	$.toast({
		text: ress.message,
		position: 'top-right',
		loaderBg: '#FFF',
		icon: ress.status,
		hideAfter: 3000,
		stack: 1
	});
	if (ress.status=='success' && ress.url != null) {
		setTimeout(function () {
			window.location.href = $('.base-url').data('baseurl') + ress.url;
		}, 3000);
	}
}
export function redirect(url) {
	window.location.href = $('.base-url').data('baseurl') + url;
}