@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h5>Hadir</h5>
                            <span class="badge badge-primary">{{ \Carbon\Carbon::parse($currentDate)->format('j F Y') }}</span>
                        </div>
                        <h3><span class="counter">{{ $jumlahHadir }}</span></h3>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <p class="mb-0">Total Persentase</p>
                            <span class="text-primary">{{ $jumlahHadir > 0 ? ($jumlahHadir / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}%</span>
                        </div>
                        <div class="iq-progress-bar bg-primary-light mt-2">
                            <span class="bg-primary iq-progress progress-1" data-percent="{{ $jumlahHadir > 0 ? ($jumlahHadir / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}"></span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Sakit</h5>
                        <span class="badge badge-warning">{{ \Carbon\Carbon::parse($currentDate)->format('j F Y') }}</span>
                    </div>
                    <h3><span class="counter">{{ $jumlahSakit }}</span></h3>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="mb-0">Total Persentase</p>
                        <span class="text-warning">{{ $jumlahSakit > 0 ? ($jumlahSakit / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}%</span>
                    </div>
                    <div class="iq-progress-bar bg-warning-light mt-2">
                        <span class="bg-warning iq-progress progress-1" data-percent="{{ $jumlahSakit > 0 ? ($jumlahSakit / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-block card-stretch card-height">
                <div class="card-body">
                    <div class="top-block d-flex align-items-center justify-content-between">
                        <h5>Izin</h5>
                        <span class="badge badge-danger">{{ \Carbon\Carbon::parse($currentDate)->format('j F Y') }}</span>
                    </div>
                    <h3><span class="counter">{{ $jumlahIzin }}</span></h3>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <p class="mb-0">Total Persentase</p>
                        <span class="text-danger">{{ $jumlahIzin > 0 ? ($jumlahIzin / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}%</span>
                    </div>
                    <div class="iq-progress-bar bg-danger-light mt-2">
                        <span class="bg-danger iq-progress progress-1" data-percent="{{ $jumlahIzin > 0 ? ($jumlahIzin / ($jumlahHadir + $jumlahIzin + $jumlahSakit)) * 100 : '0' }}"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // toastr berhasil start
        @if(Session('login'))
        toastr.success('{{ session('login') }}');
        @endif
        // toastr berhasil end

        //toastr gagal start
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}');
        @endforeach
        @endif
        // toastr gagal end
    })
</script>
@endpush

