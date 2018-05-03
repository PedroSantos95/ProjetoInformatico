<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Mensagem;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 30/04/2018
 * Time: 14:38
 */
class NewsController extends Controller
{
    public function index(Request $request)
    {
        $mensagens = [];
        $tipo = $request->input('tipo');

        if (is_null($tipo) || !is_string($tipo) || $tipo==0) {
            $mensagens = Mensagem::orderBy('created_at', 'desc')->get();
        } else {
            $mensagens = Mensagem::where('tipo_noticia_id', $request->input('tipo'))->orderBy('created_at', 'desc')->get();
        }

        $array_msg = [];

        foreach ($mensagens as $msg) {
            $array_msg[] = ['path' => $msg->tipoNoticia->path_black, 'titulo' => $msg->titulo, 'informacao' => $msg->informacao,
                'updated_at' => $msg->updated_at->format('d/m/Y H:i')];
        }


        return $array_msg;
    }


}