<?php
    require_once(dirname(__FILE__).'/../boot.php');

    $connectionMethodSelectElemenets = array(
        'ftp' => 'FTP',
        'sftp' => 'SFTP'
    );
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?php _t('FTP settings')?></h4>
        </div>
        <form class="form-horizontal" data-sgform="ajax" data-type="storeFtpSettings">
            <div class="modal-body sg-modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="sg-connection-method"><?php echo _t('Type *')?></label>
                        <div class="col-md-8">
                            <?php echo selectElement($connectionMethodSelectElemenets, array('id'=>'sg-connection-method', 'name'=>'connectionMethod', 'class'=>'form-control'));?>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpHost"><?php echo _t('Host *')?></label>
                        <div class="col-md-8">
                            <input id="ftpHost" name="ftpHost" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpUser"><?php echo _t('User *')?></label>
                        <div class="col-md-8">
                            <input id="ftpUser" name="ftpUser" type="text" class="form-control input-md">
                        </div>
                    </div>

                    <div id="sg-sftp-key-file-block">
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo _t('Key authentication')?></label>
                            <div class="col-md-8">
                                <input type="checkbox" id='sg-connect-with-key-file' name='sg-connect-with-key-file' value="1">
                            </div>
                        </div>

                        <div class="form-group" id="sg-browse-key-file-block">
                            <label class="col-md-3 control-label"><?php echo _t('Private key *')?></label>
                            <div class="col-md-5">
                                <input type="text" id="sg-key-file" name="sg-key-file" class="form-control input-md">
                            </div>
                            <div class="col-md-3">
                                <button id="sg-choose-key-file" class="pull-right btn btn-primary" type="button"><?php echo _t('Browse')?></button>
                            </div>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpPass"><?php echo _t('Password *')?></label>
                        <div class="col-md-8">
                            <input id="ftpPass" name="ftpPass" type="text" class="form-control input-md">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="ftpPort"><?php echo _t('Port *')?></label>
                        <div class="col-md-8">
                            <input id="ftpPort" name="ftpPort" type="text" class="form-control input-md" value="21">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group sg-only-ftp-settings">
                        <label class="col-md-3 control-label" for="ftpRoot"><?php echo _t('Root directory *')?></label>
                        <div class="col-md-8">
                            <input id="ftpRoot" name="ftpRoot" type="text" class="form-control input-md" value="/">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sgBackup.storeFtpSettings()"><?php echo _t('Save')?></button>
            </div>
        </form>
    </div>
</div>
