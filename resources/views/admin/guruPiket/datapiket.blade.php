@extends('layout.masterFile')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <section class="content mt-4">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="border-radius: 10px;">

                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        @if (session('username') == 'Guru Piket')
                                            <h2 class="m-0">Data Guru Piket</h2>
                                        @else
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="fa fa-plus"></i> Tambah Data
                                            </a>
                                        @endif
                                    </div>

                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table id="example2"
                                                class="table table-striped table-hover table-bordered text-center"
                                                style="border-radius: 8px; font-size: 0.9rem;">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        <th style="width: 50px;">No</th>
                                                        <th style="width: 150px;">Nama Guru</th>
                                                        <th style="width: 100px;">Hari Piket</th>
                                                        @if (session('username') != 'Guru Piket')
                                                            <th style="width: 100px;">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                                                        $sortedData = $indexdatapiket->sortBy(function($item) use ($urutanHari) {
                                                            return array_search($item->hari_piket, $urutanHari);
                                                        });
                                                    @endphp
                                                    @foreach ($sortedData as $index)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $index->nama_guru }}</td>
                                                            <td>{{ $index->hari_piket }}</td>
                                                            @if (session('username') != 'Guru Piket')
                                                                <td>
                                                                    <a href="#"
                                                                        onclick="event.preventDefault();
                                                                        Swal.fire({
                                                                            title: 'Yakin ingin hapus?',
                                                                            text: 'Data ini tidak bisa dikembalikan!',
                                                                            icon: 'warning',
                                                                            showCancelButton: true,
                                                                            confirmButtonColor: '#3085d6',
                                                                            cancelButtonColor: '#d33',
                                                                            confirmButtonText: 'Hapus',
                                                                            cancelButtonText: 'Batal'
                                                                        }).then((result) => {
                                                                            if (result.isConfirmed) {
                                                                                window.location.href = '{{ route('datapiket.hapus', $index->hari_piket) }}';
                                                                            }
                                                                        });"
                                                                        class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="{{ session('username') == 'Guru Piket' ? 3 : 4 }}">
                                                            Total Guru: {{ $totaldatapiket }}
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="d-flex justify-content-center">
                                            {{ $indexdatapiket->links('layout.paginate') }}
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
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="dataForm" action="{{ route('datapiket.add') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <textarea name="nama_guru" class="form-control" id="nama_guru"
                            placeholder="Masukkan nama guru piket (pisahkan dengan koma)..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hari_piket">Hari Piket</label>
                        <input type="text" name="hari_piket" class="form-control" list="haripiket" id="hari_piket"
                            placeholder="hari piket..." required>
                        <div class="invalid-feedback">
                            Mohon masukkan hari piket yang valid.
                        </div>
                    </div>

                    <datalist id="haripiket">
                        <option value="Senin"></option>
                        <option value="Selasa"></option>
                        <option value="Rabu"></option>
                        <option value="Kamis"></option>
                        <option value="Jumat"></option>
                    </datalist>

                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const validDays = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
    const hariPiketInput = document.getElementById('hari_piket');
    const submitBtn = document.getElementById('submitBtn');

    hariPiketInput.addEventListener('input', function() {
        const inputValue = hariPiketInput.value.toLowerCase();
        if (validDays.includes(inputValue)) {
            submitBtn.disabled = false;
            hariPiketInput.classList.remove('is-invalid');
        } else {
            submitBtn.disabled = true;
            hariPiketInput.classList.add('is-invalid');
        }
    });

    (function() {
        'use strict';
        var forms = document.querySelectorAll('form');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity() || submitBtn.disabled) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>


@if (session('edit_modal_id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = new bootstrap.Modal(document.getElementById('Edit_Siswa'));
            editModal.show();
        });
    </script>
@endif

<div class="modal fade" id="Edit_Siswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit datapiket</h5>
            </div>
            @if ($editdatapiket)
                <form action="{{ route('datapiket.update', $editdatapiket->hari_piket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_guru">Nama Guru</label>
                            <div id="guruContainer">
                                @foreach (explode(',', $editdatapiket->nama_guru) as $guru)
                                    <div class="guru-input mb-2">
                                        <input type="text" name="nama_guru[]" class="form-control"
                                            value="{{ trim($guru) }}" placeholder="Masukkan nama guru piket..."
                                            required>
                                        <a href="javascript:void(0);"
                                            class="btn btn-danger btn-sm mt-1 remove-guru-button"
                                            data-hari-piket="{{ $editdatapiket->hari_piket }}">Hapus</a>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" id="addGuruButton">Tambah Nama
                                Guru</button>
                        </div>
                        <div class="form-group">
                            <label for="hari_piket">Hari Piket</label>
                            <input type="text" name="hari_piket" class="form-control" list="haripiket"
                                id="hari_piket" placeholder="Hari piket..." value="{{ $editdatapiket->hari_piket }}"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('datapiket.index') }}" type="button" class="btn btn-secondary">Close</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            @else
                <p>Data not found!</p>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('addGuruButton').addEventListener('click', function() {
        const guruContainer = document.getElementById('guruContainer');
        const newGuruDiv = document.createElement('div');
        newGuruDiv.className = 'guru-input mb-2';

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.name = 'nama_guru[]';
        newInput.className = 'form-control';
        newInput.placeholder = 'Masukkan nama guru piket...';
        newInput.required = true;

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm mt-1 remove-guru-button';
        removeButton.textContent = 'Hapus';

        removeButton.addEventListener('click', function() {
            guruContainer.removeChild(newGuruDiv);
        });

        newGuruDiv.appendChild(newInput);
        newGuruDiv.appendChild(removeButton);
        guruContainer.appendChild(newGuruDiv);
    });

    document.querySelectorAll('.remove-guru-button').forEach(button => {
        button.addEventListener('click', function() {
            const guruInputDiv = this.parentElement;

            const hariPiket = this.getAttribute('data-hari-piket');

            fetch(`{{ url('/sipensi/dashboard/data-guru-piket/hapus') }}/${hariPiket}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    guruInputDiv.remove();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

@endsection
