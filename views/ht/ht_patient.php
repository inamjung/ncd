
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
<div class="alert alert-success" role="alert">    
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
        'heading'=>'HT ขึ้นทะเบียน ปี 2558',
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
                    'ht/indivhtpatient/',
                    'cup'=>$model['cup']
                ]) ;
            }            
        ],        
        
        [
            'label'=>'จำนวน(คน) ',
            'attribute'=>'total',
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
        'title'=>['text'=>'HT ขึ้นทะเบียน ปี 2558'],
        'xAxis'=>[
            'categories'=>$cup
        ],
        'yAxis'=>[
            'title'=>['text'=>'จำนวน(คน)']
        ],
        'series'=>[         
            [
                'type'=>'column',                
                'name'=>'จำนวน(คน)',
                'data'=>$total,
            ],
           
            
        ]
    ]
]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>



