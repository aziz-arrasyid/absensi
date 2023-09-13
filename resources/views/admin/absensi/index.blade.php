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
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Absensi as $absensi)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('j F Y') }}</td>
                                <td>{{ $absensi->waktu }}</td>
                                <td>
                                    <div class="btn-group btn-group-toggle btn-group-flat">
                                        <a class="button btn button-icon bg-warning editData" href="#" data-id="{{ $absensi->id }}" data-toggle="modal" data-target="#modal-edit-data">Edit</a>
                                        <a class="button btn button-icon bg-info lihatData" href="#" data-id="{{ $absensi->id }}" data-toggle="modal" data-target="#modal-lihat-data">Lihat</a>
                                        <a class="button btn button-icon bg-danger deleteData" data-id="{{ $absensi->id }}" href="#">Delete</a>
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
                            <form id="absensi-form" enctype="multipart/form-data" action="{{ route('data-absensi.store') }}" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label>Waktu Absensi :</label>
                                        <select class="form-control mb-3" name="waktu">
                                            <option selected disabled>Silahkan dipilih</option>
                                            <option value="Pagi">Pagi</option>
                                            <option value="Siang">Siang</option>
                                            <option value="Sore">Sore</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal Absensi :</label>
                                        <input type="date" name="tanggal" class="form-control" id="tanggal">
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
            <form id="absensi-form-edit" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Waktu Absensi :</label>
                        <select class="form-control mb-3" name="waktu" id="waktu_absensi-edit">
                            <option selected disabled>Silahkan dipilih</option>
                            <option value="Pagi">Pagi</option>
                            <option value="Siang">Siang</option>
                            <option value="Sore">Sore</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Absensi :</label>
                        <input type="date" name="tanggal" class="form-control" id="tanggal_absensi-edit">
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

<div class="modal fade modal-lihat-data" tabindex="-1" id="modal-lihat-data" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $editData }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <p>List<code> pegawai</code> yang melakukan absensi.</p>
                    <div class="table-responsive rounded bg-white">
                        <table class="table mb-0 table-borderless tbl-server-info" id="lihat-absen">
                            <thead>
                                <tr class="ligth">
                                    <th scope="col">No</th>
                                    <th scope="col">nama</th>
                                    <th scope="col">longitude</th>
                                    <th scope="col">latitude</th>
                                    <th scope="col">jam absensi</th>
                                    <th scope="col">status kehadiran</th>
                                    <th scope="col" class="text-center">foto</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // deklarasi variable global start
        let data_absensi = null;
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
                    const data_absensi = $(this).data('id');
                    axios.delete(`/dashboard-admin/data-absensi/${data_absensi}`)
                    .then(() => {
                        Swal.fire(
                        'Terhapus!',
                        'Data nya berhasil dihapus!',
                        'success'
                        ).then(() => {
                            window.location.href = '{{ route('data-absensi.index') }}';
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
            data_absensi = $(this).data('id');

            // fungsi pengambilan data dan ditampilkan start
            axios.get(`/dashboard-admin/data-absensi/${data_absensi}/edit`)
            .then(response => {
                $('#tanggal_absensi-edit').val(response.data.tanggal);

                $('#waktu_absensi-edit').find('option').each(function() {
                    if($(this).val() == response.data.waktu)
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

        //fungsi lihat start
        $('.lihatData').on('click', function() {
            id = $(this).data('id');

            // fungsi pengambilan data dan ditampilkan start
            axios.get(`/dashboard-admin/lihat-absen/${id}`)
            .then(response => {
                const absensiData = response.data;

                const table = document.getElementById('lihat-absen').getElementsByTagName('tbody')[0];

                table.innerHTML = '';

                absensiData.forEach((data, index) => {
                    const row = table.insertRow(index);
                    const cellNo = row.insertCell(0);
                    const cellNama = row.insertCell(1);
                    const cellLongitude = row.insertCell(2);
                    const cellLatitude = row.insertCell(3);
                    const cellJamAbsensi = row.insertCell(4);
                    const cellStatus = row.insertCell(5);
                    const cellFoto = row.insertCell(6);

                    cellNo.innerHTML = index + 1;
                    cellNama.innerHTML = data.pegawai.namaLengkap;
                    cellLongitude.innerHTML = data.longitude;
                    cellLatitude.innerHTML = data.latitude;

                    // Buat elemen gambar <img> untuk menampilkan foto
                    const imgElement = document.createElement('img');
                    imgElement.src = "{{ asset('storage/photos/') }}" + "/" + data.photo;
                    imgElement.alt = "Foto Absensi";
                    imgElement.className = 'img-fluid';

                    // Tambahkan elemen gambar ke sel yang sesuai dalam tabel
                    // Misalnya, jika Anda ingin menampilkan foto di sel ke-6 (cellFoto), Anda dapat menggantinya seperti ini:
                    cellFoto.appendChild(imgElement);

                    // Dropdown untuk status
                    const statusSelect = document.createElement('select');
                    statusSelect.className = 'form-control';
                    statusSelect.innerHTML = `
                        <option selected disabled>silahkan dipilih</option>
                        <option value="hadir" ${data.status === 'hadir' ? 'selected' : ''}>Hadir</option>
                        <option value="izin" ${data.status === 'izin' ? 'selected' : ''}>Izin</option>
                        <option value="sakit" ${data.status === 'sakit' ? 'selected' : ''}>Sakit</option>
                    `;
                    statusSelect.addEventListener('change', function() {
                        // Ketika status berubah, kirim permintaan pembaruan ke server
                        const selectedStatus = statusSelect.value;
                        const data_absen = data.id;
                        axios.put(`/dashboard-admin/data-absen/${data_absen}`, { status: selectedStatus })
                            .then(response => {
                                console.log('Status data berhasil diperbarui:', response.data);
                            })
                            .catch(error => {
                                console.error('Error updating status: ', error);
                            });
                    });
                    cellStatus.appendChild(statusSelect);

                    const formattedTime = new Date(data.created_at);
                    const options = { timeZone: 'Asia/Jakarta', hour12: false, hour: '2-digit', minute: '2-digit' };
                    const formattedTimeString = formattedTime.toLocaleTimeString('id-ID', options);
                    cellJamAbsensi.innerHTML = formattedTimeString + ' WIB';
                })
            })
            .catch(error => {
                console.error('error fetching data: ', error)
            })
            // fungsi pengambilan data dan ditampilkan end

        })
        //fungsi lihat end

        //fungsi ketika form edit di submit start
        document.getElementById('absensi-form-edit').addEventListener('submit', function(event) {
            event.preventDefault();

            const modal = $('#modal-edit-data');
            const formData = new FormData(this);
            axios.post(`/dashboard-admin/data-absensi/${data_absensi}`, formData)
            .then(response => {
                modal.modal('hide');
                swal.fire('Data berhasil di edit', '', 'success').then(() => {
                    window.location.href = '{{ route('data-absensi.index') }}';
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
