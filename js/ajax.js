function ajax(parameters, url, callBack) {
	let httpRequest = new XMLHttpRequest();
	let formData = new FormData()
	
	for (let key in parameters) {
		formData.append(key, parameters[key]);
	}
	
	httpRequest.onreadystatechange = function() {
		if(this.readyState != 4) {
			return;
		}
		if(this.status != 200) {
			return;
		}
		callBack(this.responseText);
	}
	
	httpRequest.open("POST", url);
	httpRequest.send(formData);
}

export {ajax};