<?php
/**
 * BuscaPorCep class file
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
 *
 * @category  Extensions
 * @package   extensions
 * @author        Wanderson Bragança <wanderson.wbc@gmail.com>
 * @link          https://bitbucket.org/wbraganca/correios
 * @version   1.0.5
 */
class BuscaPorCep extends CWidget
{
        /**
         * Id ou classe CSS para capturar evento de clique
         * @var string $target
         */
        public $target = null;
        /**
         * Modelo que contém os atributos de endereços
         * @var object $model
         */
        public $model;
        /**
         * Atributo referente ao CEP
         * @var string $attribute
         */
        public $attribute;
        /**
         * Array para mapear os atributos do modelo e da extensão 
         * <code>
         *      array(
         *              'location'=>'exemplo_logradouro',
         *              'district'=>'exemplo_bairro',
         *              'city'=>'exemplo_cidade',
         *              'state'=>'exemplo_estado',
         *      );
         * </code>
         * @var array $config
         */
        public $config = array();
        /**
         * URL para buscar endereço via AJAX
         * @var string $url
         */
        public $url = '';
        /**
         * Mapa de campos
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
         * Inicializa o Widget
         */
        public function init()
        {
                parent::init();
        }

        public function run()
        {
                $fieldsMap = array();
                foreach( $this->config as $field => $attributeName ){
                        if( isset($this->fieldsMap[$field]) && 
                                $field != 'result' && $field != 'restul_text'){
                                $fieldsMap[$field] = CHtml::activeID($this->model, $attributeName);
                        } else {
                                throw new CException(Yii::t('BuscaPorCepApp.correios', 'Invalid parameter.'));
                        }
                }
                if( $this->target !== null )
                        $this->registerJS($fieldsMap);
        }

        /**
         * Registra script para busca via AJAX
         * @param array $fieldsMap
         */
        protected function registerJS($fieldsMap)
        {
                $fieldsMap = CJSON::encode($fieldsMap);
                $postalCodeID = CHtml::activeID($this->model, $this->attribute);
                $url = Yii::app()->createAbsoluteUrl($this->url);
                $errorMsgID = $postalCodeID . '_em_';
                $script = <<<EOF
jQuery("{$this->target}").on("click", function(){
        var fieldsMap = {$fieldsMap};
        $.each(fieldsMap, function(key, val) {
                jQuery('#' + val).attr("disabled","true");
        });
        $.ajax({
                dataType: "json",
                url: "{$url}",
                data: {'cep':jQuery("#{$postalCodeID}").val()},
                success: function(json){
                        $.each(fieldsMap, function(key, val) {
                                jQuery('#' + val).removeAttr("disabled","true");
                                jQuery('#' + val).val(unescape(json[key]));
                        });
                        if( json['result'] == '0'){
                                jQuery("#{$errorMsgID}").show().html(json['result_text']); 
                        }
                }
        });
        return false;
});
EOF;
                Yii::app()->clientScript->registerScript(__CLASS__ . $this->id, $script, CClientScript::POS_END);
        }
}