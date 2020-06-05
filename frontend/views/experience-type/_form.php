<?php


use kartik\file\FileInput;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ExperienceType */
/* @var $form yii\widgets\ActiveForm */

$dispOptions = ['class' => 'form-control kv-monospace'];

$saveCont = ['class' => 'kv-saved-cont'];

$this->title = 'Experience';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container form-design">
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'experience-form']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'images[]')->widget(FileInput::classname(), [
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'showUpload' => false,
        ]
    ]);?>

    <?= $form->field($model, 'maps')->textInput(['maxlength' => true]) ?>
    <div class="container">
        <div id='map'></div>
    </div>

    <?= $form->field($model, 'price')->widget(NumberControl::classname(), [
        'name' => 'amount_german',
        'value' => 78263232.01,
        'maskedInputOptions' => [
            'prefix' => '€ ',
            'groupSeparator' => '.',
            'radixPoint' => ','
        ],
        'displayOptions' => $dispOptions,
        'saveInputContainer' => $saveCont
    ]);?>



    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",

            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

    <?= $form->field($model, 'start_time')->widget(\janisto\timepicker\TimePicker::className(), [
        //'language' => 'fi',
        'mode' => 'time',
        'clientOptions'=>[
            'hour' => date('H'),
            'minute' => date('i'),
            'second' => date('s'),
        ]
    ]);?>

    <?= $form->field($model, 'end_time')->widget(\janisto\timepicker\TimePicker::className(), [
        //'language' => 'fi',
        'mode' => 'time',
        'clientOptions'=>[
            'hour' => date('H'),
            'minute' => date('i'),
            'second' => date('s'),
        ]
    ]);?>

    <?= $form->field($model, 'id_meal')->widget(Select2::classname(), [
        'data' => $listDataMeal,
        'language' => 'en',
        'options' => ['placeholder' => 'Select a meal ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>


    <?= $form->field($model, 'id_chef')->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'id_countries')->widget(Select2::classname(), [
        'data' => $listDataCountry,
        'language' => 'en',
        'options' => ['placeholder' => 'Select a country ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn input-button btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYXNkMTIzMTIzIiwiYSI6ImNqcDQ1bWxreDBuNm0za3BoNG1seXRwdnEifQ.KgPiDF5HvCvor_YCA0t-jQ';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v9',
        center: [-79.4512, 43.6568],
        zoom: 13
    });

    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken
    });

    map.addControl(geocoder);

    // After the map style has loaded on the page, add a source layer and default
    // styling for a single point.
    map.on('load', function() {
        map.addSource('single-point', {
            "type": "geojson",
            "data": {
                "type": "FeatureCollection",
                "features": []
            }
        });

        map.addLayer({
            "id": "point",
            "source": "single-point",
            "type": "circle",
            "paint": {
                "circle-radius": 10,
                "circle-color": "#007cbf"
            }
        });

        // Listen for the `result` event from the MapboxGeocoder that is triggered when a user
        // makes a selection and add a symbol that matches the result.
        geocoder.on('result', function(ev) {
            map.getSource('single-point').setData(ev.result.geometry);
            document.getElementById('experiencetype-maps').value = ev.result['geometry']['coordinates'].toString();


        });
    });



</script>

