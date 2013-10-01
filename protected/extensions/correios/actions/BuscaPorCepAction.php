<?php
require_once(realpath(dirname(__FILE__).'/../BuscaPorCepApp.php'));
/**
 * BuscaPorCepAction class file
 *
 * @category  Extensions
 * @package   extensions
 * @author        Wanderson Bragança <wanderson.wbc@gmail.com>
 * @copyright Copyright &copy; 2013
 * @link          https://bitbucket.org/wbraganca/correios
 */

/**
 * Action responsável para retornar o resultado de uma busca
 *
 * @category  Extensions
 * @package   extensions
 * @author        Wanderson Bragança <wanderson.wbc@gmail.com>
 * @link          https://bitbucket.org/wbraganca/correios
 * @version   1.0.5
 */
class BuscaPorCepAction extends CAction
{
        public function run()
        {
                if( isset($_GET['cep']) ){
                        $cep = $_GET['cep'];
                        $obj = new BuscaPorCepApp();
                        echo CJSON::encode( $obj->run($cep) );
                }
        }
}