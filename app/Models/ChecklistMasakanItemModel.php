<?php

namespace App\Models;

use CodeIgniter\Model;

class ChecklistMasakanItemModel extends Model
{
    protected $table            = 'checklist_masakan_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'checklist_masakan_id', 'nama_masakan', 'gramasi_standar', 'gramasi_real', 'rasa', 'tekstur', 'keterangan'
    ];
}
