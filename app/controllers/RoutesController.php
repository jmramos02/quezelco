<?php

use Quezelco\Interfaces\RoutesRepository as QRoutes;
use Quezelco\Interfaces\LocationRepository as Location;

class RoutesController extends \BaseController {


	public function __construct(QRoutes $route, Location $location){
		$this->routes = $route;
		$this->location = $location;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$search_key = '';
		$routes = $this->routes->all();
		$locations = $this->setLocationDropDown();
		return View::make('admin.routes.index', compact('routes', 'locations', 'search_key'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array('route_code'=>'required',
					   'route_name' => 'required');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('admin/routes')->withErrors($validator);
		}else{
			$this->routes->create(Input::all());
			Session::flash('message','Route Successfuly Added');
			return Redirect::to('admin/routes');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$route = $this->routes->find($id);
		$locations = $this->setLocationDropDown();
		return View::make('admin.routes.edit')->with('route',$route)->with('locations',$locations);

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$route = $this->routes->find($id);
		$rules = array('route_code' => 'required',
					   'route_name' => 'required');
		$validator = Validator::make(Input::all(),$rules);

		if($validator->fails()){
			return Redirect::to('admin/routes/'. $id . '/edit')->withErrors($validator)->withInput(Input::all());
		}else{
			$route = $this->routes->find($id);
			$route->route_code = strtoupper(Input::get('route_code'));
			$route->route_name = strtoupper(Input::get('route_name'));
			$this->routes->update($route);
			Session::flash('message','Route Successfuly Updated');
			return Redirect::to('admin/routes');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function search(){
		$search_key = Input::get('search_key');

		if($search_key == '')
		{
			$routes = $this->routes->all();
		}
		else
		{
			$routes = $this->routes->search($search_key);
		}
		$locations = $this->setLocationDropDown();
		/*return View::make('admin.routes.index')->with('routes',$routes)->with('locations',$locations);*/
		return View::make('admin.routes.index', compact('routes', 'locations', 'search_key'));
	}

	private function setLocationDropDown(){
		$locations = $this->location->all();
		$arrayLocation = array();
		foreach ($locations as $location) {
			$arrayLocation[$location->id] = $location->location_name; 
		}

		return $arrayLocation;
	}
}
