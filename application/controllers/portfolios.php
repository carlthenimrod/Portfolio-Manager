<?php

class Portfolios_Controller extends Base_Controller
{

	public function action_index()
	{
		$portfolios = Portfolio::order_by('order_id', 'asc')->get();

		return View::make('portfolios.index')
			->with('portfolios', $portfolios);
	}

	public function action_new()
	{
		return View::make('portfolios.new');
	}

	public function action_create()
	{

		$input = Input::all();

		$rules = array(
			'title'  => 'required|max:1000',
			'description' => 'required|max:10000',
			'img' => 'required|image'
		);

		$messages = array(
			'img_required' => "Image must be uploaded.",
			'img_image' => "Only images can be uploaded."
		);

		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{

			return Redirect::to('portfolios/new')
				->with_errors($validation->errors);
		}
		else{

			$order_id = (count(Portfolio::all()) + 1);

			$img = $input['img'];

			$portfolio = Portfolio::create(array(
				'title' => $input['title'],
				'description' => $input['description'],
				'info' => $input['info'],
				'img' => $img['name'],
				'order_id' => $order_id
			));

			$tmp_img = $input['img']['tmp_name'];

			//getting the image dimensions
			list($width, $height) = getimagesize($tmp_img);
			 
			//saving the image into memory (for manipulation with GD Library)
			$myImage = imagecreatefromjpeg($tmp_img);
			 
			//the crop size
			$cropWidth   = 150;
			$cropHeight  = ceil((150 / $width) * $height);
			 
			//getting the top left coordinate
			$c1 = array("x"=>($width-$cropWidth) / 2, "y"=>($height-$cropHeight) / 2);

			// Creating the thumbnail
			$thumb = imagecreatetruecolor($cropWidth, $cropHeight);
			imagecopyresampled($thumb, $myImage, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $height);

			Input::upload('img', path('public').'uploads/'.$portfolio->id.'/', $img['name']);

			$thumb = imagejpeg($thumb, path('public').'uploads/'.$portfolio->id.'/thumb_'.$img['name']);

			Session::flash('success', 'Portfolio successfully created!');

			return Redirect::to('portfolios/');
		}
	}

	public function action_edit($id)
	{
		$result = Portfolio::find($id);

		if($result)
		{
			return View::make('portfolios.edit')
				->with('portfolio', $result);
		}
		else
		{
			return Redirect::to('portfolios/');
		}
	}

	public function action_update($id)
	{

		$input = Input::all();

		if($input['img']['size'] > 0){

			$rules = array(
				'title'  => 'required|max:1000',
				'description' => 'required|max:10000',
				'img' => 'required|image'
			);

			$messages = array(
				'img_required' => "Image must be uploaded.",
				'img_image' => "Only images can be uploaded."
			);
		}
		else{

			$rules = array(
				'title'  => 'required|max:1000',
				'description' => 'required|max:10000'
			);

			$messages = array(
				'img_required' => "Image must be uploaded.",
				'img_image' => "Only images can be uploaded."
			);
		}

		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{

			return Redirect::to('portfolios/'.$id.'/edit')
				->with_errors($validation->errors);
		}
		else{

			$portfolio = Portfolio::find($id);

			if($input['img']['size'] > 0){

				$img = $input['img'];
				
				$portfolio->fill(array(
					'title' => $input['title'],
					'description' => $input['description'],
					'info' => $input['info'],
					'img' => $img['name']
				));

				$tmp_img = $input['img']['tmp_name'];

				//getting the image dimensions
				list($width, $height) = getimagesize($tmp_img);
				 
				//saving the image into memory (for manipulation with GD Library)
				$myImage = imagecreatefromjpeg($tmp_img);
				 
				//the crop size
				$cropWidth   = 150;
				$cropHeight  = ceil((150 / $width) * $height);
				 
				//getting the top left coordinate
				$c1 = array("x"=>($width-$cropWidth) / 2, "y"=>($height-$cropHeight) / 2);

				// Creating the thumbnail
				$thumb = imagecreatetruecolor($cropWidth, $cropHeight);
				imagecopyresampled($thumb, $myImage, 0, 0, 0, 0, $cropWidth, $cropHeight, $width, $height);

				File::rmdir(path('public').'uploads/'.$portfolio->id.'/');

				Input::upload('img', path('public').'uploads/'.$portfolio->id.'/', $img['name']);

				$thumb = imagejpeg($thumb, path('public').'uploads/'.$portfolio->id.'/thumb_'.$img['name']);
			}	
				
			$portfolio->fill(array(
				'title' => $input['title'],
				'description' => $input['description'],
				'info' => $input['info']
			));

			$portfolio->save();

			Session::flash('success', 'Portfolio successfully updated!');

			return Redirect::to('portfolios/');
		}
	}

	public function action_update_multiple()
	{
		$portfolios = Portfolio::all();

		if(count($portfolios)){

			$count = range(1, count($portfolios));

			$order = self::set_order(Input::get('order_ids'), $count);

			foreach($order as $key => $value){

				$portfolio = Portfolio::find($value['id']);

				$portfolio->order_id = $value['order_id'];

				$portfolio->save();
			}

			Session::flash('success', 'Portfolios successfully saved!');

			return Redirect::to('portfolios/');
		}
		else{

			return Redirect::to('portfolios/');
		}
	}

	public function action_delete($id)
	{
		$result = Portfolio::find($id);

		$current = $result->order_id;

		$count = count(Portfolio::all());

		$result->delete();

		File::rmdir(path('public').'uploads/'.$id.'/');

		if($count > 0){

			while($current < $count){

				$current += 1;

				$record = Portfolio::where_order_id($current)->first();

				$record->order_id = $current - 1;
				$record->save();
			}
		}

		Session::flash('success', 'Portfolio successfully deleted!');

		return Redirect::to('portfolios/');
	}

	public function action_show($id)
	{
		$result = Portfolio::find($id);

		if(strlen($result->info) > 0)
		{
			$info = explode('*&*', $result->info);

			foreach($info as &$row){
				$row = explode('&val=', $row);
			}

			$result->info = $info;
		}
		else{
			$result->info = false;
		}

		if($result)
		{
			return View::make('portfolios.show')
				->with('portfolio', $result);
		}
		else
		{
			return Redirect::to('portfolios/');
		}
	}

	public function action_all()
	{
		$portfolios = Portfolio::all();

		return View::make('portfolios.all')
			->with('portfolios', $portfolios);
	}

	function set_order($order, $count)
	{
		foreach($order as $key => &$value){

			$value['id'] = $key;
		}

		$order = array_reverse($order);

		foreach($order as &$item){

			$id = (int)$item['order_id'];

			if(in_array($id, $count)){

				if(($key = array_search($id, $count)) !== false){

				    unset($count[$key]);
				}

				$item['order_id'] = $id;
			}
			else{

				$id = max($count);

				$item['order_id'] = $id;

				if(($key = array_search($id, $count)) !== false){

				    unset($count[$key]);
				}
			}
		}

		return $order;
	}
}

?>