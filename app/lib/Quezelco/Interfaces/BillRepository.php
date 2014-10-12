<?php
namespace Quezelco\Interfaces;

interface BillRepository{
	public function find($id);
	public function updateBilling($account, $inputs);
	public function all();
	public function paginate();
	public function findNextPayment($oebr_number);
	public function findNextPaymentById($id);
}