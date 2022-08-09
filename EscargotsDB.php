<?php 

class EscargotsDB {

    public $host;
    public $port;
    public $debug;


    public function set($collection,$key,$payload) {
        $host = $this->host;
        $port = $this->port;
        $data_string = json_encode($payload); 
        @$ch = curl_init("http://".$host.":".$port."/set?collection=".$collection."&key=".$key) or header('Location: erro_conex.php');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );   

        $result = curl_exec($ch);
        @$Json=json_decode($result);

        return $Json;

    }


    public function get($collection,$key){
        $host = $this->host;
        $port = $this->port;
        @$jsonData=file_get_contents("http://".$host.":".$port."/get?collection=".$collection."&key=".$key) or header('Location: erro_conex.php');
        @$obj = json_decode($jsonData); 
        return $obj;
        
    }


    public function send_list($listName,$collection,$key){
        $host = $this->host;
        $port = $this->port;
        @$jsonData=file_get_contents("http://".$host.":".$port."/send/list?name=".$listName."&collection=".$collection."&key=".$key) or header('Location: erro_conex.php');
        @$obj = json_decode($jsonData); 
        return $obj;
        
    }    


    public function get_list($listName,$collection){
        $host = $this->host;
        $port = $this->port;
        $debug = $this->debug;
        @$jsonData=file_get_contents("http://".$host.":".$port."/get/list?name=".$listName."&collection=".$collection) or header('Location: erro_conex.php');
        @$obj = json_decode($jsonData);        

        if(isset($obj->result)){
            if ($debug == True){
                print($obj->exception);
                exit;
            }else{
                $obj = array();
            }
        }

        return $obj;
        
    }    
    
    

    public function del($collection,$key){
        $host = $this->host;
        $port = $this->port;
        @$jsonData=file_get_contents("http://".$host.":".$port."/del?key=".$key."&collection=".$collection) or header('Location: erro_conex.php');
        @$obj = json_decode($jsonData); 
        return $obj;
        
    }      
    
    

    public function query($payload) {
        $host  = $this->host;
        $port  = $this->port;
        $debug = $this->debug;
        $data_string = json_encode($payload); 
        @$ch = curl_init("http://".$host.":".$port."/query") or header('Location: erro_conex.php');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );   

        $result = curl_exec($ch);
        @$Json=json_decode($result);

        if (isset($Json->result)) {
            # check if is array
            if ($debug == True){
                print($Json->exception);
                exit;
            }else{
                $Json = array();
            }
            
        }

        return $Json;

    }    


}


?>