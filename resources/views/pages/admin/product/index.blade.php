@extends('layouts.default')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col">
                <a href="{{ route('product-manager-create') }}" class="btn btn-primary">
                    Thêm sản phẩm <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="col">
                <form class="d-flex justify-content-end">
                    @csrf @method('GET')
                    <div class="form-outline">
                        <input type="text" id="search" class="form-control" name="search" value="{{ request()->search }}" />
                        <label class="form-label" for="search">Tìm kiếm</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <table class="table table-hover table-striped align-middle">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Giá Sale</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($products); $i++)
                    <tr>
                        <td scope="row">{{ $i + 1 }}</td>
                        <td width="160px">
                            <img class="w-100 h-100" src="/{{ $products[$i]->image }}" alt="">
                        </td>
                        <td>{{ $products[$i]->name }}</td>
                        <td>{{ $products[$i]->description }}</td>
                        <td>{{ $products[$i]->price }}</td>
                        <td style="min-width: 100px;">{{ $products[$i]->price_sale }}</td>
                        <td width="140px">
                            <a href="{{ route('product-manager-show', $products[$i]->id) }}"
                                class="btn btn-primary btn-sm px-3">
                                <i class="fas fa-pen-fancy"></i>
                            </a>
                            <a href="{{ route('product-manager-delete', $products[$i]->id) }}"
                                class="btn btn-danger btn-sm px-3">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <nav aria-label="...">
                <ul class="pagination">
                    <?php
                        $search = request()->search ? request()->search : '';
                        $page = $products->currentPage();
                        $lastPage = $products->lastPage();

                        if ($page == $lastPage) {
                            $pageStart = $lastPage - 2;
                            $pageEnd = $lastPage;
                        } else if ($page == 1) {
                            $pageStart = 1;
                            $pageEnd = 3;
                        } else {
                            $pageStart = $page - 1;
                            $pageEnd = $page + 1;
                        }
                        if ($pageEnd > $lastPage) {
                            $pageEnd = $lastPage;
                        }
                        if ($pageStart < 1) {
                            $pageStart = 1;
                        }
                    ?>
                    <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ Request::url() . "?search=$search&page=1" }}">Đầu</a>
                    </li>
                    @for ($i = $pageStart; $i <= $pageEnd; $i++)
                        <li class="page-item {{ $page == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ Request::url() . "?search=$search&page=$i" }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $lastPage == $page ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ Request::url() . "?search=$search&page=$lastPage" }}">Cuối</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@stop
