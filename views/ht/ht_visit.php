
<?php
$this->title = 'HT';


use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][]=$this->title;
?>
<div class="well">    
<h3><span class="label label-success">ระบบสารสนเทศผู้ป่วยโรคความดันโลหิตสูง ปี 2558</span></h3>

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
        'heading'=>'HT รับบริการที่สถานบริการ ปี 2558',
        'before' => '',
        'type' => \kartik\grid\GridView::TYPE_PRIMARY,
       
    ],
    'columns'=>[
        ['class'=>'yii\grid\SerialColumn'],
        
       [
            'label'=>'เครือข่ายบริการ(CUP)',
            'attribute'=>'cup',
            'format'=>'raw',
            'value'=> function($model){
                return Html::a(Html::encode($model['cup']),[
                    'ht/indivhtpatientvisit/',
                    'cup'=>$model['cup']
                ]) ;
            }            
        ],        
        
        [
            'label'=>'เป้าหมาย(คน) ',
            'attribute'=>'total',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
         [
            'label'=>'รับบริการ(คน) ',
            'attribute'=>'visit',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'label'=>'รับบริการ(ครั้ง) ',
            'attribute'=>'visit_all',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],        
       ],    
]);
?>
<?php Pjax::end();?> 

<?php echo Highcharts::widget([
    'options'=>[        
        'title'=>['text'=>'HT รับบริการที่สถานบริการ ปี 2558'],
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
                'name'=>'รับบริการ(ครั้ง)',
                'data'=>$visit_all,
            ],
        ]
    ]
]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




