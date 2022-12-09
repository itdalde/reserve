
<!-- Scripts -->
<!-- Libs JS -->
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/dist/feather.min.js')}}"></script>
<script src="{{asset('assets/libs/prismjs/prism.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js')}}"></script>
<script src="{{asset('assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js')}}"></script>

<!-- Theme JS -->
<script src="{{asset('assets/js/theme.min.js')}}"></script>
<script src="{{asset('assets/js/general.js')}}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>

<script  type="text/javascript">
    $(document).ready( function () {
        $('body').on('keyup','#head-general-search',function (e) {
        });
        $(document).on('focus', '#head-general-search', function() {

            $(this).unbind().bind('keyup', function(e) {
                if(e.keyCode === 13) {
                    window.location.href = "{{route('services.index')}}"+"?search="+$(this).val();
                }
            });
        });

    });
</script>
