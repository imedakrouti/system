{
    "extend": "colvis",
    "text": "<i class='la la-flag'></i><span class='hidden'>Show/hide columns</span>",
    "className": "btn btn-secondary buttons-print btn-info mr-1",
    columns: ':not(:first):not(:last)'
},

{
    "extend": "copy",
    exportOptions: {
    columns: ':visible'
    },
    "text": "<i class='la la-copy'></i> <span class='hidden'>Copy to clipboard</span>",
    "className": "btn btn-white btn-info btn-bold"
},

{
    "extend": "excel",
    exportOptions: {
        columns: ':visible'
    },
    "text": "<i class='la la-file-excel-o'></i> <span class='hidden'>Export to Excel</span>",
    "className": "btn btn-white btn-info btn-bold"
},

{
    "extend": "print",
    exportOptions: {
        columns: ':visible'
    },
    "text": "<i class='la la-print'></i> <span class='hidden'>Print</span>",
    "className": "btn btn-white btn-info btn-bold",
    autoPrint: true,
    message: ''
},
