<?php

namespace Quezelco\Interfaces;

interface AccountsContactRepository {
	public function all();
	public function find($id);
}