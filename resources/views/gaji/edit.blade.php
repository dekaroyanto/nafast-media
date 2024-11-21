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

                <!-- Tanggal Gaji -->
                <div class="mb-3">
                    <label for="tanggal_gaji" class="form-label">Tanggal Gaji</label>
                    <input type="date" id="tanggal_gaji" name="tanggal_gaji" class="form-control"
                        value="{{ $gajiKaryawan->tanggal_gaji }}" required>
                </div>

                <!-- Nama Karyawan -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama Karyawan</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">Pilih Karyawan</option>
                        @foreach ($karyawan as $k)
                            <option value="{{ $k->id }}" data-jabatan="{{ $k->jabatan->nama_jabatan }}"
                                data-gajipokok="{{ $k->jabatan->gajipokok }}"
                                data-tunjangan_transport="{{ $k->jabatan->tunjangan_transportasi }}"
                                data-tunjangan_makan="{{ $k->jabatan->tunjangan_makan }}"
                                data-tunjangan_kesehatan="{{ $k->jabatan->tunjangan_kesehatan }}"
                                {{ $k->id == $gajiKaryawan->user_id ? 'selected' : '' }}>
                                {{ $k->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jabatan -->
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" id="jabatan" class="form-control"
                        value="{{ $gajiKaryawan->user->jabatan->nama_jabatan }}" readonly>
                </div>

                <!-- Jumlah Hari Kerja -->
                <div class="mb-3">
                    <label for="jumlah_hari_kerja" class="form-label">Jumlah Hari Kerja</label>
                    <input type="number" id="jumlah_hari_kerja" name="jumlah_hari_kerja" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_hari_kerja }}" required>
                </div>

                <!-- Gaji Pokok -->
                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="text" id="gaji_pokok" name="gaji_pokok" class="form-control"
                        value="{{ $gajiKaryawan->gaji_pokok }}" readonly>
                </div>

                <!-- Gaji Per Hari -->
                <div class="mb-3">
                    <label for="gaji_per_hari" class="form-label">Gaji Per Hari</label>
                    <input type="text" id="gaji_per_hari" name="gaji_per_hari" class="form-control"
                        value="{{ $gajiKaryawan->gaji_per_hari }}" readonly>
                </div>

                <!-- Jumlah Hadir -->
                <div class="mb-3">
                    <label for="jumlah_hadir" class="form-label">Jumlah Hadir</label>
                    <input type="number" id="jumlah_hadir" name="jumlah_hadir" class="form-control"
                        value="{{ $gajiKaryawan->jumlah_hadir }}">
                </div>

                <!-- Tunjangan Transportasi Per Hari -->
                <div class="mb-3">
                    <label for="tunjangan_transport_perhari" class="form-label">Tunjangan Transport Per Hari</label>
                    <input type="text" id="tunjangan_transport_perhari" class="form-control"
                        value="{{ $gajiKaryawan->user->jabatan->tunjangan_transportasi }}" readonly>
                </div>

                <!-- Tunjangan Transportasi Didapat -->
                <div class="mb-3">
                    <label for="tunjangan_transport_didapat" class="form-label">Tunjangan Transportasi Didapat</label>
                    <input type="text" id="tunjangan_transport_didapat" name="tunjangan_transport_didapat"
                        class="form-control" value="{{ $gajiKaryawan->tunjangan_transport_didapat }}" readonly>
                </div>

                <!-- Tunjangan Makan Per Hari -->
                <div class="mb-3">
                    <label for="tunjangan_makan_perhari" class="form-label">Tunjangan Makan Per Hari</label>
                    <input type="text" id="tunjangan_makan_perhari" class="form-control"
                        value="{{ $gajiKaryawan->user->jabatan->tunjangan_makan }}" readonly>
                </div>

                <!-- Bonus -->
                <div class="mb-3">
                    <label for="bonus" class="form-label">Bonus</label>
                    <input type="number" id="bonus" name="bonus" class="form-control"
                        value="{{ $gajiKaryawan->bonus }}">
                </div>

                <!-- Potongan -->
                <div class="mb-3">
                    <label for="potongan" class="form-label">Potongan</label>
                    <input type="number" id="potongan" name="potongan" class="form-control"
                        value="{{ $gajiKaryawan->potongan }}" readonly>
                </div>

                <!-- Total Gaji -->
                <div class="mb-3">
                    <label for="total_gaji" class="form-label">Total Gaji</label>
                    <input type="text" id="total_gaji" name="total_gaji" class="form-control"
                        value="{{ $gajiKaryawan->total_gaji }}" readonly>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const jabatan = selectedOption.getAttribute('data-jabatan');
            const gajiPokok = parseInt(selectedOption.getAttribute('data-gajipokok')) || 0;
            const tunjanganTransportPerhari = parseInt(selectedOption.getAttribute('data-tunjangan_transport')) ||
                0;
            const tunjanganMakanPerhari = parseInt(selectedOption.getAttribute('data-tunjangan_makan')) || 0;

            document.getElementById('jabatan').value = jabatan || '';
            document.getElementById('gaji_pokok').value = gajiPokok;
            document.getElementById('tunjangan_transport_perhari').value = tunjanganTransportPerhari;
            document.getElementById('tunjangan_makan_perhari').value = tunjanganMakanPerhari;

            calculateGaji();
        });

        document.getElementById('jumlah_hadir').addEventListener('input', calculateGaji);
        document.getElementById('bonus').addEventListener('input', calculateGaji);
        document.getElementById('jumlah_hari_kerja').addEventListener('input', calculateGaji);

        function calculateGaji() {
            const gajiPokok = parseInt(document.getElementById('gaji_pokok').value) || 0;
            const jumlahHariKerja = parseInt(document.getElementById('jumlah_hari_kerja').value) || 1;
            const jumlahHadir = parseInt(document.getElementById('jumlah_hadir').value) || 0;

            const tunjanganTransportPerhari = parseInt(document.getElementById('tunjangan_transport_perhari').value) || 0;
            const tunjanganMakanPerhari = parseInt(document.getElementById('tunjangan_makan_perhari').value) || 0;

            const gajiPerHari = Math.ceil(gajiPokok / jumlahHariKerja);
            const tunjanganTransportDidapat = tunjanganTransportPerhari * jumlahHadir;
            const tunjanganMakanDidapat = tunjanganMakanPerhari * jumlahHadir;

            const bonus = parseInt(document.getElementById('bonus').value) || 0;
            const potongan = parseInt(document.getElementById('potongan').value) || 0;

            const totalGaji = gajiPerHari * jumlahHadir + tunjanganTransportDidapat + tunjanganMakanDidapat + bonus -
                potongan;

            document.getElementById('gaji_per_hari').value = gajiPerHari;
            document.getElementById('tunjangan_transport_didapat').value = tunjanganTransportDidapat;
            document.getElementById('total_gaji').value = totalGaji;
        }
    </script>
@endsection
