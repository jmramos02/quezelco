<?php
namespace Quezelco\Interfaces;
interface AccountRepository{
	public function all();
	public function search($searchKey);
	public function addAccountToConsumer($user, $inputs);
	public function updateReading($consumer, $inputs);
	public function paginate();
	public function updateAccount($account, $inputs);
	public function changeStatus($account);
	public function findAccountsByUser($user);
	public function findByOebr($oebr);
}