<?php
 cpn\chanpan\assets\highcharts\HighchartsAsset::register($this);
?>

<div class="modal-content">
    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
</div>
<div class="modal-footer">
    <a  data-dismiss="modal" class="btn btn-danger"><?= Yii::t('appmenu','Close')?></a>
</div>
<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    function initData(){
        let url = '<?= \yii\helpers\Url::to(['//user/admin/data'])?>';
        $.get(url, function(data){
           console.log(data);
           renderHighcharts(data);
        });
        return false;
    }
    function renderHighcharts(data){
       Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Preview User Login'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series:[data] 
    }); 
    }
    initData();
    
    

</script>
<?php \richardfan\widget\JSRegister::end(); ?>