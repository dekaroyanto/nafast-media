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
                                data-gajipokok="{{ $k->jabatan->gajipokok }}">
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
                    <label for="jumlah_hadir" class="form-label">Jumlah Hadir</label>
                    <input type="text" id="jumlah_hadir" name="jumlah_hadir" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_izin" class="form-label">Jumlah Izin</label>
                    <input type="text" id="jumlah_izin" name="jumlah_izin" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_sakit" class="form-label">Jumlah Sakit</label>
                    <input type="text" id="jumlah_sakit" name="jumlah_sakit" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_wfh" class="form-label">Jumlah WFH</label>
                    <input type="text" id="jumlah_wfh" name="jumlah_wfh" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah_alfa" class="form-label">Jumlah Alfa</label>
                    <input type="text" id="jumlah_alfa" name="jumlah_alfa" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="number" id="bonus" name="bonus" class="form-control" value="0">
                </div>
                <div class="mb-3">
                    <label for="potongan" class="form-label">Potongan</label>
                    <input type="number" id="potongan" name="potongan" class="form-control" value="0">
                </div>
                <div class="mb-3">
                    <label for="total_gaji" class="form-label">Total Gaji</label>
                    <input type="text" id="total_gaji" name="total_gaji" class="form-control" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk mengisi data otomatis saat user memilih nama karyawan
        document.getElementById('user_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const jabatan = selectedOption.getAttribute('data-jabatan');
            const gajiPokok = parseInt(selectedOption.getAttribute('data-gajipokok')) || 0;
            const userId = this.value;
            const tanggalGaji = document.getElementById('tanggal_gaji').value;

            // Isi input jabatan dan gaji pokok
            document.getElementById('jabatan').value = jabatan || '';
            document.getElementById('gaji_pokok').value = gajiPokok;
            calculateTotalGaji();

            // Jika tanggal gaji terisi, ambil jumlah presensi menggunakan AJAX
            if (tanggalGaji) {
                fetchJumlahPresensi(userId, tanggalGaji);
            }
        });

        // Fungsi untuk mengisi jumlah presensi saat tanggal gaji diubah
        document.getElementById('tanggal_gaji').addEventListener('change', function() {
            const userId = document.getElementById('user_id').value;
            if (userId) {
                fetchJumlahPresensi(userId, this.value);
            }
        });

        // Fungsi AJAX untuk mengambil jumlah presensi
        function fetchJumlahPresensi(userId, tanggalGaji) {
            const [year, month] = tanggalGaji.split('-');
            fetch(`/jumlah-presensi/${userId}/${year}/${month}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah_hadir').value = data.jumlah_hadir || 0;
                    document.getElementById('jumlah_izin').value = data.jumlah_izin || 0;
                    document.getElementById('jumlah_sakit').value = data.jumlah_sakit || 0;
                    document.getElementById('jumlah_wfh').value = data.jumlah_wfh || 0;
                    document.getElementById('jumlah_alfa').value = data.jumlah_alfa || 0;
                })
                .catch(error => console.error('Error fetching jumlah presensi:', error));
        }

        // Fungsi untuk menghitung total gaji
        function calculateTotalGaji() {
            const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
            const bonus = parseInt(document.getElementById('bonus').value) || 0;
            const potongan = parseInt(document.getElementById('potongan').value) || 0;
            const totalGaji = (gajiPokok + bonus) - potongan;
            document.getElementById('total_gaji').value = totalGaji;
        }

        // Hitung ulang total gaji saat bonus atau potongan diubah
        document.getElementById('bonus').addEventListener('input', calculateTotalGaji);
        document.getElementById('potongan').addEventListener('input', calculateTotalGaji);
    </script>
@endsection
