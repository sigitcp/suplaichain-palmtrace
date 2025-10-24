@extends('layouts.master')
@section('container')

<div class="conatiner-fluid content-inner py-3">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <button class="btn btn-sm btn-success d-flex align-items-center"
                                title="Tambah Admin"
                                data-bs-toggle="modal"
                                data-bs-target="#userAddModal">

                                <span class="btn-inner d-flex align-items-center">
                                    <svg class="icon-20 me-2" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.87651 15.2063C6.03251 15.2063 2.74951 15.7873 2.74951 18.1153C2.74951 20.4433 6.01251 21.0453 9.87651 21.0453C13.7215 21.0453 17.0035 20.4633 17.0035 18.1363C17.0035 15.8093 13.7415 15.2063 9.87651 15.2063Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.8766 11.886C12.3996 11.886 14.4446 9.841 14.4446 7.318C14.4446 4.795 12.3996 2.75 9.8766 2.75C7.3546 2.75 5.3096 4.795 5.3096 7.318C5.3006 9.832 7.3306 11.877 9.8456 11.886H9.8766Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M19.2036 8.66919V12.6792" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M21.2497 10.6741H17.1597" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    Tambah User Sistem
                                </span>
                            </button>

                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Status Verified</th>
                                        <th style="min-width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">
                                            @if($user->foto)
                                            <img class="bg-primary-subtle rounded img-fluid avatar-40 me-3"
                                                src="{{ asset('storage/' . $user->foto) }}" alt="profile">
                                            @else
                                            <img class="bg-primary-subtle rounded img-fluid avatar-40 me-3"
                                                src="./assets/images/avatars/01.png" alt="profile">
                                            @endif
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td><span class="badge bg-primary">{{ $user->role->name }}</span></td>
                                        <td>
                                            @if($user->verified)
                                            <span class="badge bg-success">Verified</span>
                                            @else
                                            <span class="badge bg-danger">Non Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex align-items-center list-user-action">
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-icon btn-warning"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                    Edit
                                                </button>

                                                <!-- Tombol Delete -->
                                                @if(Auth::id() !== $user->id)
            <button class="btn btn-sm btn-icon btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#userDeleteValidationModal{{ $user->id }}">
                Delete
            </button>
        @endif
                                            </div>
                                        </td>
                                    </tr>

                                    @include('admin.user.modal.edit', ['user' => $user, 'roles' => $roles])

                                    @include('admin.user.modal.delete', ['user' => $user])

                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.user.modal.create')


@endsection