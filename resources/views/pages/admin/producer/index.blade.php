@extends('layouts.default')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col">
            <a href="{{ route('producer-manager-create') }}" class="btn btn-primary">
                Thêm hãng <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="col">
            <form class="d-flex justify-content-end">
                @csrf @method('GET')
                <div class="form-outline">
                    <input type="text" id="search" class="form-control" name="search" />
                    <label class="form-label" for="search">Tìm kiếm</label>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã hãng</th>
                <th scope="col">Tên hãng</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($producers); $i++)
                <tr>
                    <td scope="row">{{ $i+1 }}</td>
                    <td>{{ $producers[$i]->code }}</td>
                    <td>{{ $producers[$i]->name }}</td>
                    <td>
                        <a href="{{ route('producer-manager-show', $producers[$i]->id) }}" class="btn btn-primary btn-sm px-3">
                            <i class="fas fa-pen-fancy"></i>
                        </a>
                        <a href="{{ route('producer-manager-delete', $producers[$i]->id) }}" class="btn btn-danger btn-sm px-3">
                            <i class="fas fa-times"></i>
                        </a>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
@stop
