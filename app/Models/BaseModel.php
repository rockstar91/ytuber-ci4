<?php


namespace App\Models;

use App\Traits\Models\DisplayMode;
use CodeIgniter\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    use DisplayMode;
}