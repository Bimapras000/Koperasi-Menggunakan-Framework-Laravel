                        <div class="row">
                            <div class="col-md-12">
                                <div class="copyright">
                                    <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
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

    <!-- Jquery JS-->
    <script src="{{asset('admin/vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('admin/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('admin/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('admin/vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{asset('admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('admin/vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{asset('admin/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('admin/vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{asset('admin/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('admin/vendor/select2/select2.min.js')}}"></script>

    <!-- Main JS-->
    <script src="{{asset('admin/js/main.js')}}"></script>

    <script>
function viewMemberDetails(userId) {
    // Lakukan AJAX request untuk mendapatkan data anggota berdasarkan userId
    $.ajax({
        url: '/admin/anggota/' + userId,
        type: 'GET',
        success: function(data) {
            // Isi data ke dalam modal
            $('#viewName').val(data.name);
            $('#viewUsername').val(data.username);
            $('#viewNoTlp').val(data.no_tlp);
            $('#viewAlamat').val(data.alamat);
            $('#viewJabatan').val(data.jabatan);
            if(data.ktp) {
                $('#viewKtp').attr('src', '/storage/fotos/' + data.ktp).show();
            } else {
                $('#viewKtp').attr('src', '').hide();
            }
            // Tambahkan field lainnya jika diperlukan
        }
    });
}
</script>

<script>
    $(document).ready(function(){
        $('img.bukti-foto').on('click', function(){
            var src = $(this).attr('src');
            $('#modalImage').attr('src', src);
            $('#imageModal').modal('show');
        });
    });
</script>


<!-- @push('scripts')
<script>
    $(document).ready(function() {
        $('#users_id').select2({
            placeholder: "Pilih Nama",
            allowClear: true
        });
    });
</script>
@endpush -->

<script>

$(document).ready(function() {
    $(".js-select2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).parent()
    });
});


</script>

</body>



</html>
<!-- end document-->

