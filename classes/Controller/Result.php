<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Result extends Controller_Website {
	
	public function action_index()
	{
		// Only if logged in
		//if(!Auth::instance()->logged_in())
		//	HTTP::redirect("#login");
		
		$user = Auth::instance()->get_user();
		
		$query = DB::select(
			array(DB::expr("COUNT(vote)"), "amount")
		)->from('votes')
				->where("study", "=", ":study")
				->join('students')->on("votes.student", "=", "students.id")
						->as_object();
		
		$this->template->content = View::factory("results");
		$this->template->content->bind("studies", $studies);
		$studies = array("TW" => array(), "TI" => array(), );
		foreach($studies as $name => &$val){
			$query->parameters(array(":study"=>$name));
			$q = array(clone $query, clone $query, clone $query);
			$val['student_count'] = $q[0]->group_by('student')->execute()->count();
			$val['tutor_count'] 	= $q[1]->join('nominees')->on("votes.nominee", "=", "nominees.id")->group_by('nominee')->execute()->count();
			//$val['tutor_count'] = Database::instance()->last_query;
			$val['vote_count']	  = $q[2]->execute()->get('amount');
			$val['query'] = Database::instance()->last_query;
		}
	}
	
	/**
	 * Scores based on bayes algorithm score
	 */
	public function action_scores(){
		$this->template->content = View::factory("scores");
		$this->template->content->bind("studies", $studies);
    View::set_global('container_style', '-fluid');
    View::set_global('bayes', true);
		
		$studies = array("TW" => array(), "TI" => array(), );
		foreach($studies as $name => $val){
		
			$totals = DB::select(
				array(DB::expr("AVG(RateCount)"), "AvgNumOfRatingsForAll"),
				array(DB::expr("AVG(AvgRating)"), "AvgRatingForAll")
			)->from("view_aggregate_:name")->as_object()->parameters(array(":name" => DB::expr(strtolower($name))))->execute()->as_array();
			$totals = $totals[0];
			
			$scores = DB::select(
				'id',
				'AvgRating',
				'RateCount',
				array(DB::expr("(:AvgNumOfRatingsForAll * :AvgRatingForAll + TotalRating) / (RateCount + :AvgNumOfRatingsForAll)"), "score")
			)->from(array("view_aggregate_:name", 'ag'))->as_object()->parameters(array(
				":AvgNumOfRatingsForAll" => $totals->AvgNumOfRatingsForAll,
				":AvgRatingForAll" => $totals->AvgRatingForAll,
				":name" => DB::expr(strtolower($name))
			))/*->join("nominees")->on("nominees.id", "=", "ag.id")*/->order_by("score", "DESC")->limit(11)->execute()->as_array();
			
			foreach($scores as $row){
				$studies[$name][] = array(
					ORM::factory('Nominee', $row->id), $row->AvgRating, $row->RateCount
				);
			}
		}
	}
	
	/**
	 * Old scoring page based on average rating
	 */
	public function action_old(){
		$this->template->content = View::factory("scores");
		$this->template->content->bind("studies", $studies);
    View::set_global('container_style', '-fluid');
		
		$query = DB::select(
			"nominee", 
			array(DB::expr("AVG(vote)"), "score"), 
			array(DB::expr("COUNT(vote)"), "amount")
		)->from('votes')
				->where("study", "=", ":study")
				->join('students')->on("votes.student", "=", "students.id")
				->group_by('nominee')
					->order_by('score', 'DESC')
					->order_by('amount', 'DESC')
						->limit(10)
							->as_object();
		
		$studies = array("TW" => array(), "TI" => array(), );
		foreach($studies as $name => $val){
			$results = $query->parameters(array(":study"=>$name))->execute();
			foreach($results as $row){
				$studies[$name][] = array(
					ORM::factory('Nominee', $row->nominee), $row->score, $row->amount
				);
			}
		}
	}

} // End