<div>
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h4 class="footer-heading"><b>{{ $appSetting->website_name ?? 'website name' }}</b></h4>
                    <div class="footer-underline"></div>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                    </p>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading"><b>Truy Cập</b></h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Trang Chủ</a></div>
                    <div class="mb-2"><a href="" class="text-white">Về Chúng Tôi</a></div>
                    <div class="mb-2"><a href="" class="text-white">Liên Hệ</a></div>
                    <div class="mb-2"><a href="" class="text-white">Blogs</a></div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading"><b>Mua Sắm Ngay</b></h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{ url('/collections') }}" class="text-white">Bộ Sưu Tập</a></div>
                    <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Trending</a></div>
                    <div class="mb-2"><a href="{{ url('/new-arrivals') }}" class="text-white">Sản Phẩm Mới</a></div>
                    <div class="mb-2"><a href="{{ url('/featured-products') }}" class="text-white">Sản Phẩm Nổi Bật</a></div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading"><b>Địa Chỉ</b></h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2">
                        <a href="https://maps.app.goo.gl/uZChCFC54PgRz8J16" class="text-white">
                            <p>
                                <i class="fa fa-map-marker"></i> 
                                {{ $appSetting->address ?? 'address' }}
                            </p>
                        </a>

                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <i class="fa fa-phone"></i> {{ $appSetting->phone1 ?? 'phone 1' }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <i class="fa fa-envelope"></i> {{ $appSetting->email1 ?? 'email 1' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class=""> &copy; 2022 - EZ Ecommerce. All rights reserved.</p>
                </div>
                <div class="col-md-4">
                    <div class="social-media">
                        Get Connected:
                        
                        <a href="{{ $appSetting->facebook ?? '' }}" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="{{ $appSetting->twitter ?? '' }}" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="{{ $appSetting->instagram ?? '' }}" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="{{ $appSetting->youtube ?? '' }}" target="_blank"><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>