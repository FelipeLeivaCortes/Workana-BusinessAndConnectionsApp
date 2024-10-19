<?php
    namespace ThirdParty;

    use function Helpers\dd;

    class ReflexController {
        protected $emailAccount;
        protected $passAccount;
        protected $authorization;

        protected $nit;
        protected $interface;
        protected $escenario;
        protected $donkey;
        protected $data;
        
        protected $urlApi;
        protected $enableConnection;

        public function __construct() {
            /**
             * LA CREDENCIALES Y VARIABLES DE ESTE OBJETO SE UBICAN EN EL ARCHIVO CONF.PHP
             */
            include __DIR__ . "/../../config/conf.php";

            $this->emailAccount     = $email_client;
            $this->passAccount      = $pass_client;

            $this->nit              = $nit_client;
            $this->interface        = $interface_client;
            $this->escenario        = null;
            $this->donkey           = bin2hex(random_bytes(16));
            $this->data             = null;

            $this->urlApi           = $url_api_reflex;
            $this->enableConnection = $enableConnection;
        }

        
        /**
         * ADMINISTRACIÓN DE CLIENTES
         */
        public function createClient($data) {
            $this->escenario    = 'SN_Crear';
            $this->data         = base64_encode($data);
            $this->sendData();
        }

        public function updateClient($data) {
            $this->escenario    = 'SN_Actualizar';
            $this->data         = base64_encode($data);
            $this->sendData();
        }


        /**
         * ADMINISTRACIÓN DE OFERTAS DE VENTAS
         */
        public function createQuote($data) {
            $this->escenario    = 'OFVE_Crear';
            $this->data         = base64_encode($data);
            $this->sendData();
        }

        public function updateQuote($data) {
            $this->escenario    = 'OFVE_Actualizar';
            $this->data         = base64_encode($data);
            $this->sendData();
        }

        public function getQuotes($data=[]) {
            // $this->escenario    = 'OFVE_Obtener';
            // $this->data         = base64_encode($data);
            // $response   = $this->getData($data);

            return [
                [
                    'quo_id'            => 100,
                    'c_name'            => 'Empresa',
                    'origin'            => 'SAP',
                    'quo_name'          => 'Cotizante',
                    'quo_date'          => date('Y-m-d H:i:s'),
                    'quo_total'         => 1000,
                    'quo_url_document'  => 'myURL'
                ]
            ];
        }

        public function getOrders($data=[]) {
            // $this->escenario    = 'OFVE_Obtener';
            // $this->data         = base64_encode($data);
            // $response   = $this->getData($data);

            return [
                [
                    'c_id'                  => 2,
                    'order_id'              => 100,
                    'c_name'                => 'Empresa',
                    'origin'                => 'SAP',
                    'order_name'            => 'Cotizante',
                    'order_date'            => date('Y-m-d H:i:s'),
                    'state_name_es'         => 'Estado',
                    'order_total'           => 1000,
                    'order_url_document'    => 'myURL'
                ]
            ];
        }


        public function createOrder($data) {
            $this->escenario    = 'ORVE_Crear';
            $this->data         = base64_encode($data);
            $this->sendData();
        }

        public function updateOrder($data) {
            $this->escenario    = 'ORVE_Actualizar';
            $this->data         = base64_encode($data);
            $this->sendData();
        }


        /**
         * ESTABLECIENDO COMUNICACIÓN CON LA API
         * SÓLO SI ESTÁ HABILITADA LA CONEXIÓN.
         */
        private function sendData() {
            if ($this->enableConnection) {
                $url    = $this->urlApi."/api/ProcesarData/Procesar";
                $data   = [
                    "nit"       => $this->nit,
                    "interface" => $this->interface,
                    "escenario" => $this->escenario,
                    "dockey"    => $this->donkey,
                    "data"      => $this->data
                ];
                
                $jsonData   = json_encode($data);
                $ch         = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($jsonData),
                    'Authorization: Basic ' . base64_encode($this->emailAccount . ':' . $this->passAccount)
                ]);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                
                $jsonResponse = curl_exec($ch);

                if (curl_errno($ch)) {
                    dd(curl_error($ch));

                } else {
                    $response = json_decode($jsonResponse, true);

                    if($response['recibido'] != 'OK') {
                        dd($jsonResponse);
                    }
                }

                curl_close($ch);
            }
        }

        /**
         * ESTABLECIENDO COMUNICACIÓN CON LA API
         * SÓLO SI ESTÁ HABILITADA LA CONEXIÓN.
         */
        private function getData() {
            if ($this->enableConnection) {
                // $url    = $this->urlApi."/api/ProcesarData/Procesar";
                // $data   = [
                //     "nit"       => $this->nit,
                //     "interface" => $this->interface,
                //     "escenario" => $this->escenario,
                //     "dockey"    => $this->donkey,
                //     "data"      => $this->data
                // ];
                
                // $jsonData   = json_encode($data);
                // $ch         = curl_init($url);

                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_HTTPHEADER, [
                //     'Content-Type: application/json',
                //     'Content-Length: ' . strlen($jsonData),
                //     'Authorization: Basic ' . base64_encode($this->emailAccount . ':' . $this->passAccount)
                // ]);
                // curl_setopt($ch, CURLOPT_POST, true);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                
                // $jsonResponse = curl_exec($ch);

                // if (curl_errno($ch)) {
                //     dd(curl_error($ch));

                // } else {
                //     $response = json_decode($jsonResponse, true);

                //     if($response['recibido'] != 'OK') {
                //         dd($jsonResponse);
                //     }
                // }

                // curl_close($ch);

                return [];
            }
        }
    }
