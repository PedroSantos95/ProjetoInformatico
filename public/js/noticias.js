(function () {
    'use strict';

    var table = $('#datatable').DataTable({
        "bInfo" : false,
        responsive: true,
        "language": {
            "sProcessing":   "A processar...",
            "sLengthMenu":   "Mostrar _MENU_ registos",
            "sZeroRecords":  "Não foram encontrados resultados",
            "sInfo":         "A mostrar de _START_ até _END_ de _TOTAL_ registos",
            "sInfoEmpty":    "A mostrar de 0 até 0 de 0 registos",
            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
            "sInfoPostFix":  "",
            "sSearch":       "Procurar: ",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Primeiro",
                "sPrevious": "Anterior ",
                "sNext":     " Seguinte",
                "sLast":     "Último"
            }
        },
        ajax: {
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
            },
            url: '/api/news',
            dataSrc: ''
        },
        columns: [
            {
                data: null,
                render: function (data) {
                    return '<div style="text-align: center"><img src="icons/' + data.path + '" height="32" width="32"></div>';
                }
            },
            {
                data: null,
                render: function (data) {
                    return '<div style="width: 100%; word-wrap: break-word; text-align: left">'+ data.titulo +'</div>'
                }
            },
            {
                className: "one",
                data: null,
                render: function (data) {
                    return '<div style="max-width: 380px; word-wrap: break-word; text-align: left;">'+ data.informacao +'</div>'
                }
            },
            {
                className: "one",
                data:null,
                render: function (data) {
                    return '<div style="text-align: center;">'+ data.updated_at +'</div>'
                }
                // data: 'updated_at'
            },
            {
                data: null,
                render: function (data) {
                    let button = '<div style="text-align: center"><a data-toggle="modal" style="text-align:center" data-target="#mensagem" onclick="updateModalHeader(\'';
                    button = button + data.titulo + '\',\'' + data.path;
                    button = button + '\'); updateModalInfo(\'';
                    button = button + data.informacao;
                    button = button + '\'); updateModalCreatedAt(\'';
                    button = button + data.updated_at;
                    button = button + '\') "><img height="28" width="30" src="icons/loupe.png"></a></div>';
                    return button;
                }
            }
        ]
    });

    let radios = document.getElementsByClassName('selecao-tipo');
    for(let i=0; i<radios.length; i++){
        radios[i].addEventListener("click", function clickUpdate (){
            let tipo = radios[i].id;

            table.ajax.url('/api/news?tipo='+tipo);
            table.ajax.reload();
        });

    }
})();