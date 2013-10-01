<?php
/**
 * BuscaPorCepApp class file
 *
 * @category  Extensions
 * @package   extensions
 * @author        Wanderson Bragança <wanderson.wbc@gmail.com>
 * @copyright Copyright &copy; 2013
 * @link          https://bitbucket.org/wbraganca/correios
 */

/**
 * Extensão para buscar por um determinado endereço no website dos correios utlizando
 * o cep
 *
 * Para usar adicione no config da sua aplicação conforme exemplo abaixo:
 * <code>
 * array(
 *     ...
 *     'components'=>array(
 *                  'buscaPorCep'=>array(
 *                      'class'=>'ext.correios.BuscaPorCepApp'
 *          ),
 *          ...
 *      ),
 * );
 * </code>
 *
 * Para realizar a busca de um endereço de um determinado CEP use:
 * $endereco = Yii::app()->buscaPorCep->run('12345-678');
 * 
 * Para mais informações acesse o link: https://bitbucket.org/wbraganca/correios/
 *
 * @category  Extensions
 * @package   extensions
 * @author        Wanderson Bragança <wanderson.wbc@gmail.com>
 * @link          https://bitbucket.org/wbraganca/correios
 * @version   1.0.5
 */
class BuscaPorCepApp extends CApplicationComponent
{
        /**
         * URL padrão para buscar o endereço de um determinado CEP no website dos correios
         * @var string
         */
        public $url = 'http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do?Metodo=listaLogradouro&TipoConsulta=cep&CEP=';
        /**
         * @var array $fieldsMap
         */
        private $fieldsMap = array(
                'location'=>'',
                'district'=>'',
                'city'=>'',
                'state'=>'',
                'result'=>0,
        );

        /**
         * Inicializa o componente
         */
        public function init()
        {
                parent::init();
                $this->fieldsMap['result_text'] = Yii::t('BuscaPorCepApp.correios', 'Address not found.');
        }

        public function run($postalCode)
        {
                $postalCode = str_replace('-', '', $postalCode);
                if( empty($postalCode) || strlen($postalCode) != 8 ){
                        $out = $this->fieldsMap;
                        $out['result_text'] = Yii::t('BuscaPorCepApp.correios', 'Invalid postcode.');
                        $out['result'] = 0; 
                        return $out;
                }else{
                        $url = $this->url . $postalCode;
                        $html = file_get_contents($url);
                        if($html !== false){
                                return $this->parseHTML($html);
                        }
                }
                return $out;
        }

        /**
         * Realiza parse do HTML gerado pelo website dos correios.
         * @param string $html
         */
        protected function parseHTML($html)
        {
                $findBy = '<tr bgcolor="#ECF3F6" onclick="javascript:detalharCep(';
                $nPos = strpos($html, $findBy);
                $cleanHTML = '';
                $out = $this->fieldsMap;
                if($nPos){
                        $cleanHTML  = substr($html, $nPos);
                        $nPos       = strpos($cleanHTML, '</tr>');
                        $cleanHTML  = substr($cleanHTML, 0, $nPos+5);
                        $doc = new DOMDocument(); 
                        if( $doc->loadHTML($cleanHTML) ) {
                                $tagData = $doc->getElementsByTagName('td');
                                if( $tagData->length > 0 ){
                                        $out['location']    = $tagData->item(0)->nodeValue;
                                        $out['district']    = $tagData->item(1)->nodeValue;
                                        $out['city']        = $tagData->item(2)->nodeValue;
                                        $out['state']       = $tagData->item(3)->nodeValue;
                                        $out['result']      = 1;
                                        $out['result_text'] = Yii::t('BuscaPorCepApp.correios', 'Address found.');
                                }
                        }
                }
                return $out;
        }

        /**
         * Mensagens de Logs.
         *
         * @param string $message Mensagem a ser registra no arquivo de log
         * @param string $level Nível de mensagens (por exemplo, 'trace', 'warning',
         * 'error', 'info', veja CLogger constants definitions)
         */
        public static function log($message, $level='error')
        {
                Yii::log($message, $level, __CLASS__);
        }
}