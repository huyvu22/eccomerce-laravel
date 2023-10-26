<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        const categorySelect = document.querySelector('.category');
        const subCategorySelect = document.querySelector('.sub_category');
        const childCategorySelect = document.querySelector('.child_category');

        //-- Handle category => subCategory => childCategory--//
        const isEditMode = window.location.pathname.endsWith('/edit');

        if (categorySelect) {
            categorySelect.addEventListener('change', async (e) => {
                const categoryId = e.target.value;
                if (categoryId > 0) {
                    const endpoint = isEditMode ? `../get-sub-category/${categoryId}` : `./get-sub-category/${categoryId}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === 'success') {
                        let option = '<option value="0">Select</option>\n';
                        let {subCategories} = data;
                        if (subCategories.length) {
                            subCategories.forEach(({id, name}) => {
                                option += `<option value="${id}">${name}</option>\n`;
                            });
                        }
                        subCategorySelect.innerHTML = option;
                    }
                    childCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                } else {
                    subCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                    childCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                }
            });
        }

        if (subCategorySelect) {
            subCategorySelect.addEventListener('change', async (e) => {
                const subCategoryId = e.target.value;
                if (subCategoryId > 0) {
                    const endpoint = isEditMode ? `../get-child-category/${subCategoryId}` : `./get-child-category/${subCategoryId}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === 'success') {
                        let option = '<option value="0">Select</option>\n';
                        let {childCategories} = data;
                        if (childCategories.length) {
                            childCategories.forEach(({id, name}) => {
                                option += `<option value="${id}">${name}</option>\n`;
                            });
                        }
                        childCategorySelect.innerHTML = option;
                    }
                } else {
                    childCategorySelect.innerHTML = '<option value="0">Select</option>\n';
                }
            });
        }

        /* Handle Toggle Status */

        if (document.querySelector('.data-table')) {
            document.querySelector('.data-table').addEventListener('change', async (e) => {
                e.preventDefault();

                const formChangeStatus = e.target.closest('.form-status');
                const formData = new FormData(formChangeStatus);
                formData.append('switch_status', e.target.checked ? 1 : 0);
                try {
                    const response = await fetch(formChangeStatus.action, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams(formData).toString(),
                    });
                    const data = await response.json();
                    toastr.success(data.message);
                } catch (error) {
                    console.log('fail');
                    toastr.error('Something went wrong');
                }
            });
        }

        /* Handle Delete Item */
        if (document.querySelector('.data-table')) {
            document.querySelector('.data-table').addEventListener('click', async (e) => {
                if (e.target.classList.contains('btn-delete-item')) {
                    e.preventDefault();
                    const formDelete = e.target.closest('.form-delete');
                    if (formDelete) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                formDelete.submit();
                            }
                        });
                    }
                }
            });
        }


        /* Handle Toggle Approved */
        if (document.querySelector('.data-table')) {
            document.querySelector('.data-table').addEventListener('change', async (e) => {
                if (e.target.classList.contains('is_approved')) {
                    e.preventDefault();
                    const productId = e.target.dataset.productId;
                    const selectedValue = e.target.value;
                    const endpoint = `./seller-pending-products/update-approved/${productId}/${selectedValue}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status == 200) {
                        // toastr.success(data.message);
                        window.location.reload();
                    }
                }
            });
        }

    });

</script>
