<?php
require_once(SG_MAIL_PATH.'SGMail.php');

class SGBackupMailNotification
{
    public static function sendBackupNotification($status, $vars = array())
    {
        if (!self::notificationsEnabled())
        {
            return true;
        }

        SGBackupLog::write('Sending mail notification');

        $mail = SGMail::create();

        $subject = '';

        if ($status == SG_ACTION_STATUS_FINISHED) {
            $subject = SG_MAIL_BACKUP_SUCCESS_SUBJECT;
        }
        elseif ($status == SG_ACTION_STATUS_FINISHED_WARNINGS) {
            $subject = SG_MAIL_BACKUP_COMPLETED_WITH_WARNINGS_SUBJECT;
        }
        elseif ($status == SG_ACTION_STATUS_ERROR) {
            $subject = SG_MAIL_BACKUP_FAIL_SUBJECT;
        }
        else {
            $subject = SG_MAIL_BACKUP_CANCELED_SUBJECT;
        }

        $mail->setSubject($subject);

        $mail->setTemplate(SG_MAIL_BACKUP_TEMPLATE);
        $mail->setTemplateVariables($vars);
        $mail->setFrom(SGConfig::get('SG_NOTIFICATIONS_EMAIL_ADDRESS'));
        $mail->setTo(SGConfig::get('SG_NOTIFICATIONS_EMAIL_ADDRESS'));
        return $mail->send();
    }

    public static function sendRestoreNotification($succeeded = true, $vars = array())
    {
        if (!self::notificationsEnabled())
        {
            return true;
        }

        SGBackupLog::write('Sending mail notification');

        $mail = SGMail::create();

        $subject = $succeeded?SG_MAIL_RESTORE_SUCCESS_SUBJECT:SG_MAIL_RESTORE_FAIL_SUBJECT;
        $mail->setSubject($subject);

        $vars['succeeded'] = $succeeded;
        $mail->setTemplate(SG_MAIL_RESTORE_TEMPLATE);
        $mail->setTemplateVariables($vars);
        $mail->setFrom(SGConfig::get('SG_NOTIFICATIONS_EMAIL_ADDRESS'));
        $mail->setTo(SGConfig::get('SG_NOTIFICATIONS_EMAIL_ADDRESS'));
        return $mail->send();
    }

    private static function notificationsEnabled()
    {
        return SGConfig::get('SG_NOTIFICATIONS_ENABLED')?true:false;
    }
}
