<?php
$this->title = 'รายงานตัวชี้วัด KPI ข้อมูลสุขภาพ'.$year;
$this->params['breadcrumbs'][] = $this->title;

use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use kartik\date\DatePicker;
use app\models\amphur;
use kartik\dropdown\DropdownX;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
//use kartik\dropdown\DropdownX;
?>
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i>เลือกรายงาน Kpi </h3>
            </div>
            <div class="panel-body">
               
                <?= Html::beginForm();?>
                <div class="col-sm-3 col-md-3">
                    <label for="">วันที่เริ่มต้น</label><?php
                    echo DatePicker::widget([
                        'name' => 'date',
                        'id' => 'date',
                        'value' => date("Y-m-d"),
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]]);?> <br/>
                    <label for="">เลือกตัวชี้วัด</label>
                    <?= Html::dropDownList('year',null,['2558'=>'2558','2557'=>'2557','2559'=>'2559','2560'=>'2560','2561'=>'2561'],['class'=>'form-control']);?>
                    <label for="">เลือกจังหวัด</label>
                    <?= Html::dropDownList('year',null,['2558'=>'2558','2557'=>'2557','2559'=>'2559','2560'=>'2560','2561'=>'2561'],['class'=>'form-control']);?>

                    </div>
                    <div class="col-sm-3 col-md-3">
                        <label for="">วันที่สิ้นสุด</label><?php
                    echo DatePicker::widget([
                        'name' => 'date1',
                        'id' => 'date1',
                        'value' => date("Y-m-d"),
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]]);?> <br/>
                        <br/>
                        <br/>
                        <br/>
                        <label for="">เลือกอำเภอ</label>
                        <?= Html::dropDownList('year',null,['2558'=>'2558','2557'=>'2557','2559'=>'2559','2560'=>'2560','2561'=>'2561'],['class'=>'form-control']);?>





       </div>
                <div class="col-sm-3 col-md-3">
                    <br/>

                <?= Html::submitButton('ค้นหา',['class'=>'btn btn-info']);?></div>
                <?= Html::endForm();?>
           
            </div>
        </div>
     </div>
    <div class="col-md-12">
         <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-align-center"></i>  ข้อมูลกราฟ</h3>
            </div>
            <div class="panel-body">
        <?php
 if(empty($arraytype_from['-Screening-'])){
     
              $arraytype_from['-Screening-']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
              if(empty($arraytype_from['KPI_57'])){
     
              $arraytype_from['KPI_57']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
              if(empty($arraytype_from['Scope'])){
     
             $arraytype_from['Scope']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
              if(empty($arraytype_from['ScreeningReport'])){
     
              $arraytype_from['ScreeningReport']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
              if(empty($arraytype_from['Tiger-LC'])){
     
              $arraytype_from['Tiger-LC']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
              if(empty($arraytype_from['tomor_board'])){
     
              $arraytype_from['tomor_board']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
        if(empty($arraytype_from['ClinicCaDay'])){

            $arraytype_from['ClinicCaDay']=[0,0,0,0,0,0,0,0,0,0,0,0,];}
//print_r($arraytype_from['-Screening-']);
        echo Highcharts::widget(
                [
                    'options' => [
                        'title' => ['text' => 'จำนวนผู้ป่วยที่บันทึก รายปี '.$year],
                        'xAxis' => [
                            [

'categories' => $mm
                          //  'categories' => $mount
                            ],
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'จำนวน(คน)']
                        ],
                        'series' => [

                            //'type' => 'column',
                            [ 'type' => 'column',
                                'name' => 'KPI_57',
                               'data' => $arraytype_from['KPI_57']
                            ],
                            [  'type' => 'column',
                                'name' => 'Scope',
                                'data' => $arraytype_from['Scope']
                            ],
                            [  'type' => 'column',
                                'name' => 'ScreeningReport',
                               'data' => $arraytype_from['ScreeningReport']
                            ],
                            [  'type' => 'column',
                                'name' => 'Tiger-LC',
                               'data' => $arraytype_from['Tiger-LC']
                            ],
                            [  'type' => 'column',
                                'name' => 'tomor_board',
                                'data' => $arraytype_from['tomor_board']
                            ],
                            
                                 [ 'type' => 'column',
                                     'name' => '-Screening-',
                               
                                'data' =>$arraytype_from['-Screening-'],
                     
                            ],
                            [ 'type' => 'column',
                                'name' => 'ClinicCaDay',

                                'data' =>$arraytype_from['ClinicCaDay'],

                            ],

                        ]

                    ]
                ]
        );
        ?>
                   </div>
                </div>
    </div>

    <div class="col-md-12">
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> สรุปข้อมูลการบันทึกข้อมูล รายปี </h3>',
        'type' => 'success',
        //'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> โหลดข้อมูลใหม่', ['/report/report/report_key_y'], ['class' => 'btn btn-info']),
        'footer' => false
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'ปี',
            'attribute' => 'yy'
        ],
        [
            'label' => 'เดือน',
            'attribute' => 'mm2'
        ],
        [
            'label' => 'จำนวนผู้ป่วยที่บันทึก',
            'attribute' => 'cnt555'
        ],
        [
            'label' => 'ผู้ที่บันทึกข้อมูล',
            'attribute' => 'user_key'
        ],
        [
            'label' => 'ประเภทข้อมูล',
            'attribute' => 'type_from'
        ],
    ]
]);
?>

    </div>
</div>
