<?php


namespace App\Controllers\Api;


use App\Models\BonusModel;
use App\Models\CompleteModel;
use App\Models\UserModel;

class DashboardController extends BaseApiController
{
    public function test()
    {
        $bonusModel = new BonusModel($this->user->id);
        print_r($bonusModel->getData());
    }

    public function getBonus()
    {
        $bonus = 500;

        $bonusModel = new BonusModel($this->user->id);
        $userModel = new UserModel();

        //recaptcha_verify() &&
        if (true OR $bonusModel->isTargetsReach() && !$this->user->daily_bonus_received)
        {
            if ($userModel->decreaseBalance(ACCOUNT_BONUS, $bonus, false))
            {
                // перечисляем баллы
                $data = array(
                    'balance' => $bonus,
                    'daily_bonus_received' => 1,
                    'daily_bonus_count' => 1
                );
                $userModel->increase($this->user->id, $data);

                /*
                $noty = array(
                    'user_id' => $this->user->id,
                    'cost' => $bonus,
                    'type' => NOTY_DAILY_BONUS
                );

                $this->Notification->addItem($noty);
                */
            }
        }

        redirect('dashboard');
    }
}