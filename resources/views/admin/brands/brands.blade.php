@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brands</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Brands</div>
                    </li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success text-center text-xl mt-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value=""
                                    aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.add-brands') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('uploads/brands/' . $brand->image) }}" height="40">

                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $brand->name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.edit-brands', $brand->id) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>

                                                <!-- Open Delete Modal -->
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $brand->id }}"
                                                    class="item text-danger delete border-0 bg-transparent p-0" title="Delete">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                                <!-- Modal + Form -->
                                                <form action="{{ route('admin.delete-brands', $brand->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal fade" id="confirmModal-{{ $brand->id }}" tabindex="-1"
                                                        aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmModalLabel">Confirm
                                                                        Deletion</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body text-center">
                                                                    <i
                                                                        class="fas fa-exclamation-triangle warning-icon text-warning fs-2"></i>
                                                                    <p class="mb-0">Are you sure you want to delete this
                                                                        Brand?<br>This action cannot be undone.</p>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        <i class="fas fa-times me-2"></i>Cancel
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>





                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $brands->links('pagination::bootstrap-5') }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection