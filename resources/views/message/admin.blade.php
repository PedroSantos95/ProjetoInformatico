<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" content="no-cache">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <title>Pagina Administrador</title>
    <style>
        hr.style-two {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }
    </style>
</head>

<body>
<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">TemposOnline</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</div>

<div class="container col-lg-6">
    <h3>Inserir uma mensagem</h3>
</div>
<div class="container col-lg-6">
    <form action="" method="POST">
        <div>
            <label><strong>Tipo de noticia</strong></label><br>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                @for ($i = 0; $i <sizeof($tiposNoticia); $i++)
                    <label class="btn btn-dark    {{ $i == 0 ? 'active' : '' }}">
                        <input type="radio" name="tipo" value="{{$tiposNoticia[$i]->id}}" autocomplete="off"
                                {{ $i == 0 ? 'checked' : '' }}>
                        <img src="icons/{{$tiposNoticia[$i]->path_white}}" height="32" width="32">
                        {{$tiposNoticia[$i]->nome}}
                    </label>
                @endfor

                {{--<label class="btn btn-primary active">--}}
                {{--<input type="radio" name="tipo" value="informacoes" autocomplete="off"><img src="icons/info.png"--}}
                {{--height="48" width="48">--}}
                {{--Informações--}}
                {{--</label>--}}
                {{--<label class="btn btn-primary ">--}}
                {{--<input type="radio" name="tipo" value="tempos" autocomplete="off"><img src="icons/time.png"--}}
                {{--height="48" width="48">--}}
                {{--Tempos--}}
                {{--</label>--}}
                {{--<label class="btn btn-primary ">--}}
                {{--<input type="radio" name="tipo" value="acidentes" autocomplete="off"><img src="icons/crash.png"--}}
                {{--height="48" width="48">--}}
                {{--Acidentes--}}
                {{--</label>--}}
            </div>

        </div>
        <br>
        {{--<select class="form-control" name="tipo" style="height: 100%" required>--}}
        {{--<option value="" disabled selected>Selecione o tipo de noticia</option>--}}
        {{--<option value="noticias">Noticias</option>--}}
        {{--<option value="informacoes">Informações</option>--}}
        {{--<option value="tempos">Tempos</option>--}}
        {{--<option value="acidentes">Acidentes</option>--}}
        {{--</select>--}}
        <div class="form-group">
            <label for=""><strong>Titulo da Mensagem</strong></label>
            <input required type="text" class="form-control" name="titulo" placeholder="Titulo" maxlength="30">
        </div>
        <div class="form-group">
            <label for=""><strong>Mensagem</strong></label>
            <textarea required type="text" name="corpo" class="form-control" placeholder="Mensagem"
                      maxlength="255"></textarea>
        </div>
        {{ csrf_field() }}

        <input type="submit" class="btn btn-dark" value="Submit">
    </form>
</div>

<br>
<hr class="style-two">

<div class="container col-lg-10">
    <div style="margin-top: 1%">
        <table class="table table-striped table-bordered" id="datatable" cellspacing="0" style="width: 100%; table-layout: fixed">
            <thead>
            <tr>
                <th style="width: {{100/6}}%">Tipo</th>
                <th style="width: {{100/6}}%">Titulo</th>
                <th style="width: {{100/6}}%">Mensagem</th>
                <th style="width: {{100/6}}%">Data</th>
                <th style="width: {{100/18}}%">Visivel</th>
                <th style="width: {{100/5}}%">Ações</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Tipo</th>
                <th>Titulo</th>
                <th>Mensagem</th>
                <th>Data</th>
                <th>Visivel</th>
                <th>Ações</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach ($mensagens as $mensagem)
                <tr>

                    <td style="overflow: hidden">{{$mensagem->tipoNoticia->nome}}</td>
                    <td style="overflow: auto">{{$mensagem->titulo}}</td>
                    {{--<th>{{$mensagem->tipo_noticia}}</th>--}}
                    {{--<th><img src="icons/{{$mensagem->tipoNoticia->path_black}}" height="48" width="48"></th>--}}
                    <td style="overflow: auto">{{$mensagem->informacao}}</td>
                    <td style="overflow: hidden">{{$mensagem->created_at}}</td>
                    <td style="overflow: hidden">
                        @if($mensagem->visivel == true)
                            Sim
                        @endif
                        @if($mensagem->visivel == false)
                            Nao
                        @endif
                    </td>
                    <td style="overflow: hidden">
                        <button data-toggle="modal" data-target="#mensagem" class="btn btn-info btn-sm"
                                onclick="updateModalInfo('{{$mensagem->informacao}}'); updateModalHeader('{{$mensagem->titulo}}')">
                            Detalhes
                        </button>
                        <a class="btn btn-danger btn-sm"
                           href="{{route('eliminarMensagem', ['id' => $mensagem->id])}}">Eliminar</a>
                        @if($mensagem->visivel == true)
                            <a class="btn btn-primary btn-sm"
                               href="{{route('alterarEstadoMensagem', ['id' => $mensagem->id])}}">Esconder</a>
                        @endif
                        @if($mensagem->visivel == false)
                            <a class="btn btn-primary btn-sm"
                               href="{{route('alterarEstadoMensagem', ['id' => $mensagem->id])}}">Mostrar</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$mensagens->links()}}
    </div>
</div>


<!-- Modal -->
<div id="mensagem" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="word-wrap: break-word;">Titulo</h4>
            </div>
            <div class="modal-body">
                <p class="informacao_modal" style="word-wrap: break-word;">Nao Titulo</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    function updateModalInfo(informacao) {
        $('.informacao_modal').text(informacao);
    }
</script>

<script>
    function updateModalHeader(titulo) {
        $('.modal-title').html(titulo);
    }
</script>

<script>
    function alterarEstadoMensagem(estadoMensagem) {
        if (estadoMensagem == true) {
            estadoMensagem = false;
        } else {
            estadoMensagem = true;
        }
    }
</script>


<script src="//code.jquery.com/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="/js/mensagens.js"></script>

</body>