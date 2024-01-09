<?php


namespace App\Models;


use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table      = 'articles';
    protected $primaryKey = 'id';
    protected $returnType = 'CodeIgniter\Entity';
}