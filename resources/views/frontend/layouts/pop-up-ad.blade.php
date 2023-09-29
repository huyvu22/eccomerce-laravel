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
                            <h5> Để nhận ưu đãi <span>75% off</span></h5>
                            <h2>Đăng ký ngay hôm nay</h2>
                            <p>Subscribe to the <b>E-SHOP</b> market newsletter to receive updates on special offers.</p>
                            <form action="{{route('newsletter')}}" method="post" class="form_subscribe">
                                        @csrf
                                <input type="email" placeholder="Your Email" class="news_input">
                                <button type="submit" class="common_btn">Get code</button>
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
        setTimeout(()=>{
            popUpElement.innerHTML = html;
            const inputCheckObj = document.querySelector('.form-check-input');
            const closeButtonObj = document.getElementById('cross');
            if(closeButtonObj){
                closeButtonObj.addEventListener('click',()=>{
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
        },5000)



        if (!sessionStorage.getItem('notShowPopup')) {
            popUpElement.style.display = 'block';
        }else{
            popUpElement.style.display = 'none';
        }


    });
</script>

