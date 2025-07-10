<script>
    // Modal Control
    function showCreateModal() {
        const modal = document.getElementById('tagihanModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('tagihanForm');


        document.getElementById('modalTitle').textContent = 'Tambah Tagihan';
        form.action = "{{ route('tagihan.store') }}";
        document.getElementById('formMethod').innerHTML = '';
        form.reset();
        document.getElementById('kode_tagihan').value = 'TGH-' + Math.random().toString(36).substr(2, 8).toUpperCase();
        document.getElementById('pemakaianDisplay').textContent = '0';
        document.getElementById('totalTagihanDisplay').textContent = 'Rp 0';


        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0');
            modalContent.classList.remove('translate-y-10');
        }, 20);
    }

    function showEditModal(id) {
        const modal = document.getElementById('tagihanModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('tagihanForm');

        // Tampilkan modal segera (tanpa menunggu fetch selesai)
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0');
            modalContent.classList.remove('translate-y-10');
        }, 20);

        // Tambahkan loading state jika perlu
        document.getElementById('modalTitle').textContent = 'Memuat...';

        fetch(`/tagihan/${id}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Set form action dan method
                form.action = `/tagihan/${id}`;
                document.getElementById('formMethod').innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
            `;

                // Isi form dengan data
                document.getElementById('modalTitle').textContent = 'Edit Tagihan';
                document.getElementById('pelanggan_id').value = data.pelanggan_id;
                document.getElementById('kode_tagihan').value = data.kode_tagihan;
                document.getElementById('periode_tagihan').value = data.periode_tagihan.substring(0, 7);
                document.getElementById('meter_awal').value = data.meter_awal;
                document.getElementById('meter_akhir').value = data.meter_akhir;
                document.getElementById('pemakaian').value = data.pemakaian;
                document.getElementById('pemakaianDisplay').textContent = data.pemakaian;
                document.getElementById('total_tagihan').value = data.total_tagihan;
                document.getElementById('totalTagihanDisplay').textContent = 'Rp ' +
                    new Intl.NumberFormat('id-ID').format(data.total_tagihan);
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data tagihan',
                });
                closeModal();
            });
    }

    function showDetailModal(id) {
        const modal = document.getElementById('detailModal');
        const modalContent = modal.querySelector('div');


        fetch(`/tagihan/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailKodeTagihan').textContent = data.kode_tagihan;
                document.getElementById('detailStatus').innerHTML = data.status === 'belum_bayar' ?
                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Belum Bayar</span>' :
                    '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Sudah Bayar</span>';


                document.getElementById('detailPelanggan').textContent = data.pelanggan.nama_pelanggan;
                document.getElementById('detailNomorMeter').textContent = data.pelanggan.nomor_meter;
                document.getElementById('detailPeriode').textContent = new Date(data.periode_tagihan)
                    .toLocaleDateString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                document.getElementById('detailPemakaian').textContent = data.pemakaian + ' kWh';
                document.getElementById('detailTarif').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                    data.pelanggan.tarif.harga_per_kwh);
                document.getElementById('detailTotalTagihan').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                    .format(data.total_tagihan);


                if (data.tanggal_bayar) {
                    document.getElementById('detailTanggalBayar').textContent = new Date(data.tanggal_bayar)
                        .toLocaleDateString('id-ID');
                } else {
                    document.getElementById('detailTanggalBayar').textContent = '-';

                }

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('opacity-0');
                    modalContent.classList.remove('translate-y-10');
                }, 20);
            });
    }

    // Close modal functions
    function closeModal() {
        const modal = document.getElementById('tagihanModal');
        const modalContent = document.getElementById('modalContent');


        modalContent.classList.add('opacity-0');
        modalContent.classList.add('translate-y-10');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        const modalContent = modal.querySelector('div');


        modalContent.classList.add('opacity-0');
        modalContent.classList.add('translate-y-10');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Event listeners
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelModal').addEventListener('click', closeModal);
    document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);
    document.getElementById('closeDetailBtn').addEventListener('click', closeDetailModal);

    // Hitung pemakaian dan total tagihan secara otomatis
    document.getElementById('meter_akhir').addEventListener('input', calculateUsage);
    document.getElementById('meter_awal').addEventListener('input', calculateUsage);
    document.getElementById('pelanggan_id').addEventListener('change', calculateUsage);

    function calculateUsage() {
        const meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
        const meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;
        const pelangganSelect = document.getElementById('pelanggan_id');
        const tarif = parseFloat(pelangganSelect.options[pelangganSelect.selectedIndex]?.dataset.tarif) || 0;


        if (meterAkhir < meterAwal) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Meter akhir tidak boleh kurang dari meter awal',
            });
            document.getElementById('meter_akhir').value = '';
            return;
        }


        const pemakaian = meterAkhir - meterAwal;
        const totalTagihan = pemakaian * tarif;


        document.getElementById('pemakaian').value = pemakaian;
        document.getElementById('pemakaianDisplay').textContent = pemakaian.toFixed(2);
        document.getElementById('total_tagihan').value = totalTagihan;
        document.getElementById('totalTagihanDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
            totalTagihan);
    }

    function konfirmasiBayar(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: 'Apakah Anda yakin ingin memproses pembayaran ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Bayar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tagihan/${id}/bayar`;

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus tagihan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tagihan/${id}`;

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3B82F6',
        });
    @endif
</script>
