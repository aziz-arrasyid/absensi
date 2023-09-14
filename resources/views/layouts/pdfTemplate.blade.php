<!DOCTYPE html>
<html>
<head>
    <style>
        /* CSS untuk kop surat */
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo {
            /* flex: 1; */
            /* text-align: center; */
        }
        .company-name {
            /* flex: 2; */
            /* text-align: right; */
            text-align: center;
        }
        .clear {
            clear: both;
        }
        .address {
            text-align: center;
            margin-top: 10px;
        }
        .garis1{
            border-top:3px solid black;
            height: 2px;
            border-bottom:1px solid black;
        }
        table, td, th{
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        body{
            padding: 0;
            margin: 0;
        }
        .img{
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('/assets/images/pdf/kop.png') }}" class="img"/>
    </div>

    <p>Data absensi pada {{ $tanggal }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>no</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Bidang</th>
                <th>Seksi</th>
                <th>Status Kehadiran</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->pegawai->namaLengkap }}</td>
                <td>{{ $item->pegawai->jabatan->namaJabatan }}</td>
                <td>{{ $item->pegawai->bidang->namaBidang }}</td>
                <td>{{ $item->pegawai->seksi->namaSeksi }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->absensi->waktu }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Isi konten PDF di sini -->
</body>
</html>
