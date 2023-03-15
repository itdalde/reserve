
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>




<!-- Optional theme -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="http://reservegcc.com:3000/socket.io/socket.io.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
</script>	<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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

        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd",
            multidate: true,
            defaultDate: new Date(),
            clearBtn: true,
            todayHighlight: true,
        });
        $('.datepicker-time').datetimepicker({
            format: 'HH:mm',
        });

        const socket = io.connect('http://reservegcc.com:3000/reservation', { 'force new connection' : true })
        socket.on('reservation', (msg) => {
            console.log(msg)
            toastr.success('Order is ' + msg.data.status, 'Order updated')
        });

    });

</script>
