@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ $dataTitle }}</h4>
                </div>
                <div class="pl-3 btn-new border-left">
                    <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target=".modal-add-data">{{ $addData }}</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive rounded bg-white">
                    <table id="tableYearSemesters" class="table data-table table-striped">
                        <thead>
                            <tr class="light">
                                <th>No</th>
                                <th>NIP/NRHS</th>
                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Bidang</th>
                                <th>Seksi</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Pegawai as $pegawai)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $pegawai->regNumber }}</td>
                                <td>{{ $pegawai->namaLengkap }}</td>
                                <td>{{ $pegawai->jabatan->namaJabatan }}</td>
                                <td>{{ $pegawai->bidang->namaBidang }}</td>
                                <td>{{ $pegawai->seksi->namaSeksi }}</td>
                                <td>{{ $pegawai->alamat }}</td>
                                <td>
                                    <div class="btn-group btn-group-toggle btn-group-flat">
                                        <a class="button btn button-icon bg-warning editData" href="#" data-id="{{ $pegawai->id }}" data-toggle="modal" data-target="#modal-edit-data">Edit</a>
                                        <a class="button btn button-icon bg-danger deleteData" data-id="{{ $pegawai->id }}" href="#">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal fade modal-add-data" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $addData }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="pegawai-form" enctype="multipart/form-data" action="{{ route('data-pegawai.store') }}" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="regNumber">NIP/NRHS :</label>
                                        <input type="text" name="regNumber" class="form-control" id="regNumber">
                                    </div>
                                    <div class="form-group">
                                        <label for="namaLengkap">Nama Lengkap :</label>
                                        <input type="text" name="namaLengkap" class="form-control" id="namaLengkap">
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan :</label>
                                        <select class="form-control mb-3" name="jabatan_id" id="jabatan_id">
                                            <option selected disabled>Silahkan dipilih</option>
                                            @foreach ($Jabatan as $jabatan)
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->namaJabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>bidang :</label>
                                        <select class="form-control mb-3" name="bidang_id" id="bidang_id">
                                            <option selected disabled>Silahkan dipilih</option>
                                            @foreach ($Bidang as $bidang)
                                            <option value="{{ $bidang->id }}">{{ $bidang->namaBidang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Seksi :</label>
                                        <select class="form-control mb-3" name="seksi_id" id="seksi_id">
                                            <option selected disabled>Silahkan dipilih</option>
                                            @foreach ($Seksi as $seksi)
                                            <option value="{{ $seksi->id }}">{{ $seksi->namaSeksi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat :</label>
                                        <input type="text" name="alamat" class="form-control" id="alamat">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-edit-data" tabindex="-1" id="modal-edit-data" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $editData }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pegawai-form-edit" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="regNumber">NIP/NRHS :</label>
                        <input type="text" name="regNumber" class="form-control" id="regNumber-edit">
                    </div>
                    <div class="form-group">
                        <label for="namaLengkap">Nama Lengkap :</label>
                        <input type="text" name="namaLengkap" class="form-control" id="namaLengkap-edit">
                    </div>
                    <div class="form-group">
                        <label>Jabatan :</label>
                        <select class="form-control mb-3" name="jabatan_id" id="jabatan_id-edit">
                            @foreach ($Jabatan as $jabatan)
                            <option value="{{ $jabatan->id }}">{{ $jabatan->namaJabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bidang :</label>
                        <select class="form-control mb-3" name="bidang_id" id="bidang_id-edit">
                            @foreach ($Bidang as $bidang)
                            <option id="bidang-edit-option" value="{{ $bidang->id }}">{{ $bidang->namaBidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Seksi :</label>
                        <select class="form-control mb-3" name="seksi_id" id="seksi_id-edit">
                            @foreach ($Seksi as $seksi)
                            <option id="seksi-edit-option" value="{{ $seksi->id }}">{{ $seksi->namaSeksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat :</label>
                        <input type="text" name="alamat" class="form-control" id="alamat-edit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // deklarasi variable global start
        let data_pegawai = null;
        // deklarasi variable global end

        //fungsi delete
        $('.deleteData').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apa kamu ingin hapus data?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, saya mau hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const data_pegawai = $(this).data('id');
                    axios.delete(`/dashboard-admin/data-pegawai/${data_pegawai}`)
                    .then(() => {
                        Swal.fire(
                        'Terhapus!',
                        'Data nya berhasil dihapus!',
                        'success'
                        ).then(() => {
                            window.location.href = '{{ route('data-pegawai.index') }}';
                        })
                    })
                    .catch(() => {
                        Swal.fire('Gagal dihapus', 'Terjadi kesalahan pada sisi server, hubungi developer kami', 'error');
                    })
                }
            })
        });
        //fungsi delete end

        // fungsi edit start

        //fungsi ketika btn edit di click start
        $('.editData').on('click', function() {
            data_pegawai = $(this).data('id');

            // fungsi pengambilan data dan ditampilkan start
            axios.get(`/dashboard-admin/data-pegawai/${data_pegawai}/edit`)
            .then(response => {
                $('#regNumber-edit').val(response.data.regNumber);
                $('#namaLengkap-edit').val(response.data.namaLengkap);
                $('#alamat-edit').val(response.data.alamat);

                $('#jabatan_id-edit').find('option').each(function() {
                    if($(this).val() == response.data.jabatan_id)
                    {
                        $(this).prop('selected', true);
                    }
                });
                $('#bidang_id-edit').find('option').each(function() {
                    if($(this).val() == response.data.bidang_id)
                    {
                        $(this).prop('selected', true);
                    }
                });
                $('#seksi_id-edit').find('option').each(function() {
                    if($(this).val() == response.data.seksi_id)
                    {
                        $(this).prop('selected', true);
                    }
                });
            })
            .catch(error => {
                console.error('error fetching data: ', error)
            })
            // fungsi pengambilan data dan ditampilkan end

        })
        //fungsi ketika btn edit di click end

        //fungsi ketika form edit di submit start
        document.getElementById('pegawai-form-edit').addEventListener('submit', function(event) {
            event.preventDefault();

            const modal = $('#modal-edit-data');
            const formData = new FormData(this);
            axios.post(`/dashboard-admin/data-pegawai/${data_pegawai}`, formData)
            .then(response => {
                modal.modal('hide');
                swal.fire('Data berhasil di edit', '', 'success').then(() => {
                    window.location.href = '{{ route('data-pegawai.index') }}';
                })
            })
            .catch(error => {
                console.error('Error updating data: ', error);
                modal.modal('hide');
                if(error.response && error.response.status === 422){
                    const errorMessages = error.response.data.errors;
                    let errorMessage = '';

                    let isFirstError = true; // Flag to track the first error
                    for (const field in errorMessages) {
                        if (!isFirstError) {
                            errorMessage += ', '; // Add a comma before the error message
                        } else {
                            isFirstError = false;
                        }
                        errorMessage += errorMessages[field][0];
                    }
                    Swal.fire('Data gagal di edit', errorMessage, 'error').then(() => {
                        modal.modal('show');
                    });
                }else{
                    Swal.fire('Data gagal di edit', 'Terjadi kesalahan pada sisi server, hubungi kami segera', 'error');
                }
                console.error(error);
            });
        })
        //fungsi ketika form edit di submit end

        // fungsi edit end

        // toastr berhasil start
        @if(Session('success'))
        toastr.success('{{ session('success') }}');
        @endif
        // toastr berhasil end

        //toastr gagal start
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}');
        @endforeach
        @endif
        // toastr gagal end
    });
</script>
@endpush
