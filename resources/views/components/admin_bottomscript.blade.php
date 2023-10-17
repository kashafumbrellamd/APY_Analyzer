
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
        </div>
    </div>
</footer>
<!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Bootstrap core JavaScript-->

<script src="{{ asset('/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/assets/js/jquery.easing.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // ========== For Navbar Active starts ==============
        jQuery(function($) {
        var path = window.location.href;
        $('.nav-item a').each(function() {
            if (this.href === path) {
                $(this).parent(".nav-item").addClass('active');
                $(this).parent().parent().parent().addClass('active');
                $(this).addClass('active');
            }
            });
        });
    // ========== For Navbar Active Ends ==============
    });
</script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('/assets/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('/assets/js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('/assets/js/chart-area-demo.js') }}"></script>
<script src="{{ asset('/assets/js/chart-pie-demo.js') }}"></script>


