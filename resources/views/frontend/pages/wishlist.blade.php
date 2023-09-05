@extends('frontend.layouts.master')
@section('title')
    Shop Now - WishList
@endsection
@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>wishlist</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">wishlist</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wsus__cart_list wishlist">
                        <div class="table-responsive" style="overflow-x: hidden !important;">
                            <table>
                                <tbody>
                                <tr class="d-flex">
                                    <th class="wsus__pro_img">
                                        product item
                                    </th>

                                    <th class="wsus__pro_name" style="width: 487px !important;">
                                        product details
                                    </th>

                                    <th class="wsus__pro_status" style="width: 200px !important;">
                                        status
                                    </th>

                                    <th class="wsus__pro_tk"  style="width: 200px !important;">
                                        price
                                    </th>

                                    <th class="wsus__pro_icon">
                                        action
                                    </th>
                                </tr>
                                @foreach($wishlistProduct as $item)
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img"><img src="{{asset($item->product->thumb_image)}}" alt="product"
                                                                       class="img-fluid w-100">
                                            <a href="#" class="remove_wishlist_product" data-route="{{route('user.wishlist.destroy',$item->product_id)}}"><i class="far fa-times"></i></a>
                                        </td>

                                        <td class="wsus__pro_name" style="width: 487px !important;">
                                            <p>{{$item->product->name}}</p>
                                        </td>

                                        <td class="wsus__pro_status" style="width: 200px !important;">
                                            <p>{{checkInStock($item->product) ? 'In stock' : 'Out of stock'}}</p>
                                        </td>


                                        <td class="wsus__pro_tk" style="width: 200px !important;">
                                            <h6>{{format($item->product->price)}}</h6>
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <a class="common_btn" href="{{route('product-detail',$item->product->slug)}}">View Product</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CART VIEW PAGE END
    ==============================-->
@endsection



