<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <title>Rally Sernancelhe Aguiar da Beira</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: right;
            padding: 9px;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
  
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="img/navbar_img.png" height="80" width="152"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link" href="{{route('tempos')}}">Tempos--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('temposSemReferencia')}}">Tempos</a>
                    <span class="sr-only">(current)</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('noticias')}}">Noticias</a>
                </li>
                {{--@if(Auth::check())--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{ route('logout') }}">Logout</a>--}}
                    {{--</li>--}}
                {{--@else--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{route('login')}}">Login</a>--}}
                    {{--</li>--}}
                {{--@endif--}}
                <?php
                use \App\Http\Controllers\api\RallyController;
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white" style="text-align: center">{{RallyController::rallyActive()->nome}}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->

<div class="container" id="app">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4 col-lg-12">
            <div class="btn-group btn-group-toggle" data-toggle="buttons" style="margin-top: 8%;">
            </div>
            
        </div>    
        <div>
            <button type="button" id="reload-button" class="btn btn-outline-info">
                <img src="icons/reload.png" height="21" width="21"> Atualizar
            </button >
            <button type="button" id="auto-button" class="btn btn-outline-info">
                <img src="icons/refresh.png" height="20" width="20"> Atualizar Auto: ON
            </button>
        </div>
        <hr> 

        <!--
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            @for ($i = 0; $i <sizeof($pecs); $i++) 
                <label class="btn btn-outline-info">
                    <div style="text-align: center; width: 40px;" class="selecao-tipo" id="{{$pecs[$i]->nome}}">
                        <input id="type" type="radio" name="tipo" autocomplete="off">
                        {{$pecs[$i]->nome}}
                    </div>
                </label>
            @endfor
        </div>
        !-->
        <table style="width:100%" id="tabelaTempos">
            <tr>
                <th class="text-right"></th>
                <th class="text-right">Carro</th>
                <th class="text-right">P</th>
                @for($i=1; $i<=$numeroTemposIntermedios; $i++)
                    <th class="text-right" align="center">TI <?= $i ?></th>
                @endfor
                <th class="text-right">TT</th>
            </tr>
            <tr class="text-right" v-for="(value, index) in temposFinais">
                <td>
                    <span v-if="index == carroRef">
                        <img onclick="" alt="referencia" height="25" width="25" src="icons/placeholder.png">
                    </span>
                    <span v-else>
                          <img @click="changeCarroRef(index)" alt="referencia" height="25" width="25" src="icons/substract.png">
                    </span>
                </td>
                <td>
                    <span style="font-weight:bold" v-if="index == carroRef">@{{ value.numero_carro }}</span>
                    <span v-if="index != carroRef">@{{ value.numero_carro }}</span>
                </td>
                <td>
                    <span v-if="index != carroRef">@{{ value.tempoPartida | formatDate | formatPartida }}</span>
                    <span style="font-weight:bold" v-if="index == carroRef">@{{ value.tempoPartida | formatDate | formatPartida}}</span>
                </td>
                <td v-for="index2 in numeroTemposIntermedios">
                    <!--<span style="color:red; font-weight: bold" v-if="index != carroRef && getNameField(value, index2).indexOf('+') !== -1">@{{ getNameField(value, index2) }}</span> <!-->    
                    <span style="content: 'center' ;font-weight:bold" v-if="index == carroRef">@{{ '2:'+getCarRefTimes(value, index2)}}</span>
                    <span :style="[getNameField(value, index2) != 0 && index != carroRef && getNameField(value, index2).indexOf('-') !== -1 ? {'color':  'green', 'font-weight' : 'bold'} : {'color': 'red', 'font-weight' : 'bold'}]" v-else>
                    @{{ getNameField(value, index2) }}
                    </span>

                </td>
                <td>
                    <span v-if="index != carroRef">@{{ value.tempoChegada }}</span>
                    </span>
                    <span style="font-weight:bold" v-if="index == carroRef">@{{ value.tempoChegada }}</span>
                </td>
            </tr>

        </table>
        <hr>
        <div>
        </div>
    </div>
    <div>
    </div>
    <br>
    <br>
    <h3 align="center"> Histórico de Notícias </h3>
    <br>
    <div class="container col-lg-8">
    <table class="table table-striped table-bordered custom-datatable display responsive"
           id="historicoNoticias" cellspacing="0" width="100%">
           <caption>
           <a href="{{ route("noticias") }} " target="_blank">
            <img style="margin-bottom: 6px;" alt="referencia" height="13" width="13" src="icons/add.png">
            Mais informações sobre as noticias.
            </a>
           </caption>
        <thead>
        <tr>
            <th width="25%" style="text-align: center;">Data/Hora</th>
            <th width="75%" style="text-align: center;">Notícia</th>
        </tr>
            @for ($i = 0; $i <sizeof($historicoNoticias); $i++)  
            <tr>
                <td style="text-align: left;">
                {{$historicoNoticias[$i]->created_at}}
                </td> 
                         
                <td style="text-align: left;">
                {{$historicoNoticias[$i]->titulo}}
                </td>     
            </tr>                   
            @endfor
        </tr>  
        </thead>
        <tbody>
        </tbody>
    </table>

</div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="//code.jquery.com/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/temposintermedios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            carroRef: 0,
            tempos: [],
            teste: [],
            temposFinais: [],
            carroSelected: '',
            numeroTemposIntermedios: ''
        },
        created() {
            this.fetchTimes();
        },
        methods: {
            fetchTimes() {
                axios.get('/teste').then(response => {
                    this.numeroTemposIntermedios = response.data.numeroTemposIntermedios;
                    this.tempos = response.data.tempos;
                    this.teste = response.data.tempos[0];
                    this.formatArray();
                }).catch(error => {
                    console.log(error);
                })
            },
            formatArray() {
                var counter = 0;
                var newElement = {};
                var previousElement;
                var index = this.carroRef != "" ? this.carroRef : 0;
                this.temposFinais = [];
                for (var carroRef in this.tempos) {               
                    newElement.numero_carro = this.tempos[carroRef].numero_carro;
                    newElement.tempoPartida = this.tempos[carroRef].tempoPartida;
                    if(this.tempos[carroRef].tempoChegada){
                        console.log(this.calculateDiffDates(this.tempos[carroRef].tempoChegada, this.tempos[carroRef].tempoPartida))
                        newElement.tempoChegada = moment(this.tempos[carroRef].tempoChegada, 'YYYY-MM-DD HH:mm:ss').format('mm:ss');
                    }else{
                        newElement.tempoChegada = "--"
                    }
                    
                    for (var value in this.tempos[carroRef]) {
                        if (value.indexOf('Intermedio') !== -1) {
                            if (previousElement !== undefined) {
                                newElement[value] = this.calculateDiffDates(this.tempos[carroRef][value], this.tempos[index].tempoPartida);
                                //console.log(this.calculateDiffDates(this.tempos[carroRef][value], this.tempos[index].tempoPartida));
                                previousElement = value;
                            } else {
                                newElement[value] = this.calculateDiffDates(this.tempos[carroRef][value], this.tempos[index].tempoPartida);
                                //console.log(this.calculateDiffDates(this.tempos[carroRef][value], this.tempos[index].tempoPartida));
                                previousElement = value;
                            }
                        } 
                        counter++;
                    }
                    this.temposFinais.push(newElement);
                    newElement = {};
                }
            },
            getNameField(value, index){
                return this.calculateDiffTimes(this.temposFinais[0]['tempoIntermedio_'+index], value['tempoIntermedio_'+index]);
            },
            getCarRefTimes(value, index){
                return value['tempoIntermedio_'+index];
            },
            calculateDiffTimes(date1, date2) { //Tempos Carro Referencia
                    if (date1 && date2) {
                    date1 = moment(date1, 'mm:ss:ms');
                    console.log("antes" + date2);
                    date2 = moment(date2, 'mm:ss:ms');
                    console.log("d" + date2);
                    var duration = date1.diff(date2);
                    var result = moment.duration(duration);
                    console.log("data1 " + date1);
                    console.log("data2 " + date2);
                    console.log("duration " + duration);
                    console.log(result);
                    console.log("------------------");

                    return result.minutes() + result.seconds() + '.' + result.milliseconds();

                    /*
                    if(result.minutes() == 0){
                        if(result.seconds()>0){
                            if(result.seconds()<10){
                                return result.seconds() + '.' + result.milliseconds();
                            }
                            return result.seconds() + '.' + result.milliseconds();
                        }else{
                            return result.seconds() + '.' + result.milliseconds();
                        }
                    }
                    if(result.minutes()>0){
                        if(result.minutes()<10){
                            if(result.seconds()<10){
                                return result.minutes() + result.seconds() + '.' + result.milliseconds();
                            }else{
                                return result.minutes() + result.seconds() + '.' + result.milliseconds();
                            }
                        }else{
                            if(result.seconds()<10){
                                return result.minutes() + result.seconds() + '.' + result.milliseconds();
                            }else{
                                return result.minutes() + result.seconds() + '.' + result.milliseconds();
                            }
                        }
                    }else{
                        if(result.minutes()>-10){
                            if(result.seconds()<10 || result.seconds()>-10){
                                return Math.abs(result.minutes()) + Math.abs(result.seconds()) + '.' + Math.abs(result.milliseconds());
                            }else{
                                return Math.abs(result.minutes()) + result.seconds() + '.' + Math.abs(result.milliseconds());
                            }
                        }else{
                            if(result.seconds()<10 || result.seconds()>-10){
                                return Math.abs(result.minutes()) + Math.abs(result.seconds()) + '.' + Math.abs(result.milliseconds());
                            }else{
                                return Math.abs(result.minutes()) + Math.abs(result.seconds()) + '.' + Math.abs(result.milliseconds());
                            }
                        }
                    }*/
                }else{
                    return '__';
                }
            },
            calculateDiffDates(date1, date2) {
                if (date1 != null) {
                    date1 = moment(date1, 'YY-mm-dd HH:mm:ss:ms');
                    date2 = moment(date2, 'YY-mm-dd HH:mm:ss:ms');
                    var duration = date1.diff(date2);
                    var result = moment.duration(duration);

                    //console.log(result.seconds());
                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                    /*
                    if (result.hours() == 0) {
                        //console.log("if1");
                        if (result.minutes() == 0) {
                            //console.log("if2");
                            if(result.seconds()==0){
                                //console.log("if3");
                                return result.minutes() + result.seconds() + '.' + result.milliseconds();
                            }else{
                                if(result.seconds()<10){
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }else{
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }
                            }
                        } else {
                            if (result.minutes() < 10) {
                                if(result.seconds()==0) {
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }else{
                                        if(result.seconds()<10){
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }else{
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }
                                    }
                            } else {
                                if(result.seconds()==0){
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }else{
                                    if(result.seconds()<10){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }
                                }
                            }
                        }
                    } else {
                        if (result.hours() < 10) {
                            if (result.minutes() == 0) {
                                if(result.seconds()==0){
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }else{
                                    if(result.seconds()<10){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }
                                }
                            } else {
                                if (result.minutes() < 10) {
                                    if(result.seconds()==0){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        if(result.seconds()<10){
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }else{
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }
                                    }
                                } else {
                                    if(result.seconds()==0){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        if(result.seconds()<10){
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }else{
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }
                                    }
                                }
                            }
                        } else {
                            if (result.minutes() == 0) {
                                if(result.seconds() == 0){
                                    return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                }else{
                                    if(result.seconds()<10){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }
                                }
                            } else {
                                if (result.minutes() < 10) {
                                    if(result.seconds()==0){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        if(result.seconds()<10){
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }else{
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }
                                    }
                                } else {
                                    if(result.seconds()==0){
                                        return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                    }else{
                                        if(result.seconds()<10){
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }else{
                                            return result.minutes() + result.seconds() + '.' + result.milliseconds();
                                        }
                                    }
                                }
                            }
                        }
                    }*/
                }
            },
            changeCarroRef(carroRef){
                this.carroRef = carroRef;
                this.formatArray();
            },
        },
        filters: {
            formatDate(data) {
                return data.toString().split(' ')[1] != null ? data.toString().split(' ')[1] : data;
            },
            formatPartida(data){
                return data.toString().split(':')[2] != null ? data.toString().split(':')[0]+':'+ data.toString().split(':')[1]: data;
            },
            formatTime(data, dataAnterior) {
                dataAnterior = dataAnterior.toString().split(' ')[1] != null ? dataAnterior.toString().split(' ')[1] : dataAnterior;
                return moment(dataAnterior, 'hh:mm:ss.ms').diff(moment(data, 'hh:mm:ss.ms'));
            },
        }
    });
</script>

<script src="/js/noticias.js"></script>

</body>

</html>