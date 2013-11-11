<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	
	<!--
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/base.css'); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<script>
		
		var intervalo;
		$(function(){
			var quant = $('a.close').length;
			if(quant > 0){
				intervalo=self.setInterval(function(){retiraMensagem()},3000);
			}
		});
		
		function retiraMensagem()
		{
			$('a.close').parent('div.alert').fadeOut(function(){
				$(this).remove();
			});
		}
		
	</script>
</head>

<body>
<div class="container-fluid">
	<div class="row-fluid">
		<div style="z-index: 1031; position: absolute; top: 15px; left:100px; width: 85%">
        	<?php
        		// Widget para exibir mensagens para o usuário.
				$this->widget('bootstrap.widgets.TbAlert', array(
				    'block'=>false, // display a larger alert block?
				    'fade'=>true, // use transitions?
				    'closeText'=>'×', // close link text - if set to false, no close link is displayed
				));
			?>
		</div>
		<div class="span12">
			 <?php $this->widget('bootstrap.widgets.TbNavbar',array(
					'brand' => 'SISFIGHT',
					'items' => array(
						array(
							'class' => 'bootstrap.widgets.TbMenu',
							'items' => array(
								array('label'=>'Home', 'url'=>array('/site/index')),
                                array('label'=>'Cadastro', 'items'=>array(
                                    array('label'=>'Aluno', 'url'=>array('/aluno/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Banco', 'url'=>array('/banco/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Conta', 'url'=>array('/conta/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Forma Pgto', 'url'=>array('/formapgto/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Modalidades', 'url'=>array('/modalidade/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Tipo Aluno', 'url'=>array('/tipoaluno/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Tipo Contato', 'url'=>array('/tipocontato/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Turma', 'url'=>array('/turma/index'), 'visible'=>!Yii::app()->user->isGuest),
                                )),
                                array('label'=>'Contas', 'items'=>array(
                                    array('label'=>'Pagamentos Alunos', 'url'=>array('/pagamento/index'), 'visible'=>!Yii::app()->user->isGuest),
                                    array('label'=>'Contas a Pagar', 'url'=>array('/pagamento/contaspagar'), 'visible'=>!Yii::app()->user->isGuest),
                                )),
                                array('label'=>'Consulta', 'items'=>array(
                                    array('label'=>'Contas Pagar/Receber', 'url'=>array('/pagamento/consulta'), 'visible'=>!Yii::app()->user->isGuest),
                                )),
                                array('label'=>'Frequência', 'url'=>array('/turmafrequencia/index'), 'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Usuários', 'url'=>array('/usuario/index'), 'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
							),
						),
					),
				)
			); ?>
			<div class="span11" style="margin: 0;">
				<?php echo $content; ?>
			</div>

			<div class="row-fluid">
				<div class="span11" style="margin: 0;">
					<footer class="footer">
						<div class="container">
					        <p class="copy">
								Copyright &copy; <?php echo date('Y'); ?> by Vinícius Bertoldi.<br/>
								All Rights Reserved.<br/>
								<?php echo Yii::powered(); ?>
							</p>
						</div>
					</footer>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
