<script>
    window.addEventListener("DOMContentLoaded", (event) => {

        const variantSelects = document.querySelectorAll('.attribute');
        const productPrice = document.querySelector('span.product_price');
        const productOldPrice = document.querySelector('del.old_product_price');
        const countCart = document.querySelector('.cart-count');
        const inputPrice = document.querySelector('input.input_price');

        const formatPrice = (price)=>{
            return  parseInt(price).toLocaleString('en').replace(/,/g, '.')+'₫' ;
        }

        if (inputPrice) {
            const inputValuePrice = document.querySelector('.input_price').value;
            const [currentPrice, oldPrice] = inputValuePrice.split(" ");
            if (variantSelects.length > 0) {
                let variantItemPrices = Array.from({ length: variantSelects.length }, () => 0);

                variantSelects.forEach((variantSelect, index) => {
                    $(variantSelect).on('select2:select', (e) => {
                        variantItemPrices[index] = parseInt(e.params.data.title);

                        let totalVariantItemPrice = variantItemPrices.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
                        productPrice.innerText = (totalVariantItemPrice + parseInt(currentPrice)).toLocaleString('en').replace(/,/g, '.') + '₫';
                        productOldPrice.innerText = (totalVariantItemPrice + parseInt(oldPrice)).toLocaleString('en').replace(/,/g, '.') + '₫';
                    });
                });
            }
        }


        // Show Products in Sidebar
        const sidebarProducts = document.querySelector('.mini-cart-wrapper');
        const fetchSideBarProducts = async (e) => {
            let li = '';
            try {
                const response = await fetch("/cart-products");
                if (response.ok) {
                    const data = await response.json();
                    let { cartProducts } = data;
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
        const getSubTotal = async ()=>{
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
        const getCartCount = async ()=>{
            try {
                const response = await fetch("/cart-count");
                if (response.ok) {
                    const data = await response.json();
                    countCart.innerText = data.count
                } else {
                    console.error("Error fetching cart count");
                }
            } catch (error) {
                console.error("An error occurred while fetching cart count:", error);
            }
        }


        //Add to Cart Button
        const addToCartBtns = document.querySelectorAll('.add_cart');
        if(addToCartBtns.length){
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
                            if(data.status === 'success'){
                                toastr.success(data.message);
                                await fetchSideBarProducts()
                                await getCartCount()
                                document.querySelector('.mini_cart_actions').classList.remove('d-none');
                            }else if(data.status ==='error'){
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

        const cartForm = document.querySelector('.shopping-cart-form');
        const buyNowButton = document.querySelector('.buy_now');

        buyNowButton.addEventListener('click', function () {
            let buyNowRoute = buyNowButton.getAttribute('data-buy-product-route');
            console.log(cartForm)
            cartForm.action = buyNowRoute;
            cartForm.method = 'get';
            cartForm.submit();
        });

        // Remove product from sidebar
        const miniCartWrapper = document.querySelector('.mini-cart-wrapper');
        const miniCartAction = document.querySelector('.mini_cart_actions');
        miniCartWrapper.addEventListener('click', async (e)=> {
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

        // Handle add product to wishlist
        const wishlists = document.querySelectorAll('.add_to_wishlist');
        if (wishlists.length) {
            wishlists.forEach(wishlist => {
                wishlist.addEventListener('click', async (e) => {
                    e.preventDefault();
                    let productId = e.currentTarget.dataset.id;
                    let route = e.currentTarget.dataset.route;
                    const response = await fetch(route);
                    // const response = await fetch(`/user/wishlist/add-product/${productId}`);
                    console.log(response)
                    if(response.url === 'http://ecommerce.test/login'){
                        return toastr.error('Bạn phải đăng nhập trước để có thể thêm sản phẩm vào yêu thích! <a href="/login" style="color: yellow; text-decoration: underline">Đăng nhập !</a>');
                    }

                    let data = await response.json();
                    if (data.status === 'success') {
                        toastr.success(data.message);
                        document.querySelector('.count_wishlist_item').innerHTML = data.count;
                    } else if (data.status === 'error') {
                        toastr.error(data.message);
                    }
                });
            });
        }


        //Handle subscription
        const subscription = document.querySelector('.subscribe');
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


    });

</script>
