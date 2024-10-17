@extends('layout.masterFile')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile</h1>
                    </div>
                    <section class="content mt-4">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="py-4 container-fluid">
                                        <div class="mt-3 row">
                                            <div class="mt-4 col-12 col-md-6 col-xl-4 mt-md-0">
                                                <div class="card h-100">
                                                    <div class="p-3 pb-0 card-header">
                                                        <div class="row">
                                                            <div class="col-md-8 d-flex align-items-center">
                                                                <h6 class="mb-0">Profile User</h6>
                                                            </div>
                                                            <div class="col-md-4 text-end"><a href="javascript:;"
                                                                    data-toggle="modal" data-target="#exampleModal"><i
                                                                        class="text-sm fas fa-user-edit text-secondary"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="" data-bs-original-title="Edit Profile"
                                                                        aria-label="Edit Profile"
                                                                        aria-hidden="true"></i></a></div>
                                                        </div>
                                                    </div>
                                                    <div class="p-3 card-body">
                                                        @if (session('username') == 'Kesiswaan')
                                                            @if ($datapengguna->contains('username', 'Kesiswaan'))
                                                                @foreach ($datapengguna as $pengguna)
                                                                    @if ($pengguna->username == 'Kesiswaan')
                                                                        <ul class="list-group">
                                                                            <li
                                                                                class="pt-0 text-sm border-0 list-group-item ps-0">
                                                                                <strong class="text-dark">Role:</strong>
                                                                                &nbsp; {{ $pengguna->username }}
                                                                            </li>
                                                                            <li
                                                                                class="text-sm border-0 list-group-item ps-0">
                                                                                <strong class="text-dark">
                                                                                    Pengguna:</strong> &nbsp;
                                                                                {{ $pengguna->nama_pengguna ? $pengguna->nama_pengguna : '-' }}
                                                                            </li>
                                                                            <li
                                                                                class="text-sm border-0 list-group-item ps-0">
                                                                                <strong class="text-dark">Password:</strong>
                                                                                &nbsp; {{ $pengguna->password }}
                                                                            </li>
                                                                        </ul>

                                                                        <div class="modal fade" id="exampleModal"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalLabel">Edit
                                                                                            User Kesiswaan</h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form
                                                                                            action="{{ route('edit.penggunaInti', $pengguna->id) }}"
                                                                                            method="POST">
                                                                                            @csrf
                                                                                            <div class="input-group mb-3">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon1"><i
                                                                                                            class="fa-solid fa-user"></i></span>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="Role"
                                                                                                    aria-label="Username"
                                                                                                    aria-describedby="basic-addon1"
                                                                                                    name="username"
                                                                                                    value="{{ $pengguna->username }}"
                                                                                                    readonly>
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="Nama Pengguna"
                                                                                                    aria-label="Recipient's username"
                                                                                                    aria-describedby="basic-addon2"
                                                                                                    name="nama_pengguna"
                                                                                                    value="{{ $pengguna->nama_pengguna ? $pengguna->nama_pengguna : '-' }}">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon2"><i
                                                                                                            class="fa-solid fa-user"></i></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon1"><i
                                                                                                            class="fa-solid fa-lock"></i></span>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="password"
                                                                                                    aria-label="Username"
                                                                                                    name="password"
                                                                                                    value="{{ $pengguna->password }}"
                                                                                                    aria-describedby="basic-addon1">
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <button type="submit"
                                                                                                    class="btn btn-primary">Simpan</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @elseif (session('username') == 'Kepala Sekolah')
                                                            @if ($datapengguna->contains('username', 'Kepala Sekolah'))
                                                                @foreach ($datapengguna as $pengguna)
                                                                    @if ($pengguna->username == 'Kepala Sekolah')
                                                                        <ul class="list-group">
                                                                            <li
                                                                                class="pt-0 text-sm border-0 list-group-item ps-0">
                                                                                <strong class="text-dark">Role:</strong>
                                                                                &nbsp; {{ $pengguna->username }}
                                                                            </li>
                                                                            <li
                                                                                class="text-sm border-0 list-group-item ps-0">
                                                                                <strong class="text-dark">
                                                                                    Pengguna:</strong> &nbsp;
                                                                                {{ $pengguna->nama_pengguna ? $pengguna->nama_pengguna : '-' }}
                                                                            </li>
                                                                            <li
                                                                                class="text-sm border-0 list-group-item ps-0">
                                                                                <strong
                                                                                    class="text-dark">Password:</strong>
                                                                                &nbsp; {{ $pengguna->password }}
                                                                            </li>
                                                                        </ul>

                                                                        <div class="modal fade" id="exampleModal"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-labelledby="exampleModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalLabel">Edit
                                                                                            User Kesiswaan</h5>
                                                                                        <button type="button"
                                                                                            class="close"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form
                                                                                            action="{{ route('edit.penggunaInti', $pengguna->id) }}"
                                                                                            method="POST">
                                                                                            @csrf
                                                                                            <div class="input-group mb-3">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon1"><i
                                                                                                            class="fa-solid fa-user"></i></span>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="Role"
                                                                                                    aria-label="Username"
                                                                                                    aria-describedby="basic-addon1"
                                                                                                    name="username"
                                                                                                    value="{{ $pengguna->username }}"
                                                                                                    readonly>
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="Nama Pengguna"
                                                                                                    aria-label="Recipient's username"
                                                                                                    aria-describedby="basic-addon2"
                                                                                                    name="nama_pengguna"
                                                                                                    value="{{ $pengguna->nama_pengguna ? $pengguna->nama_pengguna : '-' }}">
                                                                                                <div
                                                                                                    class="input-group-append">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon2"><i
                                                                                                            class="fa-solid fa-user"></i></span>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <span
                                                                                                        class="input-group-text"
                                                                                                        id="basic-addon1"><i
                                                                                                            class="fa-solid fa-lock"></i></span>
                                                                                                </div>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="password"
                                                                                                    aria-label="Username"
                                                                                                    name="password"
                                                                                                    value="{{ $pengguna->password }}"
                                                                                                    aria-describedby="basic-addon1">
                                                                                            </div>
                                                                                            <div class="input-group mb-3">
                                                                                                <button type="submit"
                                                                                                    class="btn btn-primary">Simpan</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 col-12 col-xl-8 mt-xl-0 mr-xl-0" style="width: 100%;">
                                                <div class="card h-100">
                                                    <div class="p-3 pb-0 card-header">
                                                        <h6 class="mb-0">Data Pengguna</h6>
                                                    </div>
                                                    <div class="p-3 card-body"
                                                        style="overflow-y: scroll; height : 25rem;">
                                                        <table class="table text-center">
                                                            <thead>
                                                                @php
                                                                    $no = 1;
                                                                @endphp
                                                                <tr>
                                                                    <th scope="col">No</th>
                                                                    <th scope="col">Role</th>
                                                                    <th scope="col">Nama Pengguna</th>
                                                                    <th scope="col">Password</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (session('username') == 'Kesiswaan')
                                                                    @foreach ($datapengguna as $index)
                                                                        @if ($index->username != 'Kesiswaan')
                                                                            @if ($index->username != 'Kepala Sekolah')
                                                                                <tr>
                                                                                    <th scope="row">{{ $no++ }}
                                                                                    </th>
                                                                                    <td>{{ $index->username }}</td>
                                                                                    <td>{{ $index->nama_pengguna ? $index->nama_pengguna : '-' }}
                                                                                    </td>
                                                                                    <td id="password-td">
                                                                                        <span class="password-display">
                                                                                            {{ $index->password }}
                                                                                        </span>

                                                                                        <span class="password-form"
                                                                                            style="display:none;">
                                                                                            <form
                                                                                                action="{{ route('password.update', $index->id) }}"
                                                                                                method="POST">
                                                                                                @csrf
                                                                                                <div class="input-group">
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="password"
                                                                                                        value="{{ $index->password }}"
                                                                                                        aria-label="Password">
                                                                                                    <button
                                                                                                        class="btn btn-success btn-border"
                                                                                                        type="submit">Ubah</button>
                                                                                                </div>
                                                                                            </form>
                                                                                        </span>
                                                                                        @if ($index->username != 'Wali Kelas')
                                                                                            <span>
                                                                                                <a href="javascript:void(0)"
                                                                                                    onclick="toggleInput(this)">
                                                                                                    <i class="fa-solid fa-pen"
                                                                                                        style="font-size: 0.8rem;"></i>
                                                                                                </a>
                                                                                            </span>
                                                                                        @endif
                                                                                    </td>

                                                                                    <script>
                                                                                        function toggleInput(element) {
                                                                                            var tdElement = element.closest('td');

                                                                                            var passwordDisplay = tdElement.querySelector('.password-display');
                                                                                            var passwordForm = tdElement.querySelector('.password-form');
                                                                                            if (passwordForm.style.display === 'none') {
                                                                                                passwordDisplay.style.display = 'none';
                                                                                                passwordForm.style.display = 'inline';
                                                                                            } else {
                                                                                                passwordDisplay.style.display = 'inline';
                                                                                                passwordForm.style.display = 'none';
                                                                                            }
                                                                                        }
                                                                                    </script>
                                                                                </tr>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($datapengguna as $index)
                                                                        @if ($index->username != 'Kepala Sekolah')
                                                                            <tr>
                                                                                <th scope="row">{{ $no++ }}
                                                                                </th>
                                                                                <td>{{ $index->username }}</td>
                                                                                <td>{{ $index->nama_pengguna ? $index->nama_pengguna : '-' }}
                                                                                </td>
                                                                                <td id="password-td">
                                                                                    <span class="password-display">
                                                                                        {{ $index->password }}
                                                                                    </span>

                                                                                    <span class="password-form"
                                                                                        style="display:none;">
                                                                                        <form action="#"
                                                                                            method="POST">
                                                                                            <div class="input-group">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name="password"
                                                                                                    value="{{ $index->password }}"
                                                                                                    aria-label="Password">
                                                                                                <button
                                                                                                    class="btn btn-black btn-border"
                                                                                                    type="submit">Ubah</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </span>

                                                                                    <span>
                                                                                        <a href="javascript:void(0)"
                                                                                            onclick="toggleInput(this)">
                                                                                            <i class="fa-solid fa-pen"
                                                                                                style="font-size: 0.8rem;"></i>
                                                                                        </a>
                                                                                    </span>
                                                                                </td>

                                                                                <script>
                                                                                    function toggleInput(element) {
                                                                                        // Mendapatkan elemen parent <td>
                                                                                        var tdElement = element.closest('td');

                                                                                        // Mendapatkan elemen yang menampilkan password dan form
                                                                                        var passwordDisplay = tdElement.querySelector('.password-display');
                                                                                        var passwordForm = tdElement.querySelector('.password-form');

                                                                                        // Toggle antara menampilkan password dan form
                                                                                        if (passwordForm.style.display === 'none') {
                                                                                            passwordDisplay.style.display = 'none';
                                                                                            passwordForm.style.display = 'inline';
                                                                                        } else {
                                                                                            passwordDisplay.style.display = 'inline';
                                                                                            passwordForm.style.display = 'none';
                                                                                        }
                                                                                    }
                                                                                </script>


                                                                                <td>
                                                                                    <a href="#"
                                                                                        class="btn btn-danger d-flex align-items-center justify-content-center"
                                                                                        style="height: 2rem; width: 2rem;">
                                                                                        <i class="fa-solid fa-trash"
                                                                                            style="font-size: 0.8rem;"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>
        </div>
        </section>
    </div>
@endsection
