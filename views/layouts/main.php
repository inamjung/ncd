<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    
                    ['label' => 'รายงานDM',
                        'items' => [
                            ['label' => 'DM คัดกรองอายุ35ปีขึ้นไป', 'url' => ['/dm/dmscreen']],
                            ['label' => 'DM DM ได้รับการตรวจ HbA1C', 'url' => ['/dm/dmhba1c']],
                            ['label' => 'DM ได้รับการตรวจ Lipid profile', 'url' => ['/dm/dmlipid']],
                            ['label' => 'DM ได้รับการตรวจ Microalbumin', 'url' => ['/dm/dmmicroal']],
                            ['label' => 'DM ตรวจตา', 'url' => ['/dm/dmeye']],
                            ['label' => 'DM ตรวจเท้า', 'url' => ['/dm/dmfoot']],
                            ['label' => 'DM ที่ควบคุมได้2ครั้งสุดท้าย', 'url' => ['/dm/dmcontrol']],
                            ['label' => 'DM พบภาวะแทรกซ้อนความดัน', 'url' => ['/dm/dmht']],
                            ['label' => 'DM พบภาวะแทรกซ้อนทางไต', 'url' => ['/dm/dmkidney']],
                            ['label' => 'DM พบภาวะแทรกซ้อน หลอดเลือดสมอง', 'url' => ['/dm/dmstroke']],
                            ['label' => 'DM พบภาวะแทรกซ้อน หัวใจและหลอดเลือด', 'url' => ['/dm/dmheart']],
                            ['label' => 'DM ขึ้นทะเบียน', 'url' => ['/dm/dmpatient']],
                            ['label' => 'DM รับบริการที่สถานบริการ', 'url' => ['/dm/dmpatientvisit']]
                            

                        ]
                    ],
                    ['label' => 'รายงานHT',
                        'items' => [
                            ['label' => 'report1', 'url' => ['/ht/admin']],
                            ['label' => 'report2', 'url' => ['/ht/create']],

                        ]
                    ],
                    
                    
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
