<?php

namespace App;

use Illuminate\Pagination\LengthAwarePaginator;

trait PaginateTrait {
	public function scopeCustomPaginate($query, $per_page, $request, $filtering = false)
	{
		$class_name = get_class($this);
		// Get current page form url e.g. &page=6
		$current_page = LengthAwarePaginator::resolveCurrentPage();

		// Execute count over query to know the count of the subset after search filters
		$count = ($filtering ? $query->count() : $class_name::count());

		$resources = $query->skip(($current_page - 1) * $per_page)->limit($per_page)->get();
		
		// Create our paginator
		$resources = new LengthAwarePaginator($resources, $count, $per_page);
		$resources->setPath($request->url());
		$resources->appends($request->except(['page']));	
		return $resources;
	}
}