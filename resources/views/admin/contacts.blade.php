@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Page Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3 class="page-title">All Messages</h3>
            <ul class="breadcrumbs flex items-center gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">All Messages</div></li>
            </ul>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <div class="wg-box">
            <!-- Search and Add -->
            <div class="flex items-center justify-between gap10 flex-wrap mb-3">
                <div class="wg-filter flex-grow">
                    <form class="form-search" method="GET" action="">
                        <fieldset class="name">
                            <input type="text" placeholder="Search by name or email..." name="search"
                                class="form-control" value="{{ request('search') }}">
                        </fieldset>
                        <div class="button-submit">
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <!-- Optional Add Button if you allow adding -->
                {{-- <a class="tf-button style-1 w208" href="#"><i class="icon-plus"></i> Add New Message</a> --}}
            </div>

            <!-- Table -->
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Comment</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->id }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td style="white-space: normal;">{{ Str::limit($contact->comment, 100) }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <!-- Trigger Delete Modal -->
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal-{{ $contact->id }}"
                                                class="item text-danger border-0 bg-transparent p-0" title="Delete">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <form action="{{ route('admin.contact-delete', $contact->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal fade" id="confirmModal-{{ $contact->id }}" tabindex="-1"
                                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmModalLabel">Delete Message</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <i class="fas fa-exclamation-triangle text-warning fs-2 mb-3"></i>
                                                            <p>Are you sure you want to delete this message from <strong>{{ $contact->name }}</strong>?<br>This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="divider my-4"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $contacts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
