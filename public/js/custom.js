function getColumnSum(columns) {
    $.each(columns, function(index, val) {
        var sum = $('#myDataTable').DataTable().column(val, { page: 'current' }).data().sum();
        $($('#myDataTable').DataTable().column(val).footer()).html("Total: " + sum);
    });
}

function activeStatus(id, status, slug) {
    $.post(slug, { _token: csrf_token, id: id, status: status },
        function(data, status) {
            if (status == 'success') {
                $.notify({
                    icon: data.icon,
                    message: data.msg
                }, {
                    type: data.type,
                    timer: 1000,
                    placement: {
                        from: 'bottom',
                        align: 'right'
                    }
                });
                if (typeof(oTable) != "undefined" && oTable !== null)
                    oTable.ajax.reload();
            } else
                alert('An unknown error occured.');
        }, 'json');
}
