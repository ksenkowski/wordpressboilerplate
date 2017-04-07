<?php
require_once(SG_SCHEDULE_PATH.'SGIScheduleAdapter.php');

class SGScheduleAdapterWordpress implements SGIScheduleAdapter
{
    public static function getTmpTime($hours)
    {
        return strtotime('Today '.sprintf("%02d:00", $hours));
    }

    public static function getCronExecutionData($cron)
    {
        $crontab = self::parseCronTab($cron);
        $recurrence = '';

        $selectedTime = sprintf("%02d:00", $crontab['hours']);

        if($crontab['dayOfMonth']>-1 && $crontab['months']>-1) {
            $recurrence = 'yearly';
            $time = strtotime('Next year '.$selectedTime);
        }
        else if($crontab['dayOfMonth']>-1) {
            $recurrence = 'monthly';
            $dayOfInterval = $crontab['dayOfInterval'];
            $today = (int)date('d');

            if ($today < $dayOfInterval) {
                $time = self::getTmpTime($crontab['hours']);
                $time += ($dayOfInterval - $today)*SG_ONE_DAY_IN_SECONDS;
            }
            else {
                $tmpTime = self::getTmpTime($crontab['hours']);
                if ($tmpTime > time() && $today == $dayOfInterval) {
                    $time = $tmpTime;
                }
                else {
                    $time = strtotime('first day of next month '.$selectedTime);
                    $time += ($dayOfInterval-1)*SG_ONE_DAY_IN_SECONDS;
                }
            }
        }
        else if($crontab['dayOfWeek']>-1) {
            $recurrence = 'weekly';
            $dayOfInterval = $crontab['dayOfInterval'];

            switch ($dayOfInterval) {
                case 1:
                    $dayOfInterval = 'Monday';
                    break;
                case 2:
                    $dayOfInterval = 'Tuesday';
                    break;
                case 3:
                    $dayOfInterval = 'Wednesday';
                    break;
                case 4:
                    $dayOfInterval = 'Thursday';
                    break;
                case 5:
                    $dayOfInterval = 'Friday';
                    break;
                case 6:
                    $dayOfInterval = 'Saturday';
                    break;
                case 7:
                    $dayOfInterval = 'Sunday';
                    break;
                default:
                    $dayOfInterval = 'week';
                    break;
            }

            $time = strtotime('Next '.$dayOfInterval.' '.$selectedTime);
        }
        else{
            $recurrence = 'daily';
            $time = self::getTmpTime($crontab['hours']);

            if ($time < time()) {
                $time = strtotime('Next day '.$selectedTime);
            }
        }

        return array(
            'time' => $time,
            'recurrence' => $recurrence
        );
    }

    public static function create($cron, $id = SG_SCHEDULER_DEFAULT_ID)
    {
        if (!self::isCronAvailable()) {
            return false;
        }

        $cronExecutionData = self::getCronExecutionData($cron);
        $time = $cronExecutionData['time'];
        $recurrence = $cronExecutionData['recurrence'];

        $args = array((int)$id);
        $res = wp_schedule_event($time, $recurrence, SG_SCHEDULE_ACTION, $args);
    }

    public static function remove($id = SG_SCHEDULER_DEFAULT_ID)
    {
        $args = array((int)$id);
        wp_clear_scheduled_hook(SG_SCHEDULE_ACTION, $args);
    }

    public static function parseCronTab($crontabLine)
    {
        $data = explode(' ', $crontabLine);

        $crontabJob['minutes'] = filter_var($data[0], FILTER_SANITIZE_NUMBER_INT);
        if($data[0] == '*')
        {
            $crontabJob['minutes'] = -1;
        }

        $crontabJob['hours'] = filter_var($data[1], FILTER_SANITIZE_NUMBER_INT);
        if($data[1] == '*')
        {
            $crontabJob['hours'] = -1;
        }

        $crontabJob['dayOfMonth'] = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);
        if($data[2] == '*')
        {
            $crontabJob['dayOfMonth'] = -1;
        }

        $crontabJob['months'] = filter_var($data[3], FILTER_SANITIZE_NUMBER_INT);
        if($data[3] == '*')
        {
            $crontabJob['months'] = -1;
        }

        $crontabJob['dayOfWeek'] = filter_var($data[4], FILTER_SANITIZE_NUMBER_INT);
        if($data[4] == '*')
        {
            $crontabJob['dayOfWeek'] = -1;
        }

        if (isset($data[5])) {
            $crontabJob['dayOfInterval'] = filter_var($data[5], FILTER_SANITIZE_NUMBER_INT);
        }
        else {
            $crontabJob['dayOfInterval'] = 0;
        }

        return $crontabJob;
    }

    public static function isCronAvailable()
    {
        return defined('DISABLE_WP_CRON')?DISABLE_WP_CRON:true;
    }
}
