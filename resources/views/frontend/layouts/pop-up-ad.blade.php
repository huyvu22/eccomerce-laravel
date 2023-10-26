<!--==========================
    POP UP START
===========================-->
<div class="pop-up-ad">

</div>

<!--==========================
POP UP END
===========================-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popUpElement = document.querySelector('.pop-up-ad');
        let html =
            ` <section id="wsus__pop_up">
                    <div class="wsus__pop_up_center">
                        <div class="wsus__pop_up_text">
                            <span id="cross"><i class="fas fa-times"></i></span>
                            <h5> Để nhận ưu đãi tới <span>25%</span></h5>
                            <h2>Đăng ký ngay hôm nay</h2>
                            <p>Hãy đăng ký <b>Shop Now </b>để không bỏ lỡ các chương trình khuyến mại.</p>
                            <form action="{{route('newsletter')}}" method="post" class="form_subscribe">
                                        @csrf
            <input type="email" placeholder="Email..." class="news_input">
            <button type="button" class="common_btn subscribe1">Đăng ký</button>
            <div class="wsus__pop_up_check_box">
            </div>
        </form>
        <div>
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11">
            <label for="flexCheckDefault11">
                <span>Không hiển thị lại</span>
            </label>
        </div>
    </div>
</div>
</section>`;

        setTimeout(() => {
            popUpElement.innerHTML = html;
            const inputCheckObj = document.querySelector('.form-check-input');
            const closeButtonObj = document.getElementById('cross');
            if (closeButtonObj) {
                closeButtonObj.addEventListener('click', () => {
                    popUpElement.style.display = 'none';
                })
            }

            inputCheckObj.addEventListener('change', (e) => {
                if (e.target.checked === true) {
                    sessionStorage.setItem('notShowPopup', 'true');
                } else {
                    sessionStorage.removeItem('notShowPopup');
                }
            });


            //Handle subscription
            const subscription = document.querySelector('.subscribe1');
            if (subscription) {

                subscription.addEventListener('click', async (e) => {
                    console.log(subscription)
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
        }, 5000)


        if (!sessionStorage.getItem('notShowPopup')) {
            popUpElement.style.display = 'block';
        } else {
            popUpElement.style.display = 'none';
        }


    });
</script>

