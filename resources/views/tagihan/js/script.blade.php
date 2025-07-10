<script>
    /**
     * KONTROL MODAL TAGIHAN
     * Kumpulan fungsi untuk mengelola modal CRUD tagihan
     */
    
    // Variabel global untuk elemen-elemen modal
    const modal = document.getElementById('tagihanModal');
    const modalContent = document.getElementById('modalContent');
    const form = document.getElementById('tagihanForm');
    const detailModal = document.getElementById('detailModal');

    /**
     * Menampilkan modal untuk menambah tagihan baru
     */
    function showCreateModal() {
        // Set judul modal dan action form
        document.getElementById('modalTitle').textContent = 'Tambah Tagihan';
        form.action = "{{ route('tagihan.store') }}";
        
        // Reset form dan set nilai default
        document.getElementById('formMethod').innerHTML = '';
        form.reset();
        document.getElementById('kode_tagihan').value = 'TGH-' + Math.random().toString(36).substr(2, 8).toUpperCase();
        document.getElementById('pemakaianDisplay').textContent = '0';
        document.getElementById('totalTagihanDisplay').textContent = 'Rp 0';

        // Tampilkan modal dengan animasi
        showModal();
    }

    /**
     * Menampilkan modal untuk mengedit tagihan
     * @param {number} id - ID tagihan yang akan diedit
     */
    function showEditModal(id) {
        // Tampilkan modal terlebih dahulu
        showModal();
        document.getElementById('modalTitle').textContent = 'Memuat...';

        // Ambil data tagihan dari API
        fetch(`/tagihan/${id}/edit`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal memuat data');
                return response.json();
            })
            .then(data => {
                // Set form action dan method untuk update
                form.action = `/tagihan/${id}`;
                document.getElementById('formMethod').innerHTML = `
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                `;

                // Isi form dengan data tagihan
                fillFormData(data);
                document.getElementById('modalTitle').textContent = 'Edit Tagihan';
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Gagal memuat data tagihan');
                closeModal();
            });
    }

    /**
     * Menampilkan modal detail tagihan
     * @param {number} id - ID tagihan yang akan dilihat
     */
    function showDetailModal(id) {
        // Ambil data tagihan dari API
        fetch(`/tagihan/${id}`)
            .then(response => response.json())
            .then(data => {
                // Tampilkan data di modal detail
                document.getElementById('detailKodeTagihan').textContent = data.kode_tagihan;
                
                // Set status pembayaran
                setPaymentStatus(data.status);
                
                // Isi data pelanggan
                fillCustomerData(data.pelanggan);
                
                // Isi data pemakaian dan tagihan
                fillUsageData(data);
                
                // Tampilkan modal detail
                showDetail();
            });
    }

    /**
     * Menutup modal form tagihan
     */
    function closeModal() {
        modalContent.classList.add('opacity-0', 'translate-y-10');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    /**
     * Menutup modal detail tagihan
     */
    function closeDetailModal() {
        detailModal.querySelector('div').classList.add('opacity-0', 'translate-y-10');
        setTimeout(() => detailModal.classList.add('hidden'), 300);
    }

    /**
     * Menghitung pemakaian dan total tagihan secara otomatis
     */
    function calculateUsage() {
        const meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
        const meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;
        const tarif = getSelectedTarif();

        // Validasi meter akhir tidak boleh kurang dari meter awal
        if (meterAkhir < meterAwal) {
            showError('Meter akhir tidak boleh kurang dari meter awal');
            document.getElementById('meter_akhir').value = '';
            return;
        }

        // Hitung pemakaian dan total tagihan
        const pemakaian = meterAkhir - meterAwal;
        const totalTagihan = pemakaian * tarif;

        // Update tampilan
        updateUsageDisplay(pemakaian, totalTagihan);
    }

    /**
     * Konfirmasi pembayaran tagihan
     * @param {number} id - ID tagihan yang akan dibayar
     */
    function konfirmasiBayar(id) {
        showConfirmation(
            'Konfirmasi Pembayaran',
            'Apakah Anda yakin ingin memproses pembayaran ini?',
            'question',
            `/tagihan/${id}/bayar`
        );
    }

    /**
     * Konfirmasi penghapusan tagihan
     * @param {number} id - ID tagihan yang akan dihapus
     */
    function konfirmasiHapus(id) {
        showConfirmation(
            'Konfirmasi Hapus',
            'Apakah Anda yakin ingin menghapus tagihan ini?',
            'warning',
            `/tagihan/${id}`,
            'DELETE'
        );
    }

    // Fungsi-fungsi bantuan (helper functions)
    
    /**
     * Menampilkan modal dengan animasi
     */
    function showModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('opacity-0', 'translate-y-10');
        }, 20);
    }

    /**
     * Menampilkan modal detail dengan animasi
     */
    function showDetail() {
        detailModal.classList.remove('hidden');
        setTimeout(() => {
            detailModal.querySelector('div').classList.remove('opacity-0', 'translate-y-10');
        }, 20);
    }

    /**
     * Mengisi form dengan data tagihan
     * @param {object} data - Data tagihan
     */
    function fillFormData(data) {
        document.getElementById('pelanggan_id').value = data.pelanggan_id;
        document.getElementById('kode_tagihan').value = data.kode_tagihan;
        document.getElementById('periode_tagihan').value = data.periode_tagihan.substring(0, 7);
        document.getElementById('meter_awal').value = data.meter_awal;
        document.getElementById('meter_akhir').value = data.meter_akhir;
        document.getElementById('pemakaian').value = data.pemakaian;
        document.getElementById('pemakaianDisplay').textContent = data.pemakaian;
        document.getElementById('total_tagihan').value = data.total_tagihan;
        document.getElementById('totalTagihanDisplay').textContent = 
            'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_tagihan);
    }

    /**
     * Menampilkan status pembayaran
     * @param {string} status - Status pembayaran ('belum_bayar' atau 'sudah_bayar')
     */
    function setPaymentStatus(status) {
        const statusElement = document.getElementById('detailStatus');
        statusElement.innerHTML = status === 'belum_bayar' ?
            '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Belum Bayar</span>' :
            '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Sudah Bayar</span>';
    }

    /**
     * Mengisi data pelanggan di modal detail
     * @param {object} pelanggan - Data pelanggan
     */
    function fillCustomerData(pelanggan) {
        document.getElementById('detailPelanggan').textContent = pelanggan.nama_pelanggan;
        document.getElementById('detailNomorMeter').textContent = pelanggan.nomor_meter;
    }

    /**
     * Mengisi data pemakaian di modal detail
     * @param {object} data - Data tagihan
     */
    function fillUsageData(data) {
        document.getElementById('detailPeriode').textContent = 
            new Date(data.periode_tagihan).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
        
        document.getElementById('detailPemakaian').textContent = data.pemakaian + ' kWh';
        document.getElementById('detailTarif').textContent = 
            'Rp ' + new Intl.NumberFormat('id-ID').format(data.pelanggan.tarif.harga_per_kwh);
        document.getElementById('detailTotalTagihan').textContent = 
            'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_tagihan);
        
        document.getElementById('detailTanggalBayar').textContent = data.tanggal_bayar ?
            new Date(data.tanggal_bayar).toLocaleDateString('id-ID') : '-';
    }

    /**
     * Mendapatkan tarif dari pelanggan yang dipilih
     * @return {number} Tarif per kWh
     */
    function getSelectedTarif() {
        const pelangganSelect = document.getElementById('pelanggan_id');
        return parseFloat(pelangganSelect.options[pelangganSelect.selectedIndex]?.dataset.tarif) || 0;
    }

    /**
     * Memperbarui tampilan pemakaian dan total tagihan
     * @param {number} pemakaian - Jumlah pemakaian dalam kWh
     * @param {number} totalTagihan - Total tagihan
     */
    function updateUsageDisplay(pemakaian, totalTagihan) {
        document.getElementById('pemakaian').value = pemakaian;
        document.getElementById('pemakaianDisplay').textContent = pemakaian.toFixed(2);
        document.getElementById('total_tagihan').value = totalTagihan;
        document.getElementById('totalTagihanDisplay').textContent = 
            'Rp ' + new Intl.NumberFormat('id-ID').format(totalTagihan);
    }

    /**
     * Menampilkan pesan error
     * @param {string} message - Pesan error
     */
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
        });
    }

    /**
     * Menampilkan dialog konfirmasi
     * @param {string} title - Judul dialog
     * @param {string} text - Pesan konfirmasi
     * @param {string} icon - Jenis ikon (warning, question, etc.)
     * @param {string} actionUrl - URL tujuan
     * @param {string} [method='POST'] - Metode HTTP (default: POST)
     */
    function showConfirmation(title, text, icon, actionUrl, method = 'POST') {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm(actionUrl, method);
            }
        });
    }

    /**
     * Mengirimkan form secara programatik
     * @param {string} actionUrl - URL tujuan
     * @param {string} method - Metode HTTP
     */
    function submitForm(actionUrl, method) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = actionUrl;

        // Tambahkan CSRF token
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);

        // Jika method bukan POST, tambahkan method spoofing
        if (method !== 'POST') {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = method;
            form.appendChild(methodInput);
        }

        document.body.appendChild(form);
        form.submit();
    }

    // Event listeners
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelModal').addEventListener('click', closeModal);
    document.getElementById('closeDetailModal').addEventListener('click', closeDetailModal);
    document.getElementById('closeDetailBtn').addEventListener('click', closeDetailModal);

    // Event listeners untuk perhitungan otomatis
    document.getElementById('meter_akhir').addEventListener('input', calculateUsage);
    document.getElementById('meter_awal').addEventListener('input', calculateUsage);
    document.getElementById('pelanggan_id').addEventListener('change', calculateUsage);

    // Tampilkan pesan sukses jika ada
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3B82F6',
        });
    @endif
</script>