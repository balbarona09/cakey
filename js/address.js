import addresses from '../address.json' assert {type: 'json'};

const regionSelect = document.getElementById('region');
const provinceSelect = document.getElementById('province');
const citySelect = document.getElementById('city');
const barangaySelect = document.getElementById('barangay');

if(regionSelect != null) {
	updateRegions();
	updateProvinces();
	updateCities();
	updateBarangays();
	
	regionSelect.addEventListener('change', function() {
		updateProvinces();
		updateCities();
		updateBarangays();
	})

	provinceSelect.addEventListener('change', function() {
		updateCities();
		updateBarangays();
	});

	citySelect.addEventListener('change', function() {
		updateBarangays();
	});
}

function updateRegions(selected = '') {
	regionSelect.innerHTML = '';
	for(const region of Object.keys(addresses)) {
		const regionOption = document.createElement('option');
		if(region == selected) {
			regionOption.setAttribute('selected', true);
		}
		regionOption.innerHTML = region;
		regionSelect.appendChild(regionOption);
	}
}

function  updateProvinces(selected = '') {
	provinceSelect.innerHTML = '';
	for(const province of Object.keys(addresses[regionSelect.value]['province_list'])) {
		const provinceOption = document.createElement('option');
		if(province == selected) {
			provinceOption.setAttribute('selected', true);
		}
		provinceOption.innerHTML = province;
		provinceSelect.appendChild(provinceOption);
	}
}

function updateCities(selected = '') {
	citySelect.innerHTML = '';
	for(const city of Object.keys(addresses[regionSelect.value]['province_list'][provinceSelect.value]['municipality_list'])) {
		const cityOption = document.createElement('option');
		if(city == selected) {
			cityOption.setAttribute('selected', true);
		}
		cityOption.innerHTML = city;
		citySelect.appendChild(cityOption);
	}
}

function updateBarangays(selected = '') {
	barangaySelect.innerHTML = '';
	for(const barangay of addresses[regionSelect.value]['province_list'][provinceSelect.value]['municipality_list'][citySelect.value]['barangay_list']) {
		const barangayOption = document.createElement('option');
		if(barangay == selected) {
			barangayOption.setAttribute('selected', true);
		}
		barangayOption.innerHTML = barangay;
		barangaySelect.appendChild(barangayOption);
	}
}

export {updateRegions, updateProvinces, updateCities, updateBarangays};