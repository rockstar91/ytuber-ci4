<?php namespace App\Models;

class AccountGoogleYoutubeModel extends AccountBaseModel
{
    protected $table = 'accounts_google_youtube';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\AccountGoogleYoutube';
    protected $protectFields = false;
}