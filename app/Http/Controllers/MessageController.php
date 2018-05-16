<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 19/04/2018
 * Time: 13:13
 */

namespace App\Http\Controllers;


use App\Http\Mensagem;
use App\Http\TipoNoticia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MessageController extends Controller
{
    public function index($saved = 0)
    {
        $mensagens = Mensagem::orderBy('created_at','desc')->paginate(6);
        $tiposNoticia = TipoNoticia::all();
        $tamanhoImagem = env('IMAGE_SIZE','');

        return view('message.admin', compact('mensagens', 'tiposNoticia', 'tamanhoImagem', 'saved'));
    }

    public function showMensagens()
    {
        $mensagens = Mensagem::orderBy('created_at','desc')->get();
        $tiposNoticia = TipoNoticia::all();

        return view('news', compact('mensagens', 'tiposNoticia'));
    }

    public function editarMensagem($id)
    {
        $mensagem = Mensagem::findOrFail($id);
        $tiposNoticia = TipoNoticia::all();

        return view('message/edit',compact('mensagem','tiposNoticia'));
    }

    public function guardarMensagem(Request $request, $id){

        $mensagem = Mensagem::findOrFail($id);
        $mensagem->titulo = $request->get('titulo');
        $mensagem->informacao = $request->get('corpo');
        $mensagem->tipo_noticia_id = $request->get('tipo');
        $mensagem->created_at = Carbon::now();
        $mensagem->save();

        return redirect()->route('adminBoard');

    }

    public function eliminarMensagem($id)
    {
        $mensagem = Mensagem::where('id', $id)->first();
        $mensagem->delete();

        return redirect()->route('adminBoard');
    }

    public function alterarEstadoMensagem($id)
    {

        //$mensagem = Mensagem::findOrFail($id);
        $mensagem = Mensagem::where('id', $id)->first();
        $mensagem->visivel = $mensagem->visivel ? false : true;
        $mensagem->save();
        return redirect()->route('adminBoard');
    }

    public function create(Request $request)
    {
        if(!$request['tipo'] || !$request['titulo'] || !$request['corpo']){
            return view('message.admin', ['error' => 'Todos os campos têm que estar preenchidos']);
        }

        $tipoNoticia = TipoNoticia::find($request['tipo']);

        $mensagem = new Mensagem;
        $mensagem->visivel = true;
        $mensagem->titulo = $request['titulo'];
        $mensagem->informacao = $request['corpo'];
        $mensagem->tipoNoticia()->associate($tipoNoticia);
        if($request->file('image') != null){
            $mensagem->file = $request->file('image')->getClientOriginalName();

            $request->file('image')->move(
                base_path() . '/public/img/uploads/', $mensagem->file);
        }

        if($mensagem->save()){
            $saved = 1;
        }
        else{
            $saved = -1;
        }



        return $this->index($saved);
    }


}