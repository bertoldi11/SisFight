<div class="box-content span11">
    <fieldset>
        <legend>Contas a Pagar</legend>

        <?php
        $this->widget('bootstrap.widgets.TbButton',array(
                'label' => 'Nova Conta a Pagar',
                'type' => 'primary',
                'htmlOptions'=>array(
                    'onclick'=>new CJavaScriptExpression('$("#modalContaPagar").dialog("open");'),
                )
            )
        );
        ?>

        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
            'id'=>'modalContaPagar',
            // additional javascript options for the dialog plugin
            'options'=>array(
                'title'=>'Nova Conta a Pagar',
                'autoOpen'=>false,
                'modal'=> true,
                'width'=> 700,
                'buttons' => array(
                    array('text'=>'Cadastrar Conta','class'=>'btn btn-primary','click'=> 'js:function(){$("#pagamento-form").submit();}'),
                    array('text'=>'Cancelar','class'=>'btn','click'=> 'js:function(){$(this).dialog("close");}'),
                ),
            ),
        ));

            echo $this->renderPartial('_form_conta_pagar', array('model'=>$model,'modelContas'=>$modelContas,'modelFormasPgto'=>$modelFormasPgto));

        $this->endWidget('zii.widgets.jui.CJuiDialog');?>
        <hr>
        <?php $this->widget('bootstrap.widgets.TbGridView', array(
            'type'=>'striped bordered condensed',
            'template'=>"{items}",
            'dataProvider'=>$dataProviderContaAberto,
            'formatter'=>new Formatacao,
            'columns'=>array(
                array('name'=> 'idPagamento', 'header'=>'Código'),
                array('name'=> 'idConta0.nome', 'header'=>'Conta'),
                array('name'=> 'dtVencimento', 'header'=>'Vencimento', 'type'=>'data'),
                array('name'=> 'valorPagar', 'header'=>'Valor a Pagar', 'value'=>'number_format($data->valorPagar,2,",",".")'),
                array('name'=> 'status', 'header'=>'Status', 'value'=>'($data->status == "A")? "Aberto" : (($data->status == "P") ? "Pago" : "Cancelado");'),
                array(
                    'htmlOptions' => array('nowrap'=>'nowrap'),
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{pagar}',
                    'buttons'=>array(
                        'pagar'=>array(
                            'icon'=>'money',
                            'click'=>'function(event){
                                event.preventDefault();
                                var idPagamento = $(this).attr("href");
                                $.ajax({
                                    url: "'.$this->createUrl("pagamento/montaform").'",
                                    data: {idPagamento: idPagamento},
                                    type: "post",
                                    dataType: "text"
                                }).done(function(retorno){
                                    $("#divDadosPagamento").empty();
                                    $("#divDadosPagamento").append(retorno);
                                });

                                $("#modalPagarConta").dialog("open");
                            }',
                            'label'=>'Pagar Conta',
                            'visible'=>'($data->status == "A")',
                            'url'=>'$data->idPagamento'
                        ),
                    ),
                )
            ),
        )); ?>
    </fieldset>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'modalPagarConta',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=>'Pagar Conta',
            'autoOpen'=>false,
            'modal'=> true,
            'width'=> 710,
            'buttons' => array(
                array('text'=>'Pagar','class'=>'btn btn-primary','click'=> 'js:function(){$("#pagar-form").submit();}'),
                array('text'=>'Cancelar','class'=>'btn','click'=> 'js:function(){$(this).dialog("close");}'),
            ),
        ),
    ));

        echo '<div id="divDadosPagamento" class="row-fluid"></div>';

    $this->endWidget('zii.widgets.jui.CJuiDialog');?>
</div>