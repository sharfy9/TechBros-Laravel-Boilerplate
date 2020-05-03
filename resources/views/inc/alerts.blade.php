<?php
    $msg = [];
    if(session()->has('successMsg'))
        $msg[] = [
            'type' => 'success',
            'icon' => "fas fa-check-circle",
            'message' => session()->get('successMsg')
        ];
    if(session()->has('warningMsg'))
        $msg[] = [
            'type' => 'warning',
            'icon' => "fas fa-bell",
            'message' => session()->get('warningMsg')
        ];
    if(!$errors->isEmpty())
        foreach ($errors->all() as $error)
            $msg[] = [
                'type' => 'danger',
                'icon' => "fas fa-exclamation-circle",
                'message' => $error
            ];
?>
@push('js')
<script>
var msg = {!! json_encode($msg) !!};
$.each(msg, function(key, val){
    
    $.notify({
        icon: val.icon,
        message: val.message
        
    }, {
        type: val.type,
        timer: 8000,
        placement: {
            from: 'bottom',
            align: 'right'
        }
    });
});
</script>
@endpush
