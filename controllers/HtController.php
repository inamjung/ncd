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

    public function actionHtscreen() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,SUM(target)as target 
                ,SUM(result) as result,SUM(normal)as normal
                ,SUM(risk) as risk,SUM(riskhigh) as riskhigh
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen
                GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtscreen($cup = null) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result,SUM(normal)as normal
                ,FORMAT(SUM(risk),0) as risk,FORMAT(SUM(riskhigh),0) as riskhigh
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen
            WHERE cup='$cup'
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
        ]);
    }
    
     public function actionHtcreatinin() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
           SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_screen
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtcreatinin($cup = null) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_screen
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtlipid() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
           SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            ,SUM(hdl) as hdl,SUM(hdl_r) as hdl_r
            ,SUM(ldl) as ldl,SUM(ldl_r) as ldl_r
            ,SUM(chol) as chol,SUM(chol_r) as chol_r
            ,SUM(tg) as tg,SUM(tg_r) as tg_r
            FROM ht_lipid
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtlipid($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                ,FORMAT(SUM(hdl),0) as hdl,FORMAT(SUM(hdl_r),0) as hdl_r
                ,FORMAT(SUM(ldl),0) as ldl,FORMAT(SUM(ldl_r),0) as ldl_r
                ,FORMAT(SUM(chol),0) as chol,FORMAT(SUM(chol_r),0) as chol_r
                ,FORMAT(SUM(tg),0) as tg,FORMAT(SUM(tg_r),0) as tg_r
                FROM ht_lipid
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtfbs() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
           SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            ,SUM(r1) as r1,SUM(r2) as r2
            ,SUM(r3) as r3
            FROM ht_fbs
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtfbs($cup = null) {

        $sql = "SELECT distcode, cup,hospname ,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                ,FORMAT(SUM(r1),0) as r1,FORMAT(SUM(r2),0) as r2
                ,FORMAT(SUM(r3),0) as r3
                FROM ht_fbs
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtcontrol() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target)as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_control
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtcontrol($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_control
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtdm() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_dm
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtdm($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_dm
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtstroke() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_stroke
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtstroke($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_stroke
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtheart() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_heart
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtheart($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_heart
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtkidney() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_kidney
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtkidney($cup = null) {

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
        ]);
    }
    
    public function actionHtpreht() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
          SELECT distcode, cup ,SUM(target) as target 
            ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM ht_preht
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivhtpreht($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM ht_preht
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtpatient() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
         SELECT distcode, cup ,SUM(total) as total
            FROM ht_patient
            GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'total' => $total
        ]);
    }

    public function actionIndivhtpatient($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total 
                FROM ht_patient
                WHERE cup='$cup'
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
        ]);
    }
    
    public function actionHtpatientvisit() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
       SELECT distcode, cup ,SUM(total) as total
        ,SUM(visit) as visit
        ,SUM(visit_all)as visit_all
        FROM ht_patient_visit
        GROUP BY cup
                        ')->queryAll();
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
                    'cup' => $cup, 'total' => $total,'visit_all'=>$visit_all,'visit'=>$visit
        ]);
    }

    public function actionIndivhtpatientvisit($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total
                ,FORMAT(SUM(visit),0)as visit
                ,FORMAT(SUM(visit_all),0)as visit_all
                FROM ht_patient_visit
                WHERE cup='$cup'
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
        ]);
    }

}