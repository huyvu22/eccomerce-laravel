<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('home')}}">ShopNow</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="dropdown {{setActive(['admin.dashboard'])}}">
                <a href="{{route('admin.dashboard')}}"><i class="fas fa-fire"></i><span>Dashboard</span></a>

            </li>
            <li class="menu-header">Ecommerce</li>

            <li class="dropdown {{setActive([
               'admin.category.*',
               'admin.sub-category.*',
               'admin.child-category.*'
            ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-list"></i> <span>Manage Category</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.category.*'])}}"><a class="nav-link" href="{{route('admin.category.index')}}">Category</a></li>
                    <li class="{{setActive(['admin.sub-category.*'])}}"><a class="nav-link" href="{{route('admin.sub-category.index')}}">Sub Category</a></li>
                    <li class="{{setActive(['admin.child-category.*'])}}"><a class="nav-link" href="{{route('admin.child-category.index')}}">Child Category</a></li>
                </ul>
            </li>

            <li class="dropdown {{setActive(['admin.brand.*','admin.products.*','admin.products-image-gallery.*','admin.products-variant.*','admin.products-variant-item.*','admin.seller-products.*','admin.seller-pending-products.*','admin.review.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-gift"></i> <span>Manage Product</span></a>
                <ul class="dropdown-menu">
                    @can('brand.view')
                        <li class="{{setActive(['admin.brand.*'])}}"><a class="nav-link" href="{{route('admin.brand.index')}}">Brands</a></li>
                    @endcan
                    <li class="{{setActive(['admin.products.*','admin.products-image-gallery.*','admin.products-variant.*','admin.products-variant-item.*'])}}"><a class="nav-link"
                                                                                                                                                                   href="{{route('admin.products.index')}}">Products</a>
                    </li>
                    <li class="{{setActive(['admin.seller-products.*'])}}"><a class="nav-link" href="{{route('admin.seller-products.index')}}">Seller Products</a></li>
                    <li class="{{setActive(['admin.seller-pending-products.*'])}}"><a class="nav-link" href="{{route('admin.seller-pending-products.index')}}">Seller Pending
                            Products</a></li>
                    <li class="{{setActive(['admin.review.*'])}}"><a class="nav-link" href="{{route('admin.review.index')}}">Product Reviews</a></li>
                </ul>
            </li>

            <li class="dropdown {{setActive([
               'admin.order.*',
                'admin.pending-orders',
                'admin.processed-orders',
                'admin.drop-off-orders',
                'admin.shipped-orders',
                'admin.out-of-delivery-orders',
                'admin.delivered-orders',
                'admin.canceled-orders'
            ])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cart-plus"></i> <span>Orders</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.order.*'])}}"><a class="nav-link" href="{{route('admin.order.index')}}">All Orders</a></li>
                    <li class="{{setActive(['admin.pending-orders'])}}"><a class="nav-link" href="{{route('admin.pending-orders')}}">Pending Orders</a></li>
                    <li class="{{setActive(['admin.processed-orders'])}}"><a class="nav-link" href="{{route('admin.processed-orders')}}">Processed Orders</a></li>
                    <li class="{{setActive(['admin.drop-off-orders'])}}"><a class="nav-link" href="{{route('admin.drop-off-orders')}}">Drop off Orders</a></li>
                    <li class="{{setActive(['admin.shipped-orders'])}}"><a class="nav-link" href="{{route('admin.shipped-orders')}}">Shipped Orders</a></li>
                    <li class="{{setActive(['admin.out-of-delivery-orders'])}}"><a class="nav-link" href="{{route('admin.out-of-delivery-orders')}}">Out of delivery Orders</a></li>
                    <li class="{{setActive(['admin.delivered-orders'])}}"><a class="nav-link" href="{{route('admin.delivered-orders')}}">Delivered Orders</a></li>
                    <li class="{{setActive(['admin.canceled-orders'])}}"><a class="nav-link" href="{{route('admin.canceled-orders')}}">Canceled Orders</a></li>
                </ul>
            </li>

            <li class="{{setActive(['admin.transaction.*'])}}"><a class="nav-link" href="{{route('admin.transaction.index')}}"><i class="fas fa-money-bill"></i> Transactions</a>
            </li>


            <li class="dropdown {{setActive(['ad-profile.*','admin.flash-sale.*','admin.coupon.*','admin.shipping-rule.*','admin.payment-settings.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-bag"></i> <span>Ecommerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.vendor-profile.*'])}}"><a class="nav-link" href="{{route('admin.vendor-profile.index')}}">Vendor Profile</a></li>
                    <li class="{{setActive(['admin.flash-sale.*'])}}"><a class="nav-link" href="{{route('admin.flash-sale.index')}}">Flash Sale</a></li>
                    <li class="{{setActive(['admin.shipping-rule.*'])}}"><a class="nav-link" href="{{route('admin.shipping-rule.index')}}">Shopping Rule</a></li>
                    <li class="{{setActive(['admin.coupon.*'])}}"><a class="nav-link" href="{{route('admin.coupon.index')}}">Coupon</a></li>
                    <li class="{{setActive(['admin.payment-settings.*'])}}"><a class="nav-link" href="{{route('admin.payment-settings.index')}}">Payment Settings</a></li>
                </ul>
            </li>

            <li class="dropdown {{setActive(['admin.slider.*','admin.homepage.*','admin.vendor-condition.*','admin.about.*','admin.terms-and-condition.*','admin.advertisement.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Manage Website</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.slider.*'])}}"><a class="nav-link" href="{{route('admin.slider.index')}}">Slider</a></li>
                    <li class="{{setActive(['admin.homepage.*'])}}"><a class="nav-link" href="{{route('admin.homepage.index')}}">HomePage Settings</a></li>
                    <li class="{{setActive(['admin.vendor-condition.*'])}}"><a class="nav-link" href="{{route('admin.vendor-condition.index')}}">Vendor Condition</a></li>
                    <li class="{{setActive(['admin.advertisement.*'])}}"><a class="nav-link" href="{{route('admin.advertisement.index')}}">Advertisement</a></li>
                    <li class="{{setActive(['admin.about.*'])}}"><a class="nav-link" href="{{route('admin.about.index')}}">About Us</a></li>
                    <li class="{{setActive(['admin.terms-and-condition.*'])}}"><a class="nav-link" href="{{route('admin.terms-and-condition.index')}}">Terms and conditions</a></li>
                </ul>
            </li>

            <li class="menu-header">Settings & More</li>

            <li class="dropdown {{setActive(['admin.footer-info.*','admin.footer-socials.*','admin.footer-column-2.*','admin.footer-column-3.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i> <span>Footer</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.footer-info.*'])}}"><a class="nav-link" href="{{route('admin.footer-info.index')}}">Footer info</a></li>
                    <li class="{{setActive(['admin.footer-socials.*'])}}"><a class="nav-link" href="{{route('admin.footer-socials.index')}}">Footer Socials</a></li>
                    <li class="{{setActive(['admin.footer-column-2.*'])}}"><a class="nav-link" href="{{ route('admin.footer-column-2.index')}}">Footer Column 2</a></li>
                    <li class="{{setActive(['admin.footer-column-3.*'])}}"><a class="nav-link" href="{{route('admin.footer-column-3.index')}}">Footer Column 3</a></li>
                </ul>
            </li>

            <li class="dropdown {{setActive(['admin.become-request.*','admin.customers.*','admin.vendors.*','admin.manage-user.*','admin.admin-list.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Users and Vendors</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.customers.*'])}}"><a class="nav-link" href="{{route('admin.customers.index')}}">Customer List</a></li>
                    <li class="{{setActive(['admin.vendors.*'])}}"><a class="nav-link" href="{{route('admin.vendors.index')}}">Vendor List</a></li>
                    <li class="{{setActive(['admin.become-request.*'])}}"><a class="nav-link" href="{{route('admin.become-request.index')}}">Pending vendors</a></li>
                    <li class="{{setActive(['admin.manage-user.*'])}}"><a class="nav-link" href="{{route('admin.manage-user.index')}}">Manage User</a></li>
                    <li class="{{setActive(['admin.admin-list.*'])}}"><a class="nav-link" href="{{route('admin.admin-list.index')}}">Manage Admin</a></li>

                </ul>
            </li>

            <li class="dropdown {{setActive(['admin.blog-category.*','admin.blog.*','admin.blog-comments.*'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fab fa-blogger-b"></i> <span>Manage Blog</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.blog-category.*'])}}"><a class="nav-link" href="{{route('admin.blog-category.index')}}">Categories</a></li>
                    @can('blog.view')
                        <li class="{{setActive(['admin.blog.*'])}}"><a class="nav-link" href="{{route('admin.blog.index')}}">Blog</a></li>
                    @endcan
                    <li class="{{setActive(['admin.blog-comments.*'])}}"><a class="nav-link" href="{{route('admin.blog-comments.index')}}">Comments</a></li>
                </ul>
            </li>
            <li class="{{setActive(['admin.subscriber.*'])}}"><a class="nav-link" href="{{route('admin.subscriber.index')}}"><i class="fas fa-user"></i> Subscribers</a></li>
            <li class="{{setActive(['admin.setting.*'])}}"><a class="nav-link" href="{{route('admin.setting.index')}}"><i class="fas fa-cog"></i> Settings</a></li>

            {{--            @can('groups')--}}
            <li class="menu-header">Role & Permission</li>

            <li class="dropdown {{setActive(['admin.permission*','admin.role.*','admin.modules.*','admin.add-role-permission','admin.update-role-permission'])}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i> <span>Role & Permission</span></a>
                <ul class="dropdown-menu">
                    <li class="{{setActive(['admin.modules.*'])}}"><a class="nav-link" href="{{route('admin.modules.index')}}">Modules Permission</a></li>
                    <li class="{{setActive(['admin.permission.*'])}}"><a class="nav-link" href="{{route('admin.permission.index')}}">Permissions</a></li>
                    <li class="{{setActive(['admin.role.*','admin.add-role-permission','admin.update-role-permission'])}}"><a class="nav-link" href="{{route('admin.role.index')}}">User
                            Roles and Permission</a></li>
                </ul>
            </li>
            {{--            @endcan--}}

        </ul>

    </aside>
</div>
