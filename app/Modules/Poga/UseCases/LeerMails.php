<?php

namespace Raffles\Modules\Poga\UseCases;

use Webklex\IMAP\Client;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Raffles\Modules\Poga\Repositories\PersonaRepository;
use Raffles\Modules\Poga\Repositories\PagareRepository;

class data {

    
    public $importe = 0;
    public $bancoRemitente = "";
    public $nroCuenta="";
    public $cliente ="";
    public $fechaOperacion ="";
    public $fechaAcreditacion =""; 

}

class LeerMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rPersona = new PersonaRepository;
        $rPagare = new PagareRepository;

        $remitente = 'matiasnegri85@gmail.com';
        $oClient = new Client([
            'host'          => 'c1500212.ferozo.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'no-reply@c1500212.ferozo.com',
            'password'      => 'fyCHwag@Q8',
            'protocol'      => 'imap'
        ]);

        $oClient->connect();

        $aFolder = $oClient->getFolders();
        

        foreach($aFolder as $oFolder){
        
            $aMessage = $oFolder->getUnseenMessages(); //Mensajes sin leer
            
          
            foreach($aMessage as $oMessage){
               
                echo "Mensaje sin leer";
                echo "\r\n";
               
                if( $oMessage->getSubject() == 'TRANSFERENCIA BANCARIA'){
                   
                   // $oMessage->unsetFlag('SEEN');
                   // $oClient->expunge();

                    
                    $data = $this->parsear($oMessage->getHTMLBody(true)); 
                        
                    $persona = $rPersona->findWhere(['cuenta_bancaria' => $data->nroCuenta])->first();
                    
                    if($persona){
                        echo $persona->id;
                        $pagare = $rPagare->findWhere(['id_persona_deudora' => $persona->id, 'monto' => $data->importe])->first();
                        if($pagare){
                            $pagare->enum_estado = 'PAGADO';
                            $pagare->save();
                        }
                    }
                        

                    


                }



               
                
               
                
                //mueve el mensaje a leidos
               /* if($oMessage->moveToFolder('INBOX.read') == true){
                    echo 'Message has ben moved';
                }else{
                    echo 'Message could not be moved';
                }*/
            }
        }
    }

    public function parsear($cadena){
        
        $partes = explode("</tr>", $cadena);

        $datos = new data();

        foreach($partes as $parte){
           
            $dato = $this->buscarValor($parte,'Importe:');
            if($dato){
                $datos->importe = $dato; 
            }

            $dato = $this->buscarValor($parte,'Banco Remitente:');
            if($dato){
                $datos->bancoRemitente = $dato; 
            }

            $dato = $this->buscarValor($parte,'N° Cuenta Remitente:');
            if($dato){
                $datos->nroCuenta = $dato; 
            }

            $dato = $this->buscarValor($parte,'Cliente:');
            if($dato){
                $datos->cliente = $dato; 
            }

            $dato = $this->buscarValor($parte,'Fecha Operación:');
            if($dato){
                $datos->fechaOperacion = $dato; 
            }

            $dato = $this->buscarValor($parte,'Fecha Acreditación:');
            if($dato){
                $datos->fechaAcreditacion = $dato; 
            }   
        }

        return $datos;

    }
    
    public function buscarValor($parte,$buscar){
        if(strpos($parte, $buscar)){                
            $comienzo = strpos($parte, $buscar);
            $palabra = substr($parte,$comienzo + strlen($buscar)+ 79,-5);
            return $palabra;
        }
        else{
            return null;
        }
    }

    

    

}
