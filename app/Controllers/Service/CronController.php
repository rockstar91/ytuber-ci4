<?php


class CronController extends \CodeIgniter\Controller
{
    /* Освобождение комментов, которые были открыты, но не выполнены в течении 3 мин */
    public function commentsRelease()
    {
        $this->db->where('status', COMMENT_OPEN);
        $this->db->where('time <', 'timestamp(DATE_SUB(NOW(), INTERVAL 3 MINUTE))', false);
        $this->db->set('status', COMMENT_FREE);
        $this->db->update('comment');
    }

    /* Сброс лимита выполнений за час */
    public function hourCompleteReset()
    {
        $this->db->where('hour_done >', 0);
        $this->db->set('hour_done', 0);
        $this->db->update('task');
    }

    /* Сброс лимита выполнений за сутки */
    public function userDayCompleteReset()
    {
        $this->db->set('done_day', 0)
            ->set('daily_bonus_received', 0)
            ->update('user');
    }
}