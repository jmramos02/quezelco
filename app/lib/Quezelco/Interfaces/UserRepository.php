<?php 
namespace Quezelco\Interfaces;
interface UserRepository {
	public function all();
	public function find($id);
	public function findByUsername($username);
	public function paginate($pages);
	public function validate($inputs);
	public function validateEdit($inputs);
	public function advanceSearch($searchKey);
	public function update($user);
	public function getManagerView($id, $location_id);
	public function getManagerViewPaginated($id, $location_id);
	public function searchManagerView($id, $location_id, $search_key);
}