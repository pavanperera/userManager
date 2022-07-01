<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
    integrity="sha256-PHcOkPmOshsMBC+vtJdVr5Mwb7r0LkSVJPlPrp/IMpU=" crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"
    integrity="sha256-LlN0a0J3hMkDLO1mhcMwy+GIMbIRV7kvKHx4oCxNoxI=" crossorigin="anonymous"></script>


<script>
    @if(Session::has('success') || Session::has('info') || Session::has('warning') || Session::has('error'))
    //set type
    @if(Session::has('success'))
    var type = 'success';
    var title = "Success! &nbsp;";
    var message = "{{ Session::get('success') }}";
    var icon = 'fa fa-check-circle-o';
    @endif
    @if(Session::has('info'))
    var type = 'info';
    var title = "Info! &nbsp;";
    var message = "{{ Session::get('info') }}";
    var icon = 'fa fa-info-circle';
    @endif
    @if(Session::has('warning'))
    var type = 'warning';
    var title = "Warning! &nbsp;";
    var message = "{{ Session::get('warning') }}";
    var icon = 'icon fa fa-warning';
    @endif
    @if(Session::has('error'))
    var type = 'danger';
    var title = "Error! &nbsp;";
    var message = "{{ Session::get('error') }}";
    var icon = 'icon fa fa-ban';
    @endif

//notify script
$.notify({
    // options
    icon: icon,
    title: title,
    message: message,
    url: '',
    target: '_blank'
    },{
    // settings
    element: 'body',
    position: null,
    type: type,
    allow_dismiss: true,
    newest_on_top: true,
    showProgressbar: false,
    placement: {
      from: "bottom",
      align: "right"
    },
    offset: 20,
    spacing: 10,
    z_index: 1031,
    delay: 5000,
    timer: 1000,
    url_target: '_blank',
    mouse_over: 'pause',
    animate: {
      enter: 'animated bounceInRight',
      exit: 'animated bounceOutRight'
    },
    onShow: null,
    onShown: null,
    onClose: null,
    onClosed: null,
    icon_type: 'class',
    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
              '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
              '<span data-notify="icon"></span> ' +
              '<span data-notify="title"><b>{1}</b></span> ' +
              '<span data-notify="message">{2}</span>' +
              '<div class="progress" data-notify="progressbar">' +
              '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
              '</div>' +
              '<a href="{3}" target="{4}" data-notify="url"></a>' +
              '</div>'
});
@endif

</script>
