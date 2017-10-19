<!-- for notification -->
@if(Session::has('rateNameFailed'))
<script type="text/javascript">
$(window).load(function(){
    swal("Warning", "{{ Session::get('rateNameFailed') }}", "warning");
});
</script>
@endif

@if(Session::has('mediaNameFailed'))
<script type="text/javascript">
$(window).load(function(){
    swal("Warning", "{{ Session::get('mediaNameFailed') }}", "warning");
});
</script>
@endif

@if(Session::has('omzetTypeNameFailed'))
<script type="text/javascript">
$(window).load(function(){
    swal("Warning", "{{ Session::get('omzetTypeNameFailed') }}", "warning");
});
</script>
@endif