@extends('layouts.template')

@section('title', 'Edit Gaji Karyawan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Gaji Karyawan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('gaji.update', $gajiKaryawan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal_gaji" class="form-label">Tanggal Gaji</label>
                    <input type="date" id="tanggal_gaji" name="tanggal_gaji" class="form-control"
                        value="{{ $gajiKaryawan->tanggal_gaji }}" required>
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Karyawan</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach ($karyawan as $k)
                            <option value="{{ $k->id }}" data-jabatan="{{ $k->jabatan->nama_jabatan }}"
                                data-gajipokok="{{ $k->jabatan->gajipokok }}"
                                {{ $k->id == $gajiKaryawan->user_id ? 'selected' : '' }}>
                                {{ $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" id="jabatan" class="form-control"
                        value="{{ $gajiKaryawan->user->jabatan->nama_jabatan }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_hari_kerja" class="form-label">Jumlah Hari Kerja</label>
                    <input type="number" id="jumlah_hari_kerja" name="jumlah_hari_kerja" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_hari_kerja }}" required>
                </div>
                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control"
                        value="{{ $gajiKaryawan->gaji_pokok }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="gaji_per_hari" class="form-label">Gaji Per Hari</label>
                    <input type="text" id="gaji_per_hari" name="gaji_per_hari" class="form-control"
                        value="{{ $gajiKaryawan->gaji_per_hari }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_hadir" class="form-label">Jumlah Hadir</label>
                    <input type="number" id="jumlah_hadir" name="jumlah_hadir" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_hadir }}">
                </div>
                <div class="mb-3">
                    <label for="jumlah_izin" class="form-label">Jumlah Izin</label>
                    <input type="number" id="jumlah_izin" name="jumlah_izin" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_izin }}">
                </div>
                <div class="mb-3">
                    <label for="jumlah_sakit" class="form-label">Jumlah Sakit</label>
                    <input type="number" id="jumlah_sakit" name="jumlah_sakit" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_sakit }}">
                </div>
                <div class="mb-3">
                    <label for="jumlah_wfh" class="form-label">Jumlah WFH</label>
                    <input type="number" id="jumlah_wfh" name="jumlah_wfh" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_wfh }}">
                </div>
                <div class="mb-3">
                    <label for="jumlah_alfa" class="form-label">Jumlah Alfa</label>
                    <input type="number" id="jumlah_alfa" name="jumlah_alfa" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_alfa }}">
                </div>
                <div class="mb-3">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="number" id="bonus" name="bonus" class="form-control"
                        value="{{ $gajiKaryawan->bonus }}">
                </div>
                <div class="mb-3">
                    <label for="potongan" class="form-label">Potongan</label>
                    <input type="number" id="potongan" name="potongan" class="form-control"
                        value="{{ $gajiKaryawan->potongan }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="total_gaji" class="form-label">Total Gaji</label>
                    <input type="text" id="total_gaji" name="total_gaji" class="form-control"
                        value="{{ $gajiKaryawan->total_gaji }}" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const jabatan = selectedOption.getAttribute('data-jabatan');
            const gajiPokok = parseInt(selectedOption.getAttribute('data-gajipokok')) || 0;
            document.getElementById('jabatan').value = jabatan || '';
            document.getElementById('gaji_pokok').value = gajiPokok;

            calculateGajiPerHari();
        });

        document.getElementById('jumlah_hadir').addEventListener('input', calculateTotalGaji);
        document.getElementById('jumlah_izin').addEventListener('input', calculateTotalGaji);
        document.getElementById('jumlah_sakit').addEventListener('input', calculateTotalGaji);
        document.getElementById('jumlah_wfh').addEventListener('input', calculateTotalGaji);
        document.getElementById('jumlah_alfa').addEventListener('input', calculateTotalGaji);
        document.getElementById('jumlah_hari_kerja').addEventListener('input', calculateGajiPerHari);
        document.getElementById('bonus').addEventListener('input', calculateTotalGaji);

        function calculateGajiPerHari() {
            const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
            const jumlahHariKerja = parseInt(document.getElementById('jumlah_hari_kerja').value) || 1;
            const gajiPerHari = Math.ceil(gajiPokok / jumlahHariKerja); // Dibulatkan ke atas
            document.getElementById('gaji_per_hari').value = gajiPerHari;
            calculateTotalGaji();
        }

        function calculateTotalGaji() {
            const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
            const jumlahHariKerja = parseInt(document.getElementById('jumlah_hari_kerja').value) || 1;
            const gajiPerHari = Math.ceil(gajiPokok / jumlahHariKerja); // Dibulatkan ke atas

            const jumlahIzin = parseInt(document.getElementById('jumlah_izin').value) || 0;
            const jumlahSakit = parseInt(document.getElementById('jumlah_sakit').value) || 0;
            const jumlahWfh = parseInt(document.getElementById('jumlah_wfh').value) || 0;
            const jumlahAlfa = parseInt(document.getElementById('jumlah_alfa').value) || 0;

            const potongan = Math.ceil((jumlahIzin + jumlahSakit + jumlahWfh + jumlahAlfa) *
            gajiPerHari); // Dibulatkan ke atas

            const bonus = parseInt(document.getElementById('bonus').value) || 0;

            const totalGaji = gajiPokok + bonus - potongan;

            document.getElementById('potongan').value = potongan;
            document.getElementById('total_gaji').value = totalGaji;
        }
    </script>
@endsection
