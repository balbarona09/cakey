function startLoading() {
	document.getElementById("loader").classList.remove('d-none');
}

function stopLoading() {
	document.getElementById("loader").classList.add('d-none');
}

function displayResult(message, status, additionalClass = '', dismissable = false, elementId = 'result') {
	let result = document.getElementById(elementId);
	if(status == 'danger') {
		result.setAttribute('class', 'alert alert-danger ' + additionalClass);
	}
	else {
		result.setAttribute('class', 'alert alert-success ' + additionalClass);
	}
	result.innerHTML = message;
	result.innerHTML += (dismissable) ? ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">' : '';
	result.addEventListener("close.bs.alert", function (e) {
		e.preventDefault();
		result.innerHTML = '';
		result.setAttribute('class', '');
	});
}