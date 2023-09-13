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
                    <button type="button" class="btn btn-success mt-2 rekapAll">{{ $rekap }}</button>
                </div>
            </div>
            <div class="d-flex justify-content-around">
                <div class="form-group mt-2">
                    <label>Tahun</label>
                    <select class="form-control" id="selectTahun" name="tahun">
                        <option selected disabled>Open this select menu</option>
                        @foreach ($AbsensiTahun as $absensiTahun)
                        <option
                        value="{{ \Carbon\Carbon::parse($absensiTahun->tanggal)->format('Y') }}">
                        {{ \Carbon\Carbon::parse($absensiTahun->tanggal)->format('Y') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-2">
                <label>Bulan</label>
                <select class="form-control" id="selectBulan" name="bulan">
                    <option selected disabled>Open this select menu</option>
                    @foreach ($AbsensiBulan as $absensiBulan)
                    <option
                    value="{{ \Carbon\Carbon::parse($absensiBulan->tanggal)->format('F') }}">
                    {{ \Carbon\Carbon::parse($absensiBulan->tanggal)->format('F') }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive rounded bg-white">
            <table id="data-table" class="table data-table table-striped">
                <thead>
                    <tr class="light">
                        <th>No</th>
                        <th class="text-center">tanggal</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Absensi as $absensi)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('j F Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-toggle btn-group-flat">
                                <a class="button btn button-icon bg-info" data-id="{{ $absensi->id }}" href="{{ route('OnePDF', ['tanggal' => $absensi->tanggal]) }}">Rekap</a>
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
                        <h5 class="modal-title">{{ $rekap }}</h5>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#selectTahun, #selectBulan').change(function() {
            var tahun = $('#selectTahun').val();
            var bulan = $('#selectBulan').val();
            console.log(bulan, tahun);

            if(tahun !== null && bulan !== null)
            {
                axios.get('{{ route('filterData') }}', {
                    params: {
                        tahun: tahun,
                        bulan: bulan
                    }
                })
                .then(function(response) {
                    // Tangani respons yang diterima dari server
                    var data = response.data;

                    // Perbarui tabel dengan data yang diterima
                    var table = $('#data-table');
                    table.empty(); // Kosongkan isi tabel

                    // Tambahkan header tabel
                    var tableHeader = '<thead><tr><th>no</th><th>Tanggal</th></tr></thead>';
                    table.append(tableHeader);

                    // Tambahkan data ke dalam tabel
                    var tableBody = '<tbody>';

                    data.sort(function(a, b) {
                        // Sorting berdasarkan tanggal (pastikan data memiliki properti "tanggal")
                        return new Date(a.tanggal) - new Date(b.tanggal);
                    });

                    var prevDate = null;

                    data.forEach(function(item, index) {
                        const currentDate = new Date(item.tanggal);
                        // const date = new Date(item.tanggal);
                        if (!prevDate || currentDate.getTime() !== prevDate.getTime()) {
                            const options = { day: 'numeric', month: 'long', year: 'numeric' };
                            const tanggal = currentDate.toLocaleDateString('id-ID', options);
                            tableBody += '<tr><td>' + (index + 1) + '</td><td>' + tanggal + '</td>' +
                                '<td>' +
                                '<a class="button btn button-icon bg-info deleteData" data-id="' + item.id + '" href="{{ route('OnePDF', ['tanggal' => '+item.tanggal+']) }}">Rekap</a>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';
                        }
                        prevDate = currentDate;
                    });
                    tableBody += '</tbody>';
                    table.append(tableBody);
                })
                .catch(function(error) {
                    console.error(error);
                });
            }
        })

        $('.rekapAll').on('click', function() {
            let tahun = $('#selectTahun').val();
            let bulan = $('#selectBulan').val();

            window.location.href = `/dashboard-admin/OneMonthPDF/${tahun}/${bulan}`;

        })

        // toastr berhasil start
        @if(Session('error'))
        toastr.error('{{ session('error') }}');
        @endif
        // toastr berhasil end
    });
</script>
@endpush
