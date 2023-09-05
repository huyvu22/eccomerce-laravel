window.addEventListener("DOMContentLoaded", (event) => {
    /* Handle Address */
    const provinceSelect = document.querySelector('.select_2.province');
    const districtSelect = document.querySelector('.select_2.district');
    const wardSelect = document.querySelector('.select_2.ward');
    const isEditMode = window.location.pathname.endsWith('/edit');

    if (provinceSelect) {
        $(provinceSelect).on('select2:select', async (e) => {
            const provinceId = e.params.data.id;
            if(provinceId >0){
                // const endpoint = `./province/${provinceId}`;
                const endpoint = isEditMode ? `../province/${provinceId}` : `./province/${provinceId}`;

                const res = await fetch(endpoint);
                const data = await res.json();
                if (data.status === 'success') {
                    let option = '<option value="0">Chọn Quận, Huyện</option>\n';
                    let { districts } = data;
                    if (districts.length) {
                        districts.forEach(({ id, _name }) => {
                            option += `<option value="${id}">${_name}</option>\n`;
                        });
                    }
                    districtSelect.innerHTML = option;
                }
                    wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
            }else {
                districtSelect.innerHTML = '<option value="0">Chọn Quận, Huyện</option>\n';
                wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
            }
        });
    }

    if (districtSelect) {
        $(districtSelect).on('select2:select', async (e) => {
            const districtId = e.params.data.id;
            if(districtId >0){
                const endpoint = isEditMode ? `../district/${districtId}` : `./district/${districtId}`;
                const res = await fetch(endpoint);
                const data = await res.json();
                if (data.status === 'success') {
                    let option = '<option value="0">Chọn Phường, Xã</option>\n';
                    let { wards } = data;
                    if (wards.length) {
                        wards.forEach(({ id, _name }) => {
                            option += `<option value="${id}">${_name}</option>\n`;
                        });
                    }
                    wardSelect.innerHTML = option;
                }
            }else {
                wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
            }
        });
    }


});
