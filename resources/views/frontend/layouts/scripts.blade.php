<script>
    window.addEventListener("DOMContentLoaded", (event) => {

        const formatPrice = (price) => {
            return parseInt(price).toLocaleString('en').replace(/,/g, '.') + '₫';
        }

        // Show Price base on attribute
        const productContainers = document.querySelectorAll('.wsus__pro_details_text');

        if (productContainers.length) {
            productContainers.forEach(productContainer => {
                const variantSelects = productContainer.querySelectorAll('.attribute');
                const productPrice = productContainer.querySelector('span.product_price');
                const productOldPrice = productContainer.querySelector('del.old_product_price');
                const inputPrice = productContainer.querySelector('.input_price');

                const inputValuePrice = inputPrice.value;
                const [currentPrice, oldPrice] = inputValuePrice.split(' ').map(price => parseInt(price));

                if (variantSelects.length) {
                    variantSelects.forEach(variantSelect => {
                        $(variantSelect).on('select2:select', () => {
                            const totalVariantItemPrice = Array.from(variantSelects).reduce((totalPrice, variantSelect) => {
                                const variantItemPrice = parseInt($(variantSelect).select2('data')[0].title);
                                return totalPrice + variantItemPrice;
                            }, currentPrice);

                            if (productOldPrice) {
                                const totalVariantOldPrice = Array.from(variantSelects).reduce((totalOldPrice, variantSelect) => {
                                    const variantItemPrice = parseInt($(variantSelect).select2('data')[0].title);
                                    return totalOldPrice + variantItemPrice;
                                }, oldPrice);

                                productOldPrice.innerText = formatPrice(totalVariantOldPrice);
                                productPrice.innerText = formatPrice(totalVariantItemPrice);
                            } else {
                                productPrice.innerText = formatPrice(totalVariantItemPrice);
                            }
                        });
                    });
                }
            });
        }


        // Show Products in Sidebar
        const sidebarProducts = document.querySelector('.mini-cart-wrapper');
        const fetchSideBarProducts = async (e) => {
            let li = '';
            try {
                const response = await fetch("/cart-products");
                if (response.ok) {
                    const data = await response.json();
                    let {cartProducts} = data;
                    let cartProductArr = Object.values(cartProducts);
                    if (cartProductArr.length) {
                        cartProductArr.forEach((item) => {
                            li += `<li class="mini_cart_${item.rowId}">
                                        <div class="wsus__cart_img">
                                            <a href="{{url('product-detail')}}/${item.options.slug}.html"><img src="{{asset('/')}}${item.options.image}" alt="product" class="img-fluid w-100"></a>
                                            <form class="form-delete-item"  action="{{url('cart/remove-sidebar-product')}}" method="POST">
                                                  @csrf
                            <button class="remove-item wsis__del_icon" data-rowid="${item.rowId}" type="button">&times;</button>
                                            </form>
                                        </div>
                                        <div class="wsus__cart_text">
                                            <a class="wsus__cart_title" href="{{url('product-detail')}}/${item.options.slug}.html">${item.name}</a>
                                            <p>${formatPrice(item.price + item.options.variants_total)}</p>
                                             <small>Qty: ${item.qty}</small>
                                        </div>
                                    </li>`;
                        });

                        sidebarProducts.innerHTML = li;
                        await getSubTotal();
                    }
                } else {
                    console.error("Error fetching cart count");
                }
            } catch (error) {
                console.error("An error occurred while fetching cart products:", error);
            }
        };

        // Show total Price in Sidebar
        const getSubTotal = async () => {
            try {
                const response = await fetch("/cart/sidebar-product-total");
                if (response.ok) {
                    const data = await response.json();
                    document.querySelector('.mini_cart_subtotal').innerHTML = formatPrice(data.total)

                } else {
                    console.error("Error fetching cart count");
                }
            } catch (error) {
                console.error("An error occurred while fetching cart count:", error);
            }
        }

        // Show count cart
        const getCartCount = async () => {
            try {
                const response = await fetch("/cart-count");
                if (response.ok) {
                    const data = await response.json();
                    document.querySelector('.cart-count').innerText = data.count
                } else {
                    console.error("Error fetching cart count");
                }
            } catch (error) {
                console.error("An error occurred while fetching cart count:", error);
            }
        }


        //Add to Cart Button
        const addToCartBtns = document.querySelectorAll('.add_cart');
        if (addToCartBtns.length) {
            addToCartBtns.forEach((addToCartBtn) => {
                addToCartBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const form = e.target.closest('.shopping-cart-form');
                    const formData = new FormData(form);

                    // Click add to cart
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                // 'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        });

                        // Handle the response
                        if (response.ok) {
                            const data = await response.json();
                            if (data.status === 'success') {
                                toastr.success(data.message);
                                await fetchSideBarProducts()
                                await getCartCount()
                                document.querySelector('.mini_cart_actions').classList.remove('d-none');
                            } else if (data.status === 'error') {
                                toastr.error(data.message);
                            }
                        } else {
                            // Error handling
                            console.error('Error submitting the form');
                        }
                    } catch (error) {
                        console.error('An error occurred while submitting the form:', error);
                    }

                });
            })
        }

        //Buy a new product
        const buyNowButtons = document.querySelectorAll('.buy_now');
        if (buyNowButtons.length) {
            buyNowButtons.forEach((buyNowButton) => {
                buyNowButton.addEventListener('click', function (e) {
                    let buyNowRoute = buyNowButton.getAttribute('data-buy-product-route');
                    const cartForm = e.target.closest('.shopping-cart-form');
                    cartForm.action = buyNowRoute;
                    cartForm.method = 'get';
                    cartForm.submit();
                });
            })
        }


        // Remove product from sidebar
        const miniCartWrapper = document.querySelector('.mini-cart-wrapper');
        const miniCartAction = document.querySelector('.mini_cart_actions');
        if (miniCartWrapper) {
            miniCartWrapper.addEventListener('click', async (e) => {
                if (e.target.classList.contains('remove-item')) {
                    e.preventDefault();
                    let rowId = e.target.dataset.rowid

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        const form = e.target.parentNode;

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: `rowId=${rowId}`
                        });

                        // Handle the response
                        if (response.ok) {
                            const data = await response.json();
                            let classItemRemove = 'mini_cart_' + rowId;
                            let listItem = document.querySelector('.' + classItemRemove);
                            listItem.classList.remove(classItemRemove);
                            listItem.remove();

                            if (miniCartWrapper.childElementCount === 0) {
                                miniCartWrapper.innerHTML = `<li class="alert alert-danger text-center" >Empty Cart!</li>`
                                miniCartAction.classList.add('d-none');
                            }
                            countCart.innerText = data.count
                            toastr.success(data.message);

                        } else {
                            // Error handling
                            console.error('Error submitting the form');
                        }
                    } catch (error) {
                        console.error('An error occurred while submitting the form:', error);
                    }
                }
            })
        }

        // Handle add product to wishlist
        const wishlists = document.querySelectorAll('.add_to_wishlist');
        if (wishlists.length) {
            wishlists.forEach(wishlist => {
                wishlist.addEventListener('click', async (e) => {
                    e.preventDefault();
                    let route = e.currentTarget.dataset.route;
                    const response = await fetch(route);
                    let data = await response.json();
                    if (response.status === 200) {
                        toastr.success(data.message);
                        document.querySelector('.count_wishlist_item').innerHTML = data.count;
                    } else {
                        toastr.error(data.message);
                    }
                });
            })
        }

        //Handle subscription
        const subscription = document.querySelector('.subscribe');
        if (subscription) {
            subscription.addEventListener('click', async (e) => {
                e.preventDefault();
                const formSubscribe = e.target.closest('.form_subscribe');
                const formData = new FormData(formSubscribe);

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    // document.querySelector('.subscribe').innerHTML = '<i class="fas fa-spinner fa-spin fa-1x"></i>';
                    document.querySelector('.subscribe').innerHTML = 'Loading...';
                    document.querySelector('.subscribe').classList.add('disabled');

                    const response = await fetch(formSubscribe.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: formData,
                    });
                    document.querySelector('.subscribe').innerHTML = 'Subscribe';
                    document.querySelector('.subscribe').classList.remove('disabled');

                    if (response.ok) {
                        const data = await response.json();
                        if (data.status === 'success') {
                            formSubscribe.querySelector('.email_input').value = '';
                            toastr.success(data.message);
                        } else if (data.status === 'error') {
                            toastr.error(data.message);
                        }
                    } else {
                        // Error handling
                        const errorData = await response.json();

                        toastr.error(errorData.message);
                    }

                } catch (error) {
                    console.error('An error occurred while submitting the form:', error);
                }
            });
        }

        /* Handle Toggle Status */
        if (document.querySelector('.wsus__dashboard_profile')) {
            document.querySelector('.wsus__dashboard_profile').addEventListener('change', async (e) => {
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
        if (document.querySelector('.wsus__dashboard_profile')) {
            document.querySelector('.wsus__dashboard_profile').addEventListener('click', async (e) => {
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

        /* Handle Address */
        const provinceSelect = document.querySelector(".select_2.province");
        const districtSelect = document.querySelector(".select_2.district");
        const wardSelect = document.querySelector(".select_2.ward");
        const isEditMode = window.location.pathname.endsWith("/edit");

        if (provinceSelect) {
            $(provinceSelect).on("select2:select", async (e) => {
                const provinceId = e.params.data.id;
                if (provinceId > 0) {
                    // const endpoint = `./province/${provinceId}`;
                    const endpoint = isEditMode
                        ? `../province/${provinceId}`
                        : `./province/${provinceId}`;

                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === "success") {
                        let option =
                            '<option value="0">Chọn Quận, Huyện</option>\n';
                        let {districts} = data;
                        if (districts.length) {
                            districts.forEach(({id, _name}) => {
                                option += `<option value="${id}">${_name}</option>\n`;
                            });
                        }
                        districtSelect.innerHTML = option;
                    }
                    wardSelect.innerHTML =
                        '<option value="0">Chọn Phường, Xã</option>\n';
                } else {
                    districtSelect.innerHTML =
                        '<option value="0">Chọn Quận, Huyện</option>\n';
                    wardSelect.innerHTML =
                        '<option value="0">Chọn Phường, Xã</option>\n';
                }
            });
        }

        if (districtSelect) {
            $(districtSelect).on("select2:select", async (e) => {
                const districtId = e.params.data.id;
                if (districtId > 0) {
                    const endpoint = isEditMode
                        ? `../district/${districtId}`
                        : `./district/${districtId}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === "success") {
                        let option = '<option value="0">Chọn Phường, Xã</option>\n';
                        let {wards} = data;
                        if (wards.length) {
                            wards.forEach(({id, _name}) => {
                                option += `<option value="${id}">${_name}</option>\n`;
                            });
                        }
                        wardSelect.innerHTML = option;
                    }
                } else {
                    wardSelect.innerHTML =
                        '<option value="0">Chọn Phường, Xã</option>\n';
                }
            });
        }
    });

</script>
