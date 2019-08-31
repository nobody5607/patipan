<div id="scroll-bar" style="height: 500px;width:500px; "> 
<?php for($i=1; $i<100; $i++):?>
<div>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam rhoncus, felis interdum condimentum consectetur, nisl libero elementum eros, vehicula congue lacus eros non diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus mauris lorem, lacinia id tempus non, imperdiet et leo. Cras sit amet erat sit amet lacus egestas placerat. Aenean ultricies ultrices mauris ac congue
</div>

<?php endfor;?> 
</div>    
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $("#scroll-bar").niceScroll({        
        cursorcolor:"#949b99",
        cursorwidth:"7px",
        cursorborder: "1px solid #949b99", // css definition for cursor border
        cursorborderradius: "5px",
        railpadding: { top: 2, right: 0, left: 0, bottom: 0 },         
        autohidemode:true,         
    });

</script>
<?php \richardfan\widget\JSRegister::end();?>