<?php

namespace App\Http\Controllers\Zoom;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class ZoomController
{
    public function __construct()
    {
        // Exibe em pt_BR
        date_default_timezone_set('America/Sao_Paulo');
//        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
    }

    private function generateJWTKey(){
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+ 1 minute'),
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    public function index(){
        return view('index');
    }

    public function createMeeting($data){
        $post_time = $data['start_date'];
        $start_time = date("Y-m-d\TH:i:s", strtotime($post_time));

        $createMeetingArray = array();
        $createMeetingArray['topic'] = $data['topic'];
        $createMeetingArray['agenda'] = !empty($data['agenda']) ? $data['agenda'] : '';
        $createMeetingArray['type'] = !empty($data['type']) ? $data['type'] : 2;
        $createMeetingArray['time_zone'] = 'Asia/Tashkent';
        $createMeetingArray['start_time'] = $start_time;
        $createMeetingArray['password'] = '';
        $createMeetingArray['duration'] = !empty($data['duration']) ? $data['duration'] : 50;

        $createMeetingArray['settings'] = array(
            "host_video" => true, // reuniões com vídeo ativado
            "participant_video" => true, // participante com video ativado
            "join_before_host" => true, //Se os participantes podem ingressar antes do anfitrião
            "mute_upon_entry" => true, //silenciar participantes antes de começar
            "approval_type" => 0, //aprovação do registro da reunião
            "registration_type" => 1, //tipo de registro da reunião
            "audio" => "both", //como participantes entram na parte de audio da reunião
            "enforce_login" => false,
            "jbh_time" => 5,
            "registrants_email_notification" => false, //enviar email de notificação ao registrar reunião
            "enforce_login_domains" => "",
            "alternative_hosts" => "", //endereços de e-mails ou IDs dos anfitriões alternativos
        );

        return $this->sendRequest($createMeetingArray);
    }

    protected function sendRequest($data){
        $request_url = 'https://api.zoom.us/v2/users/me/meetings';

        $headers = array(
            'authorization: Bearer '.$this->generateJWTKey(),
            'content-type: application/json',
            'Accept: application/json',
        );

        $post_field = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $request_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_ENCODING, '');
        curl_setopt($ch,CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch,CURLOPT_TIMEOUT, 300);
        curl_setopt($ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_POSTFIELDS, $post_field);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!$response){
            return $err;
        }
        return json_decode($response);
    }

    public function create(Request $request){

        $date = $request->input('data');
        $hora = $request->input('hora');
        $datahora = $date.' '.$hora;

        $data = array();

        $data['topic'] = $request->input('assunto');
        $data['start_date'] = $datahora;
        $data['duration'] = 50;
        $data['type'] = 2;

        try {
            $response = $this->createMeeting($data);

            dd($response);

            //  echo '<pre>';
            // print_r($response);
            // echo '</pre>';

            $resultado = [
              'assunto' => $response->topic,
              'data' => date('d/m/Y',strtotime($response->start_time)),
              'hora' => date('H:i',strtotime($response->start_time)),
              'duracao' => $response->duration,
              'link' => $response->join_url,
            ];

            return response()->json([$resultado]);

            /*echo '<h2>Segue informações da sua reunião Zoom!</h2>';
            echo '<p><b>ID:<b> '.$response->id.'</p>';
            echo '<p><b>ID:<b> '.$response->uuid.'</p>';
            echo '<p><b>Assunto:<b> '.$response->topic.'</p>';
            echo '<p><b>Data:<b> '.date('d/m/Y',strtotime($response->start_time)).'</p>';
            echo '<p><b>Hora:<b> '.date('H:i',strtotime($response->start_time)).'</p>';
            echo '<p><b>Duração:<b> '.$response->duration.' min</p>';
            echo '<p><b>Link da reunião:</b> <a href="'.$response->join_url.'">'.$response->join_url.'</a></p>';*/

        }catch (Exception $e){
            print_r($e);
        }

    }

}
