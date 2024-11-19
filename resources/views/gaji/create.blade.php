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
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control" readonly>
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
            const gajiPokok = selectedOption.getAttribute('data-gajipokok');
            const userId = this.value;
            const tanggalGaji = document.getElementById('tanggal_gaji').value;

            // Isi input jabatan dan gaji pokok
            document.getElementById('jabatan').value = jabatan || '';
            document.getElementById('gaji_pokok').value = gajiPokok || '';

            // Jika tanggal gaji terisi, ambil jumlah hadir menggunakan AJAX
            if (tanggalGaji) {
                fetchJumlahHadir(userId, tanggalGaji);
            }
        });

        // Fungsi untuk mengisi jumlah hadir saat tanggal gaji diubah
        document.getElementById('tanggal_gaji').addEventListener('change', function() {
            const userId = document.getElementById('user_id').value;
            if (userId) {
                fetchJumlahHadir(userId, this.value);
            }
        });

        // Fungsi AJAX untuk mengambil jumlah hadir
        function fetchJumlahHadir(userId, tanggalGaji) {
            const [year, month] = tanggalGaji.split('-');
            fetch(`/jumlah-hadir/${userId}/${year}/${month}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('jumlah_hadir').value = data.jumlah_hadir || 0;
                })
                .catch(error => console.error('Error fetching jumlah hadir:', error));
        }
    </script>
@endsection
