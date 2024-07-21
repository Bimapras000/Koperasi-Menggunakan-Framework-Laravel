                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2024 kopertasi mayangsari.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
<!-- jQuery -->
<script src="{{ asset('admin/vendor/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src="{{ asset('admin/vendor/bootstrap-4.1/popper.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>

<!-- Vendor JS -->
<script src="{{ asset('admin/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('admin/vendor/wow/wow.min.js') }}"></script>
<script src="{{ asset('admin/vendor/animsition/animsition.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('admin/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('admin/vendor/counter-up/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('admin/vendor/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/vendor/chartjs/Chart.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<!-- Main JS -->
<script src="{{ asset('admin/js/main.js') }}"></script>

<!-- Select2 Initialization -->
<script>

    $(document).ready(function() {
    $('.js-select2').select2();
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nominalInput = document.getElementById('nominal');
        const tglPinjamanInput = document.getElementById('tgl_pinjaman');
        const tglPengembalianInput = document.getElementById('tgl_pengembalian');
        const totalInput = document.getElementById('total');

        function calculateTotal() {
            const nominal = parseFloat(nominalInput.value) || 0;
            const tglPinjaman = new Date(tglPinjamanInput.value);
            const tglPengembalian = new Date(tglPengembalianInput.value);

            if (!isNaN(tglPinjaman) && !isNaN(tglPengembalian)) {
                const timeDiff = Math.abs(tglPengembalian - tglPinjaman);
                const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const diffMonths = Math.ceil(diffDays / 30); // Perhitungan kasar jumlah bulan

                const bungaPerBulan = nominal * 0.02;
                const totalBunga = bungaPerBulan * diffMonths;
                const total = nominal + totalBunga;

                totalInput.value = total.toFixed(2);
            }
        }

        nominalInput.addEventListener('input', calculateTotal);
        tglPinjamanInput.addEventListener('change', calculateTotal);
        tglPengembalianInput.addEventListener('change', calculateTotal);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cleaveC = new Cleave('#nominal', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            delimiter: '.',
            numeralDecimalMark: ','
        });
    });
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#detailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            // Fetch data from the server
            fetch(`/admin/peminjaman/${id}`)
                .then(response => response.json())
                .then(data => {
                    var modal = $('#detailModal');
                    modal.find('.modal-body #viewName').val(data.user.name);
                    modal.find('.modal-body #viewAlamat').val(data.user.alamat);
                    modal.find('.modal-body #viewNoTlp').val(data.user.no_tlp);
                    modal.find('.modal-body #viewKeperluan').val(data.peminjaman.keperluan);
                    modal.find('.modal-body #viewNominal').val(data.peminjaman.nominal);
                    modal.find('.modal-body #viewTglPinjaman').val(data.peminjaman.tgl_pinjaman);
                    modal.find('.modal-body #viewTglPengembalian').val(data.peminjaman.tgl_pengembalian);
                    modal.find('.modal-body #viewBunga').val(data.peminjaman.bunga);
                    modal.find('.modal-body #viewTotal').val(data.peminjaman.total);
                    modal.find('.modal-body #viewPembayaranBulanan').val(data.monthlyPayment);
                });
        });
    });
</script> -->


<!-- <script>
    document.getElementById('select-action').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue === 'pdf') {
            window.location.href = '{{ url("admin/anggota/anggotaPDF") }}';
        }
        // Tambahkan tindakan lain berdasarkan nilai yang dipilih
    });
</script> -->



</body>



</html>
<!-- end document-->

