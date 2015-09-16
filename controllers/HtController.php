<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

class HtController extends Controller {

    public $enableCsrfValidation = false;

    public function actionHtscreen($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target 
                ,SUM(result) as result,SUM(normal)as normal
                ,SUM(risk) as risk,SUM(riskhigh) as riskhigh
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen where byear= '$byear'
                GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_screen', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtscreen($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result,SUM(normal)as normal
                ,FORMAT(SUM(risk),0) as risk,FORMAT(SUM(riskhigh),0) as riskhigh
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_screen', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
     public function actionHtcreatinin($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
           SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_screen where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_creatinin', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target,
                'result' => $result, 'total' => $total,'byear' => $byear,       
        ]);
    }

    public function actionIndivhtcreatinin($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_creatinin', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtlipid($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
           SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            ,SUM(hdl) as hdl,SUM(hdl_r) as hdl_r
            ,SUM(ldl) as ldl,SUM(ldl_r) as ldl_r
            ,SUM(chol) as chol,SUM(chol_r) as chol_r
            ,SUM(tg) as tg,SUM(tg_r) as tg_r
            FROM ht_lipid where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_lipid', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
                'result' => $result, 'total' => $total,'byear' => $byear, 
        ]);
    }

    public function actionIndivhtlipid($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                ,FORMAT(SUM(hdl),0) as hdl,FORMAT(SUM(hdl_r),0) as hdl_r
                ,FORMAT(SUM(ldl),0) as ldl,FORMAT(SUM(ldl_r),0) as ldl_r
                ,FORMAT(SUM(chol),0) as chol,FORMAT(SUM(chol_r),0) as chol_r
                ,FORMAT(SUM(tg),0) as tg,FORMAT(SUM(tg_r),0) as tg_r
                FROM ht_lipid
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_lipid', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtfbs($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
           SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            ,SUM(r1) as r1,SUM(r2) as r2
            ,SUM(r3) as r3
            FROM ht_fbs where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_fbs', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
            'result' => $result, 'total' => $total,'byear'=>$byear,
        ]);
    }

    public function actionIndivhtfbs($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                ,FORMAT(SUM(r1),0) as r1,FORMAT(SUM(r2),0) as r2
                ,FORMAT(SUM(r3),0) as r3
                FROM ht_fbs
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_fbs', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtcontrol($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_control where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_control', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
            'result' => $result, 'total' => $total,'byear'=>$byear,
        ]);
    }

    public function actionIndivhtcontrol($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_control
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_control', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtdm($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_dm where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_dm', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
                    'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtdm($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_dm
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_dm', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtstroke($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_stroke where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_stroke', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
                    'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtstroke($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_stroke
                 WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_stroke', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtheart($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_heart where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_heart', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 
                    'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtheart($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_heart
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_heart', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtkidney($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_kidney where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_kidney', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear'=>$byear,
        ]);
    }

    public function actionIndivhtkidney($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_kidney
                WHERE cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_kidney', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionHtpreht($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_preht where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_preht', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtpreht($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_preht
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_preht', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,    
        ]);
    }
    
    public function actionHtpatient($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
         SELECT distcode, cup ,SUM(total) as total
            FROM ht_patient  where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            //$target[] = $data[$i]['target'] * 1;
            //$result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_patient', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivhtpatient($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total 
                FROM ht_patient
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_patient', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear' => $byear,
        ]);
    }
    
    public function actionHtpatientvisit($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
       SELECT distcode, cup ,SUM(total) as total
        ,SUM(visit) as visit
        ,SUM(visit_all)as visit_all
        FROM ht_patient_visit  where byear= '$byear'
        GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $visit[] = $data[$i]['visit'] * 1;
            $visit_all[] = $data[$i]['visit_all'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('ht_visit', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'total' => $total,
                'visit_all'=>$visit_all,'visit'=>$visit,'byear' => $byear,
        ]);
    }

    public function actionIndivhtpatientvisit($cup = null,$byear=null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total
                ,FORMAT(SUM(visit),0)as visit
                ,FORMAT(SUM(visit_all),0)as visit_all
                FROM ht_patient_visit
               WHERE byear='$byear' and cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivht_visit', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }

}