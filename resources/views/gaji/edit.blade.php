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
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_gaji" class="form-label">Tanggal Gaji</label>
                            <input type="date" id="tanggal_gaji" name="tanggal_gaji" class="form-control"
                                value="{{ $gajiKaryawan->tanggal_gaji }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama Karyawan</label>
                            <select id="user_id" name="user_id" class="form-control" reaadonly>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}" data-jabatan="{{ $k->jabatan->nama_jabatan }}"
                                        data-gajipokok="{{ $k->jabatan->gajipokok }}"
                                        data-tunjangan-transport="{{ $k->jabatan->tunjangan_transportasi }}"
                                        data-tunjangan-makan="{{ $k->jabatan->tunjangan_makan }}"
                                        data-tunjangan-kesehatan="{{ $k->jabatan->tunjangan_kesehatan }}"
                                        {{ $gajiKaryawan->user_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tunjangan_transport" class="form-label">Tunjangan Transportasi Per Hari</label>
                            <input type="text" id="tunjangan_transport" name="tunjangan_transport" class="form-control"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tunjangan_makan" class="form-label">Tunjangan Makan Per Hari</label>
                            <input type="text" id="tunjangan_makan" name="tunjangan_makan" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tunjangan_kesehatan" class="form-label">Tunjangan Kesehatan</label>
                            <input type="text" id="tunjangan_kesehatan" name="tunjangan_kesehatan" class="form-control"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_hari_kerja" class="form-label">Jumlah Hari Kerja</label>
                            <input type="number" id="jumlah_hari_kerja" name="jumlah_hari_kerja" class="form-control"
                                value="{{ $gajiKaryawan->jumlah_hari_kerja }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_hadir" class="form-label">Jumlah Hadir</label>
                            <input type="number" id="jumlah_hadir" name="jumlah_hadir" class="form-control"
                                value="{{ $gajiKaryawan->jumlah_hadir }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah_izin" class="form-label">Jumlah Izin</label>
                            <input type="number" id="jumlah_izin" name="jumlah_izin" class="form-control" readonly
                                value="{{ $gajiKaryawan->jumlah_izin }}">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_sakit" class="form-label">Jumlah Sakit</label>
                            <input type="number" id="jumlah_sakit" name="jumlah_sakit" class="form-control" readonly
                                value="{{ $gajiKaryawan->jumlah_sakit }}">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_wfh" class="form-label">Jumlah WFH</label>
                            <input type="number" id="jumlah_wfh" name="jumlah_wfh" class="form-control" readonly
                                value="{{ $gajiKaryawan->jumlah_wfh }}">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_alfa" class="form-label">Jumlah Alfa</label>
                            <input type="number" id="jumlah_alfa" name="jumlah_alfa" class="form-control" readonly
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
                                value="{{ $gajiKaryawan->potongan }}">
                        </div>
                        <div class="mb-3">
                            <label for="total_gaji" class="form-label">Total Gaji</label>
                            <input type="text" id="total_gaji" name="total_gaji" class="form-control" readonly
                                value="{{ $gajiKaryawan->total_gaji }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectedOption = document.querySelector(`#user_id option[value="{{ $gajiKaryawan->user_id }}"]`);
            updateFormData(selectedOption);
            calculateAll();
        });

        document.getElementById('user_id').addEventListener('change', (e) => {
            updateFormData(e.target.selectedOptions[0]);
            calculateAll();
        });

        document.getElementById('tanggal_gaji').addEventListener('change', calculateAll);
        document.getElementById('jumlah_hadir').addEventListener('input', calculateAll);
        document.getElementById('jumlah_hari_kerja').addEventListener('input', calculateAll);
        document.getElementById('bonus').addEventListener('input', calculateAll);
        document.getElementById('potongan').addEventListener('input', calculateAll);

        function updateFormData(selectedOption) {
            if (selectedOption) {
                document.getElementById('jabatan').value = selectedOption.getAttribute('data-jabatan') || '';
                document.getElementById('gaji_pokok').value = selectedOption.getAttribute('data-gajipokok') || 0;
                document.getElementById('tunjangan_transport').value = selectedOption.getAttribute(
                    'data-tunjangan-transport') || 0;
                document.getElementById('tunjangan_makan').value = selectedOption.getAttribute('data-tunjangan-makan') || 0;
                document.getElementById('tunjangan_kesehatan').value = selectedOption.getAttribute(
                    'data-tunjangan-kesehatan') || 0;
            }
        }

        function calculateAll() {
            const gajiPokok = parseFloat(document.getElementById('gaji_pokok').value) || 0;
            const jumlahHariKerja = parseInt(document.getElementById('jumlah_hari_kerja').value) || 1;
            const jumlahHadir = parseInt(document.getElementById('jumlah_hadir').value) || 0;
            const tunjanganTransport = parseFloat(document.getElementById('tunjangan_transport').value) || 0;
            const tunjanganMakan = parseFloat(document.getElementById('tunjangan_makan').value) || 0;
            const tunjanganKesehatan = parseFloat(document.getElementById('tunjangan_kesehatan').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;
            const potongan = parseFloat(document.getElementById('potongan').value) || 0;

            const gajiPerHari = Math.ceil(gajiPokok / jumlahHariKerja);
            const gajiPerHariDidapat = gajiPerHari * jumlahHadir;
            const tunjanganTransportDidapat = tunjanganTransport * jumlahHadir;
            const tunjanganMakanDidapat = tunjanganMakan * jumlahHadir;

            const totalGaji = gajiPerHariDidapat + bonus + tunjanganTransportDidapat + tunjanganMakanDidapat +
                tunjanganKesehatan - potongan;

            document.getElementById('total_gaji').value = totalGaji;
        }
    </script>
@endsection
