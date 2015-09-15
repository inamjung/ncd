
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
$gridColumns = [
    ['class'=>'kartik\grid\SerialColumn'], 
        
       [
            'label'=>'เครือข่ายบริการ(CUP)',
            'attribute'=>'cup',
            'format'=>'raw',
            'value'=> function($model){
                return Html::a(Html::encode($model['cup']),[
                    'dm/indivdmstroke/',
                    'cup'=>$model['cup']
                ]) ;
            }            
        ],         
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'target',
            'label'=>'เป้าหมาย(คน)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'ผลงาน (คน)',
            'attribute' => 'result',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'label'=>'ร้อยละ ',
            'attribute'=>'total',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
      ];           
            echo GridView::widget([
            'dataProvider' => $dataProvider,
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
            'columns' => $gridColumns,
            'responsive' => true,
            'hover' => true,
            'floatHeader' => FALSE,        
            'showPageSummary' => true,
            'panel' => [           
                'type' => GridView::TYPE_SUCCESS,
                'heading' => 'DM พบภาวะแทรกซ้อน หลอดเลือดสมอง ปี 2558',

                        ],
                    ]);
            ?>
<?php Pjax::end();?> 

<?php echo Highcharts::widget([
    'options'=>[        
        'title'=>['text'=>'DM พบภาวะแทรกซ้อน หลอดเลือดสมอง ปี 2558'],
        'xAxis'=>[
            'categories'=>$cup
        ],
        'yAxis'=>[
            'title'=>['text'=>'จำนวน(คน)']
        ],
        'series'=>[
            [
                'type'=>'column',
                'name'=>'เป้าหมาย',
                'data'=>$target,
            ],
            [
                'type'=>'column',
                'name'=>'ผลงาน',
                'data'=>$result,
            ],
            [
                'type'=>'column',
                'color'=>'red',
                'name'=>'ร้อยละ',
                'data'=>$total,
            ],
           
            
        ]
    ]
]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




