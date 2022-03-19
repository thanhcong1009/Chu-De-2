<style>
    .carousel {
        height: 60vh;
    }

    .carousel .carousel-inner,
    .carousel .carousel-inner .carousel-item {
        height: 100%;
    }

    .carousel .carousel-inner .carousel-item .view {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        height: 100%;
        position: relative;
    }

    .carousel .carousel-inner .carousel-item img {
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .mask {
        background-color: rgba(0, 0, 0, 0.6);
        color: #edecec;
    }

    .mask>div {
        user-select: none;
    }
</style>

<div id="carouselExampleCrossfade" class="carousel slide carousel-fade" data-mdb-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-mdb-target="#carouselExampleCrossfade" data-mdb-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="view" style="background-image: url('./assets/image/banner1.png');">
                <!-- Mask & flexbox options-->
                <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

                    <!-- Content -->
                    <div class="text-center white-text mx-5 wow fadeIn">
                        <h1 class="mb-4">
                            <strong>Sự kiện giáng sinh</strong>
                        </h1>

                        <p>
                            <strong>Giảm giá 50% cho đơn hàng từ 300k</strong>
                        </p>

                        <p class="mb-4 d-none d-md-block">

                        </p>

                        <a target="_blank" href="#" class="btn btn-outline-white btn-lg">Xem ngay
                            <i class="fas fa-graduation-cap ml-2"></i>
                        </a>
                    </div>
                    <!-- Content -->

                </div>
                <!-- Mask & flexbox options-->
            </div>
        </div>
        <div class="carousel-item">
            <div class="view" style="background-image: url('./assets/image/banner2.png');">
                <!-- Mask & flexbox options-->
                <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

                    <!-- Content -->
                    <div class="text-center white-text mx-5 wow fadeIn">
                        <h1 class="mb-4">
                            <strong>Sự kiện Năm mới 2021</strong>
                        </h1>

                        <p>
                            <strong>Best sale</strong>
                        </p>

                        <p class="mb-4 d-none d-md-block">

                        </p>

                        <a target="_blank" href="#" class="btn btn-outline-white btn-lg">Xem ngay
                            <i class="fas fa-graduation-cap ml-2"></i>
                        </a>
                    </div>
                    <!-- Content -->

                </div>
                <!-- Mask & flexbox options-->
            </div>
        </div>
        <div class="carousel-item">
            <div class="view" style="background-image: url('./assets/image/banner3.jpeg');">
                <!-- Mask & flexbox options-->
                <div class="mask rgba-black-strong d-flex justify-content-center align-items-center">

                    <!-- Content -->
                    <div class="text-center white-text mx-5 wow fadeIn">
                        <h1 class="mb-4">
                            <strong>Sự kiện Black Friday</strong>
                        </h1>

                        <p>
                            <strong>Sự kiện giảm giá lớn nhất trong năm</strong>
                        </p>

                        <p class="mb-4 d-none d-md-block">

                        </p>

                        <a target="_blank" href="#" class="btn btn-outline-white btn-lg">Xem ngay
                            <i class="fas fa-graduation-cap ml-2"></i>
                        </a>
                    </div>
                    <!-- Content -->

                </div>
                <!-- Mask & flexbox options-->
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleCrossfade"
        data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleCrossfade"
        data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
