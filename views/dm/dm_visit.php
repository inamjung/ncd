
<?php
$this->title = 'DM';


use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][]=$this->title;
?>
<div class="alert alert-info" role="alert">     
<h3><span class="label label-info">ระบบสารสนเทศผู้ป่วยโรคเบาหวาน ปี 2558</span></h3>

</div>

<?php Pjax::begin();?> 
<?php
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'responsive' => TRUE,
    'hover' => true,
    'floatHeader' => FALSE,
    'panel' => [
        'heading'=>'DM รับบริการที่สถานบริการ ปี 2558',
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
       
    ],
    'columns'=>[
        ['class'=>'yii\grid\SerialColumn'],
        
       [
            'label'=>'เครือข่ายบริการ(CUP)',
            'attribute'=>'cup',
            'format'=>'raw',
            'value'=> function($model){
                return Html::a(Html::encode($model['cup']),[
                    'dm/indivdmpatientvisit/',
                    'cup'=>$model['cup']
                ]) ;
            }            
        ],         
        [
            'label'=>'จำนวนเป้าหมาย(คน)',
            'attribute'=>'total',
            'format'=>'integer',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'label'=>'รับบริการ(คน)',
            'attribute'=>'visit',
            'format'=>'integer',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'label'=>'รับบริการ(ครั้ง)',
            'attribute'=>'visit_all',
            'format'=>'integer',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
       ],    
]);
?>
<?php Pjax::end();?> 

<?php echo Highcharts::widget([
    'options'=>[        
        'title'=>['text'=>'DM รับบริการที่สถานบริการ ปี 2558'],
        'xAxis'=>[
            'categories'=>$cup
        ],
        'yAxis'=>[
            'title'=>['text'=>'จำนวน(คน)']
        ],
        'series'=>[
            [
                'type'=>'column',
                'name'=>'เป้าหมาย(คน)',
                'data'=>$total,
            ],
            [
                'type'=>'column',
                'name'=>'รับบริการ(คน)',
                'data'=>$visit,
            ],
            [
                'type'=>'column',
                'color'=>'red',
                'name'=>'รับบริการ(ครั้ง)',
                'data'=>$visit_all,
            ],
           
            
        ]
    ]
]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




