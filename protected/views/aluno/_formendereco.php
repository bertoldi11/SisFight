<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'endereco-buscarcep-form',
    'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('/endereco/buscarcep')
)); ?>

<label for="cepBuscar">CEP:</label>
<?php
$this->widget('CMaskedTextField', array(
    'name'=>'cepBuscar',
    'mask' => '99.999-999',
    'htmlOptions' => array('maxlength' => 10, 'class'=>'span2')
));
?>
&nbsp;<button id="btnBuscarCep" class="btn btn-primary"><i class="icon-search"></i> </button>
<img src="/images/ajax-loader-circ.gif" id="loadingCep" style="display:none"/>
<?php $this->endWidget(); ?>

<?php $mostraFormEndUnico = (empty($modelAluno->idEndereco) || is_null($modelAluno->idEndereco)) ? 'style="display: none;"' : '';?>

<div id="divEnderecoUnico" <?php echo $mostraFormEndUnico;?>>

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'usuario-endereco-form',
        'enableAjaxValidation'=>false,
        'action'=>$this->createUrl('aluno/alterar', array('id'=>$modelAluno->idAluno))
    )); ?>
    <div class="clearfix">
        <label for="inputLogradouro">Logradouro</label>
        <input id="inputLogradouro" name="logradouro" readonly="true" class="span5" value="<?php if(!is_null($modelEndereco)) echo $modelEndereco->logradouro;?>" />
    </div>
    <div class="clearfix">
        <div class="pull-left" style="margin-right: 5px">
            <?php echo $form->textFieldRow($modelAluno,'endNumero',array()); ?>
        </div>
        <div class="pull-left" style="margin-right: 5px">
            <?php echo $form->textFieldRow($modelAluno,'endComplemento',array()); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="pull-left" style="margin-right: 5px">
            <label for="inputBairro">Bairro</label>
            <input id="inputBairro" name="bairro" readonly="true" value="<?php if(!is_null($modelEndereco)) echo $modelEndereco->bairro;?>" />
        </div>
        <div class="pull-left" style="margin-right: 5px">
            <label for="inputCidadeEstado">Cidade - UF</label>
            <input id="inputCidadeEstado" name="cidade" readonly="true" value="<?php if(!is_null($modelEndereco)) echo $modelEndereco->idCidade0->nome.' - '.$modelEndereco->idCidade0->idUf0->sigla;?>" />
        </div>
    </div>


    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Salvar',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<script>
    $(function(){
        $('#endereco-buscarcep-form').submit(function(e){
            e.preventDefault();
            var cep = $('#cepBuscar').val().replace(/\D/g,'');
            if(cep.length == 8)
            {
                $('#btnBuscarCep').hide();
                $('#loadingCep').show();
                $.ajax({
                    url: $(this).attr('action'),
                    dataType: 'json',
                    type: 'post',
                    data: {CEP: cep},
                }).done( function ( JSON ){
                        if(JSON.MSG){
                            alert(JSON.MSG);
                        }

                        $('#loadingCep').hide();
                        $('#btnBuscarCep').show();

                        if(JSON.providerEndereco && JSON.providerEndereco.length == 1)
                        {
                            //Preenche dados da divEndereco único
                            preencheEnderecoUnico(JSON.providerEndereco[0]);
                        }
                        else if(JSON.providerEndereco && JSON.providerEndereco.length > 1)
                        {
                            //Abre tela para usuário selecionar endereço.
                        }
                        else
                        {
                            $('#divEnderecoUnico').hide();
                        }
                    });
            }
            else
            {
                alert('Preencha o CEP corretamente.');
            }

        });
    });

    function preencheEnderecoUnico(endereco)
    {
        $('#divEnderecoUnico').show();
        $('#inputLogradouro').val(endereco.logradouro);
        $('#inputBairro').val(endereco.bairro);
        $('#inputCidadeEstado').val(endereco.cidade+"-"+endereco.uf);

        $('#usuario-endereco-form > input[name="Aluno[idEndereco]"]').remove();
        $('#usuario-endereco-form').append('<input type="hidden" name="Aluno[idEndereco]" value="'+endereco.idEndereco+'" />');
    }

</script>