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
                                <th>Bidang</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bidangs as $bidang)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $bidang->namaBidang }}</td>
                                <td>
                                    <div class="btn-group btn-group-toggle btn-group-flat">
                                        <a class="button btn button-icon bg-warning editData" href="#" data-id="{{ $bidang->id }}" data-toggle="modal" data-target="#modal-edit-data">Edit</a>
                                        <a class="button btn button-icon bg-danger deleteData" data-id="{{ $bidang->id }}" href="#">Delete</a>
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
                            <form id="bidang-form" enctype="multipart/form-data" action="{{ route('data-bidang.store') }}" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="namaBidang">Nama Bidang :</label>
                                        <input type="text" name="namaBidang" class="form-control" id="namaBidang">
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
            <form id="bidang-form-edit" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="namaBidang-edit">Nama Bidang :</label>
                        <input type="text" name="namaBidang" class="form-control" id="namaBidang-edit">
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
        let data_bidang = null;
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
                    const data_bidang = $(this).data('id');
                    axios.delete(`/dashboard-admin/data-bidang/${data_bidang}`)
                    .then(() => {
                        Swal.fire(
                        'Terhapus!',
                        'Data nya berhasil dihapus!',
                        'success'
                        ).then(() => {
                            window.location.href = '{{ route('data-bidang.index') }}';
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
            data_bidang = $(this).data('id');

            // fungsi pengambilan data dan ditampilkan start
            axios.get(`/dashboard-admin/data-bidang/${data_bidang}/edit`)
            .then(response => {
                $('#namaBidang-edit').val(response.data.namaBidang);
            })
            .catch(error => {
                console.error('error fetching data: ', error)
            })
            // fungsi pengambilan data dan ditampilkan end

        })
        //fungsi ketika btn edit di click end

        //fungsi ketika form edit di submit start
        document.getElementById('bidang-form-edit').addEventListener('submit', function(event) {
            event.preventDefault();

            const modal = $('#modal-edit-data');
            const formData = new FormData(this);
            axios.post(`/dashboard-admin/data-bidang/${data_bidang}`, formData)
            .then(response => {
                modal.modal('hide');
                swal.fire('Data berhasil di edit', '', 'success').then(() => {
                    window.location.href = '{{ route('data-bidang.index') }}';
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
