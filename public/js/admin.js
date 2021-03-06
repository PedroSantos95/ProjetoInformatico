(function () {
    'use strict';

    var table = $('#datatable').DataTable({
        "bInfo" : false,
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
            url: '/api/admin/'+rally,
            dataSrc: ''
        },
        columnDefs: [
            { orderable: false, targets:[-1, -2, -4, -5, -6] }
        ],
        columns: [
            {
                sWidth: '15%',
                data: null,
                render: function (data) {
                    return '<div style="text-align: center"><img alt="'+ data.nome_tipo +'" src="icons/' + data.path + '" height="32" width="32"></div>';
                }
            },
            {
                data: null,
                render: function (data) {
                    return '<div style="width: 100%; word-wrap: break-word">'+ data.titulo +'</div>'
                }
            },
            {
                className: "one",
                data: null,
                render: function (data) {
                    return '<div style="max-width: 380px; word-wrap: break-word">'+ data.informacao +'</div>'
                }
            },
            {
                sWidth: '15%',
                className: "one",
                data:null,
                render: function (data) {
                    return '<div style="text-align: center">'+ data.updated_at +'</div>'
                }
                // data: 'updated_at'
            },
            {
                sWidth: '10%',
                className: "one",
                data:null,
                render: function (data) {
                    return '<div style="text-align: center">'+ data.visivelBonito +'</div>'
                }
                // data: 'updated_at'
            },
            {
                data: null,
                render: function (data) {
                    if(data.imagem != null){
                        let img = '<a href="';
                        img = img + '/admin/' + data.id + '/editarMensagem';
                        img = img + '"><img alt="Editar noticia" height="25" width="25" src="icons/edit.png"></a>&nbsp&nbsp';
                    }
                    let modal = '<div style="text-align: center"><a data-keyboard="true" data-toggle="modal"  data-target="#mensagem" onclick="updateModalHeader(\'';
                    modal = modal + data.titulo + '\',\'' + data.tipo;
                    modal = modal + '\'); updateModalInfo(\'';
                    modal = modal + data.informacao;
                    modal = modal + '\'); updateModalCreatedAt(\'';
                    modal = modal + data.updated_at;
                    modal = modal + '\'); updateModalVisivel(\'';
                    modal = modal + data.visivel;
                    modal = modal + '\') "><img alt="Detalhes da noticia" height="28" width="30" src="icons/loupe.png"></a>&nbsp&nbsp';

                    let edit = '<a href="';
                    edit = edit + '/admin/' + data.id + '/editarMensagem';
                    edit = edit + '"><img alt="Editar noticia" height="25" width="25" src="icons/edit.png"></a>&nbsp&nbsp';

                    let eliminate = '<a onclick="return confirm(\'Deseja eliminar a noticia selecionada??\');" href="';
                    eliminate = eliminate + '/admin/'+ data.id +'/eliminarMensagem';
                    eliminate = eliminate + '"><img alt="Eliminar noticia" height="25" width="25" src="icons/cancel.png"></a>&nbsp&nbsp';

                    let visibility = '<a href="';
                    visibility = visibility + '/admin/'+ data.id +'/alterarEstado';
                    visibility = visibility + '"><img alt="Visibilidade da noticia" height="32" width="32"src="';


                    if(data.visivel == 1) {
                        visibility = visibility + 'icons/hide.png">'
                    }else{
                        visibility = visibility + 'icons/view.png">'
                    }
                    visibility = visibility + '</a></div>';

                    return modal+edit+eliminate+visibility;
                }
            }
        ]
    });

    // let radios = document.getElementsByClassName('selecao-tipo');
    // for(let i=0; i<radios.length; i++){
    //     radios[i].addEventListener("click", function clickUpdate (){
    //         let tipo = radios[i].id;
    //
    //         table.ajax.url('/api/news?tipo='+tipo);
    //         table.ajax.reload();
    //     });
    //
    // }
})();