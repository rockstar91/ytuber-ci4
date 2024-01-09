<?php namespace App\Models;

use CodeIgniter\Model;

class AccountBaseModel extends Model
{
    protected $beforeInsert = ['insertBaseAccount'];

    protected function insertBaseAccount($eventData)
    {
        $data = &$eventData['data'];

        $accountModel  = new AccountMainModel;

        $insertData = [
            'user_id'           => $data['user_id'],
            'account_type_id'   => $data['account_type_id']
        ];

        $accountId = $accountModel->insert($insertData);

        // Удвляем поля, которых нет у основного аккаунта
        unset($data['account_id']);
        unset($data['account_type_id']);

        // Добавляем поле account_id для связи с базовым аккаунтом
        $data['account_id'] = $accountId;

        return $eventData;
    }
}
