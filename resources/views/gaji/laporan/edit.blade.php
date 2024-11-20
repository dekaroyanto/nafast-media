@extends('layouts.template')

@section('title', 'Edit Laporan Harian')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Laporan Harian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tanggal_laporan" class="form-label">Tanggal Laporan</label>
                    <input type="date" id="tanggal_laporan" name="tanggal_laporan" class="form-control"
                        value="{{ $laporan->tanggal_laporan }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Isi Laporan</label>
                    <div id="laporan-items">
                        @foreach ($laporan->isi_laporan as $item)
                            <div class="laporan-item d-flex align-items-center">
                                <input type="text" name="isi_laporan[]" class="form-control mb-2"
                                    value="{{ $item }}" required>
                                <button type="button" class="btn btn-danger ms-2"
                                    onclick="removeLaporanItem(this)">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="addLaporanItem()">Tambah Item
                        Laporan</button>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script>
        function addLaporanItem() {
            const laporanItemsContainer = document.getElementById('laporan-items');
            const newItem = document.createElement('div');
            newItem.classList.add('laporan-item', 'd-flex', 'align-items-center', 'mb-2');
            newItem.innerHTML = `
                <input type="text" name="isi_laporan[]" class="form-control" placeholder="Isi laporan item" required>
                <button type="button" class="btn btn-danger ms-2" onclick="removeLaporanItem(this)">Hapus</button>
            `;
            laporanItemsContainer.appendChild(newItem);
        }

        function removeLaporanItem(button) {
            const itemToRemove = button.parentElement;
            itemToRemove.remove();
        }
    </script>
@endsection
