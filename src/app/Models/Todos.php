<?php

namespace App\Models;

use CodeIgniter\Model;

class Todos extends Model
{
	private const REGEX_FOR_INTERVAL = "/'(.*?)'/";

	protected $DBGroup              = 'default';
	protected $table                = 'todos';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'description',
		'status',
		'interval',
		'users_id',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function getAvailableIntervals(): array
	{
		$query = 'SHOW COLUMNS FROM todos LIKE "interval"';
		$result = $this->db->query($query)->getRow(0)->Type;
		preg_match_all(self::REGEX_FOR_INTERVAL, $result, $enumArray);
		$enumFields = $enumArray[1];
		return $enumFields;
	}

	public function getAllTodosOfUser(int $userId): array
	{
		return $this->where('users_id', $userId)->findAll();
	}
}
