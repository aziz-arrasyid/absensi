@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ $dataTitle }}</h4>
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
                            @php
                            $noUrut = 1;
                            @endphp
                            @foreach ($Absensi as $absensi)
                            <tr>
                                <td>{{ $noUrut++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('j F Y') }}</td>
                                <td>{{ $absensi->waktu }}</td>
                                <td>
                                    <div class="btn-group btn-group-toggle btn-group-flat">
                                        @if ($Absen->contains('absensi_id', $absensi->id))
                                        <a class="button btn button-icon bg-success disabled absen"
                                        href="#" id="absen-button" data-id="{{ $absensi->id }}">
                                        Sudah Absen
                                    </a>
                                    @else
                                    <a class="button btn button-icon bg-danger absen-button"
                                    href="#" id="absen-button" data-id="{{ $absensi->id }}" data-target="#modal-absen-data">
                                    Absen
                                </a>
                                @endif
                            </a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="modal fade modal-add-data" tabindex="-1" role="dialog"  aria-hidden="true">
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
    </div> --}}
</div>
</div>
</div>
</div>

<div class="modal fade modal-absen-data" tabindex="-1" id="modal-absen-data" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $editData }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="absen-form" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <video id="camera" autoplay playsinline class="img-fluid"></video>
                                {{-- <img class="img-fluid" id="camera"> --}}
                                <canvas id="canvas" style="display: none;"></canvas>
                            </div>
                        </div>
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
        let data_absensi = null;
        let stream;
        const modal = $('#modal-absen-data');
        // deklarasi variable global end
        // const absenButtons = document.querySelectorAll('.absen-button');

        //fungsi camera start

        $('.absen-button').on('click', function() {
            data_absensi = $(this).data('id');

            const videoElement = document.getElementById('camera');
            if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                navigator.mediaDevices
                
                .getUserMedia({ video: true })
                .then(function (mediaStream) {
                    modal.modal('show');
                    stream = mediaStream;
                    videoElement.srcObject = mediaStream;
                })
                .catch(function (error) {
                    modal.modal('hide');
                    console.error('Gagal mengakses kamera:', error);
                    Swal.fire('Akses Kamera Ditolak', 'Anda harus mengizinkan akses kamera untuk melakukan absen.', 'error');
                });
            } else {
                console.error('Kamera tidak didukung di perangkat ini.');
            }

        })

        // Menambahkan event listener untuk tombol "Close" modal
        $('#modal-absen-data').on('hidden.bs.modal', function () {
            // Webcam.reset();
             if (stream) {
                stream.getTracks().forEach(function (track) {
                    track.stop(); // Menghentikan aliran media dari kamera
                });
            }
        });
        //fungsi camera end

        //fungsi submit absen start
        document.getElementById('absen-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const videoElement = document.getElementById('camera');
            const canvasElement = document.getElementById('canvas');
            const context = canvasElement.getContext('2d');

            canvasElement.width = 490; // Atur sesuai resolusi yang Anda inginkan
            canvasElement.height = 350;

            context.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
            // const imageDataURL = canvasElement.toDataURL('image/jpeg');
            canvasElement.toBlob(function(blob) {
                const formData = new FormData();


                if('geolocation' in navigator)
                {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        formData.append('latitude', latitude);
                        formData.append('longitude', longitude);
                        formData.append('absensi_id', data_absensi);
                        formData.append('photo', blob, 'webcam.jpg');

                        axios.post('{{ route('data-absen.store') }}', formData)
                        .then(() => {
                            modal.modal('hide');
                            Swal.fire('Berhasil', 'Berhasil mengisi absen', 'success').then(() => {
                                window.location.href = '{{ Route('data-absen.index') }}';
                            })
                        })
                        .catch(error => {
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
                                modal.modal('hide');
                                Swal.fire('gagal melakukan absensi', errorMessage, 'error');
                            }else{
                                modal.modal('hide');
                                Swal.fire('gagal melakukan absensi', 'Terjadi kesalahan pada sisi server, hubungi kami segera', 'error');
                            }
                            console.error(error);
                        })
                    }, function(error) {
                        if(error.code == error.PERMISSION_DENIED)
                        {
                            modal.modal('hide');
                            Swal.fire('Izin akses lokasi ditolak', 'Untuk melakukan absensi, aktifkan izin akses lokasi di pengaturan browser Anda.', 'error');
                        }else
                        {
                            modal.modal('hide');
                            Swal.fire('Gagal mendapatkan lokasi', 'Terjadi kesalahan saat mendapatkan lokasi Anda.', 'error');
                        }
                    });
                }else
                {
                    modal.modal('hide');
                    Swal.fire('Gagal mendapatkan lokasi', 'Browser Anda tidak mendukung Geolocation API', 'error');
                }
            }, 'image/jpeg');

            // Webcam.snap(function(data_uri) {

            // })

        })
        //fungsi submit absen end

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
