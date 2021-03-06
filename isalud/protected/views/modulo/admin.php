<?php
/* @var $this ModuloController */
/* @var $model Modulo */

$this->breadcrumbs=array(
	$this->title_sin=>array('index'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Listar '.$this->title_plu, 'url'=>array('index')),
	array('label'=>'Crear '.$this->title_sin, 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#modulo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administraci&oacute;n de <?php echo $this->title_plu; ?></h1>

<p>
Operadores de comparaci&oacute;n soportados por el campo busqueda: <b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> o <b>=</b>
</p>

<?php echo CHtml::link('Busqueda avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $listModulos = CHtml::listData(Modulo::model()->findAll(), 'nombre', 'nombre'); ?>
<?php $listTipoUsuarios = CHtml::listData(TipoUsuario::model()->findAll(), 'nombre', 'nombre'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'modulo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_cat_tipo_usuario',
		'nombre',
		'url',
		array(
			'header'=>'Activo',
			'value'=>'($data->activo) ? "Si" : "No"',
            'filter'=>CHtml::activeDropDownList($model,'activo_search', array(1=>'Si', 0=>'No'), array('empty'=>'Seleccionar...'))
		),
		array(
			'header'=>'Padre',
			'value'=>'($data->parent!=null) ? $data->parent->nombre : null',
            'filter'=>CHtml::activeDropDownList($model,'modulo_search',$listModulos, array('empty'=>'Seleccionar...'))
		),
		array(
			'header'=>'Tipo de usuario',
			'value'=>'($data->idCatTipoUsuario!=null) ? $data->idCatTipoUsuario->nombre : null',
            'filter'=>CHtml::activeDropDownList($model,'tipousuario_search',$listTipoUsuarios, array('empty'=>'Seleccionar...'))
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
