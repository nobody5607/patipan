<?php
  cpn\chanpan\assets\jzoom\JZoomAsset::register($this); 
  use yii\helpers\Url;
  use yii\helpers\Html;
  
  
  echo \meysampg\formbuilder\FormBuilder::widget([
    'data' => [
        [
            "type" => "header",
            "subtype" => "h1",
            "label" => "Header",
            "class" => "header",
        ],
        [
            "type" => "button",
            "label" => "Button",
            "subtype" => "button",
            "class" => "button-input btn btn-warning",
            "name" => "button-1475845417456",
            "style" => "warning",
        ],
    ],
]);  


   cpn\chanpan\widgets\JZoom::widget([
       
      'src'=> Url::to('@web/img/bg1.jpg'),
      'options'=>[
          'class'=>'img img-responsive',
          'id'=>'xxx',
          'width'=>'500',
          'height'=>'300',
          'type'=>'lens',
          'lensSize'=>500,
          'scrollZoom'=>true
      ]
  ]);
    
  
?>
<br /><hr />
<div class="row">
    <div class="col-md-10">
        <?php 
         cpn\chanpan\widgets\JHtmlEditor::widget([
            'isUploadImage'=>true,
            'isFullPlugin'=>true,
            'height'=>100,
            'setting'=>[
                'minHeight' => 100,
            ]
        ]);
            ?>
        <div class="col-md-1 text-right">
            <?= Yii::t('chanpan', 'Like') ?>
        </div>
        <div class="col-md-5 sdbox-col">
            <select id="rating_star">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="col-md-6 sdbox-col">
            <div class="text-right">
                <?= Html::submitButton('<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('ezmodule', 'Post'), ['class' => 'btn btn-success btn-sm']) ?>
            </div>
        </div>
    </div>
</div>


<?php $this->registerJs("
    $('#rating_star').barrating({
        theme: 'bootstrap-stars',
        readonly:false,
         allowEmpty:true, 
         emptyValue:0,
    });
    $('#rating_star').change(function(){        
        saveRating(parseInt($(this).val()));
    });
    function saveRating(star) {
        alert(star);
    }
");
?>
<div class="row">
    <div class="col-md-12">
        <?php 
        echo \cpn\chanpan\widgets\JLightBox::widget([
            'options'=>['class'=>'col-md-6'],
            'image'=>[
                ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image1', 'options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image2','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image3','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image1', 'options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image2','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image3','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image1', 'options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image2','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image3','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image1', 'options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image2','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
                ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image3','options'=>['class'=>'col-md-3', 'style'=>'padding:1px']],
            ]    
        ]);
        
        echo cpn\chanpan\widgets\JSlide::widget([
                'image'=>[
                  ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image1'],
                  ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image2'],
                  ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image3'],
                  ['src'=>Url::to('@web/img/bg4.jpg'), 'content'=>'image4'],
                  ['src'=>Url::to('@web/img/bg5.jpg'), 'content'=>'image5'],
                  ['src'=>Url::to('@web/img/bg6.jpg'), 'content'=>'image6'],
                  ['src'=>Url::to('@web/img/bg7.jpg'), 'content'=>'image7'],
                  ['src'=>Url::to('@web/img/bg8.jpg'), 'content'=>'image8'],
                  ['src'=>Url::to('@web/img/bg9.jpg'), 'content'=>'image9'],
                  ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image10'],
                  ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image11'],
                  ['src'=>Url::to('@web/img/bg3.jpg'), 'content'=>'image12'],
                  ['src'=>Url::to('@web/img/bg4.jpg'), 'content'=>'image13'],
                  ['src'=>Url::to('@web/img/bg5.jpg'), 'content'=>'image14'],
                  ['src'=>Url::to('@web/img/bg6.jpg'), 'content'=>'image15'],
                  ['src'=>Url::to('@web/img/bg7.jpg'), 'content'=>'image16'],
                  ['src'=>Url::to('@web/img/bg8.jpg'), 'content'=>'image17'],
                  ['src'=>Url::to('@web/img/bg9.jpg'), 'content'=>'image18'],
                  ['src'=>Url::to('@web/img/bg1.jpg'), 'content'=>'image19'],
                  ['src'=>Url::to('@web/img/bg2.jpg'), 'content'=>'image20']  
                ],
            ])
        ?>
    </div>
</div>