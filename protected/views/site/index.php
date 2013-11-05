<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<style>
.grid-view {
    padding-top: 0;
}
</style>
<h1>Bem vindo ao <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Pagamentos em Aberto',
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class' => 'bootstrap-widget-table')
));?>
    <?php $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'template'=>"{items}",
        'formatter'=> new Formatacao,
        'dataProvider'=>$dataProviderAberto,
        'columns'=>array(
            array('name'=> 'idAlunoTurma0.idAluno0.nome', 'header'=>'Aluno'),
            array('name'=> 'dtVencimento', 'header'=>'Vencimento','type'=>'data'),
            array('name'=> 'valorPagar', 'header'=>'Valor a Pagar'),
            array(
                'htmlOptions' => array('nowrap'=>'nowrap'),
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template'=>'',

            )
        ),
    ));?>
<?php $this->endWidget(); ?>




