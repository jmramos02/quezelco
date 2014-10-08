<?php

namespace Quezelco\Providers;
use Illuminate\Support\ServiceProvider;

class AccountsContactServiceProvider extends ServiceProvider{

	public function register(){
		$this->app->bind('Quezelco\Interfaces\AccountsContactRepository',
						 'Quezelco\Eloquent\EloquentAccountsContactRepository');
	}
}