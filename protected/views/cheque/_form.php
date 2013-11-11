    <div class="clearfix">
        <div class="span3">
            <?php echo $form->dropdownListRow($model,'idBanco',$bancos,array('class'=>'span12', 'prompt'=>'Selecione')); ?>
        </div>
        <div class="span6">
            <?php echo $form->textFieldRow($model,'nome',array('class'=>'span12','maxlength'=>100)); ?>
        </div>
    </div>
    <div class="clearfix">
        <div class="span2">
            <?php echo $form->textFieldRow($model,'ag',array('class'=>'span12','maxlength'=>6)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model,'conta',array('class'=>'span12','maxlength'=>15)); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model,'numero',array('class'=>'span12')); ?>
        </div>
    </div>

