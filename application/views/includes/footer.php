
<div class="control-sidebar-bg shadow white fixed"></div>
</div>
<script src="<?= asset_url();?>js/app.js"></script>
<script src="<?= app_asset_url();?>js/jquery.validate.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    $('select').select2();
});
     


</script>
<script type="text/javascript">
	        $('.commontexteditor').summernote({
  height: 150,   //set editable area's height
  codemirror: { // codemirror options
    theme: 'monokai'
  }
});
</script>


</body>

</html>