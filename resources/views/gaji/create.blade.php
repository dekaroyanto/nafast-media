@extends('layouts.template')

@section('title', 'Tambah Gaji Karyawan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Tambah Gaji Karyawan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('gaji.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_gaji" class="form-label">Tanggal Gaji</label>
                            <input type="date" id="tanggal_gaji" name="tanggal_gaji" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama Karyawan</label>
                            <select id="user_id" name="user_id" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}" data-jabatan="{{ $k->jabatan->nama_jabatan }}"
                                        data-gajipokok="{{ $k->jabatan->gajipokok }}"
                                        data-tunjangan-transport="{{ $k->jabatan->tunjangan_transportasi }}"
                                        data-tunjangan-makan="{{ $k->jabatan->tunjangan_makan }}"
                                        data-tunjangan-kesehatan="{{ $k->jabatan->tunjangan_kesehatan }}">
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
                                value="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah_hadir" class="form-label">Jumlah Hadir</label>
                            <input type="number" id="jumlah_hadir" name="jumlah_hadir" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="gaji_per_hari" class="form-label">Gaji Per Hari</label>
                            <input type="text" id="gaji_per_hari" name="gaji_per_hari" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bonus" class="form-label">Bonus</label>
                            <input type="number" id="bonus" name="bonus" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="potongan" class="form-label">Potongan</label>
                            <input type="number" id="potongan" name="potongan" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="total_gaji" class="form-label">Total Gaji</label>
                            <input type="text" id="total_gaji" name="total_gaji" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('user_id').addEventListener('change', fetchPresensi);
        document.getElementById('tanggal_gaji').addEventListener('change', fetchPresensi);
        document.getElementById('jumlah_hadir').addEventListener('input', calculateAll);
        document.getElementById('jumlah_hari_kerja').addEventListener('input', calculateAll);
        document.getElementById('bonus').addEventListener('input', calculateAll);

        function fetchPresensi() {
            const userId = document.getElementById('user_id').value;
            const tanggalGaji = document.getElementById('tanggal_gaji').value;

            if (userId && tanggalGaji) {
                const selectedOption = document.querySelector(`#user_id option[value="${userId}"]`);
                updateFormData(selectedOption);

                const [year, month] = tanggalGaji.split('-');
                fetch(`/jumlah-presensi/${userId}/${year}/${month}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('jumlah_hadir').value = data.jumlah_hadir || 0;
                        calculateAll();
                    })
                    .catch(error => console.error('Error fetching presensi:', error));
            }
        }

        function updateFormData(selectedOption) {
            if (selectedOption) {
                document.getElementById('jabatan').value = selectedOption.getAttribute('data-jabatan') || '';
                document.getElementById('gaji_pokok').value = selectedOption.getAttribute('data-gajipokok') || 0;
                document.getElementById('tunjangan_transport').value =
                    selectedOption.getAttribute('data-tunjangan-transport') || 0;
                document.getElementById('tunjangan_makan').value = selectedOption.getAttribute('data-tunjangan-makan') || 0;
                document.getElementById('tunjangan_kesehatan').value =
                    selectedOption.getAttribute('data-tunjangan-kesehatan') || 0;
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

            const gajiPerHari = Math.ceil(gajiPokok / jumlahHariKerja);
            const gajiPerHariDidapat = gajiPerHari * jumlahHadir;

            const tunjanganTransportDidapat = tunjanganTransport * jumlahHadir;
            const tunjanganMakanDidapat = tunjanganMakan * jumlahHadir;

            const totalGaji = gajiPerHariDidapat + bonus + tunjanganTransportDidapat + tunjanganMakanDidapat +
                tunjanganKesehatan;

            document.getElementById('gaji_per_hari').value = gajiPerHari;
            document.getElementById('potongan').value = 0; // Jika ada potongan logika di sini
            document.getElementById('total_gaji').value = totalGaji;
        }
    </script>
@endsection
