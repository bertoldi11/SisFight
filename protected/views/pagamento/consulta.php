<div class="box-content span11">
    <fieldset>
        <legend>Consulta Pagamento</legend>
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'pagamento-form',
            'enableAjaxValidation'=>false,
            'action'=>$this->createUrl('pagamento/consulta'),
        )); ?>
            <div class="clearfix">
                <?php echo $form->errorSummary($model); ?>
                <label for="aluno">Aluno</label>
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'aluno',
                    'sourceUrl'=>$this->createUrl('/aluno/buscar'),
                    // additional javascript options for the autocomplete plugin
                    'options'=>array(
                        'select'=>'js:function( event, ui ) {
                            $("#ConsultaPagamentoForm_idAluno").val(ui.item.id);
                        }',
                        'minLength'=>'4',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;',
                        'class'=>'span4'
                    ),
                ));?>
                <input type="hidden" id="ConsultaPagamentoForm_idAluno" name="ConsultaPagamentoForm[idAluno]" autocomplete="off">
            </div>
            <div class="clearfix">
                <div class="pull-left span2">
                    <?php echo $form->datepickerRow($model,'dataInicio',array(
                            'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                            'prepend' => '<i class="icon-calendar"></i>',
                            'class'=>'span12'
                        )
                    ); ?>
                </div>
                <div class="pull-left span2">
                    <?php echo $form->datepickerRow($model,'dataFim',array(
                            'options' => array('language' => 'pt','format'=>'dd/mm/yyyy', 'changeMonth'=>true,'changeYear'=>true),
                            'prepend' => '<i class="icon-calendar"></i>',
                            'class'=>'span12'
                        )
                    ); ?>
                </div>
            </div>
            <div class="clearfix">
               <?php echo $form->checkBoxListInlineRow($model,'status', array('A'=>'Aberto','P'=>'Pago','C'=>'Cancelado'), array());?>
            </div>
            <div class="clearfix">
                <div class="form-actions">
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'primary',
                        'label'=>'Buscar',
                    )); ?>
                </div>
            </div>
        <?php $this->endWidget(); ?>
        <?php if(isset($dataProviderPagamentos)):?>
            <?php $this->widget('bootstrap.widgets.TbGridView', array(
                'type'=>'striped bordered condensed',
                'template'=>"{items}",
                'formatter'=> new Formatacao,
                'dataProvider'=>$dataProviderPagamentos,
                'columns'=>array(
                    array('name'=> 'idAlunoTurma0.idAluno0.nome', 'header'=>'Aluno'),
                    array('name'=> 'dtVencimento', 'header'=>'Vencimento','type'=>'data'),
                    array('name'=> 'dtPagamento', 'header'=>'Pagamento','type'=>'data'),
                    array('name'=> 'valorPagar', 'header'=>'Valor a Pagar'),
                    array('name'=> 'valorPago', 'header'=>'Valor Pago'),
                    array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A")? "Aberto" : (($data->status == "P") ? "Pago" : "Cancelado");'),
                    array(
                        'htmlOptions' => array('nowrap'=>'nowrap'),
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'',

                    )
                ),
            ));?>
        <?php endif;?>
    </fieldset>
</div>