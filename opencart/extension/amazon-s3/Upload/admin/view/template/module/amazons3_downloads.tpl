<table class="table table-bordered">
    <thead>
        <tr>
            <td class="text-left"><?php echo $filename_text ?></td>
            <td class="text-left"><?php echo $name_text ?></td>
            <td class="text-center"><?php echo $status_text ?></td>
            <td class="text-center">
                <input type="checkbox" onclick="$('input[name*=\'files\']').prop('checked', this.checked);" />
            </td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($downloads)) { ?>
            <?php foreach ($downloads as $download) { ?>
                <tr>
                    <td class="text-left"><?php echo $download['filename'] ?></td>
                    <td class="text-left"><?php echo $download['name'] ?></td>
                    <td class="text-center download-status"></td>
                    <td class="text-center">
                        <input type="checkbox" name="files[]" value="<?php echo $download['filename'] ?>" />
                    </td>
                </tr>
            <?php } ?>
                <tr>
                    <td colspan="4"><a style="float: right;" id="upload" data-toggle="tooltip" title="<?php echo $upload_selected_text; ?>" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></a></td>
                </tr>
        <?php } else { ?>
            <tr>
                <td colspan="4" class="right" style="text-align: center"><?php echo $no_downloads_text ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    $('#upload').click(function() {
        var downloads = $('input[name="files[]"]:checked');
        $('.loading').remove();

        $.each(downloads, function(i, val) {
            var downloadsStatus = $(val).parent().siblings('.download-status');

            downloadsStatus.html('<i class="fa fa-circle-o-notch fa-spin"></i>');

            $.ajax({
                url: 'index.php?route=module/amazons3/uploadFile&token=<?php echo $token; ?>',
                dataType: 'json',
                data: {
                    file: $(val).val()
                },
                success: function(data) {
                    if (data.status == 'success') {
                        downloadsStatus.html('<i class="fa fa-check-circle"></i>');
                        downloadsStatus.siblings('.checkbox').children('input').removeAttr('checked');
                    } else {
                        downloadsStatus.html('<i class="fa fa-exclamation-circle"></i>');
                    }
                }
            });
        });
    });
</script>