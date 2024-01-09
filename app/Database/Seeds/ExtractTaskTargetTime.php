<?php


namespace App\Database\Seeds;


use App\Models\AccountGoogleYoutubeModel;
use CodeIgniter\Database\Seeder;

class ExtractTaskTargetTime extends Seeder
{
    protected $table = 'tasks';
    protected $limit = null;

    public function run()
    {
        $selectFields = 'id, action_cost, extend, targetTime';

        $builder = $this->db->table($this->table)->select($selectFields);
        $query   = $builder->get($this->limit);


        foreach ($query->getResult() as $row)
        {
            $targetTime = 30;

            if($row->targetTime > 0) {
                $targetTime = $row->targetTime;
            }

            $extend = @unserialize($row->extend);

            if(
                $extend &&
                isset($extend['time'])
            ) {
                $targetTime = (int) $extend['time'];
            }

            $order = $row->action_cost / $targetTime;

            $this->db->query("UPDATE {$this->table} SET `targetTime` = {$targetTime}, `order` = '{$order}' WHERE id = '{$row->id}';");

        }
    }
}