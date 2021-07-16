<?php
	/*
	*	This model is defined for participants
	*/
	class Participants_model extends CI_Model {

		//Class Constructor
		public function __construct() {
			//Call Parent Class Constructor
        	parent::__construct();
		}


		/*
		*	Function To Get All Participants
		*/
		public function getParticipants($pageNo, $recsPerPage=10) {
			//DB Query
			$this->db->select('*');
		    $this->db->from('participants');
		    $this->db->order_by('updated_at', 'DESC');

		    $this->db->limit($recsPerPage, $pageNo); 
		    
		    //Execute DB Query
		    $query = $this->db->get();
		 
		 	//Return Result
		    return $query->result_array();
		}


		/*
		*	Function To Get Total Participants
		*/
		public function getTotalParticipants() {
			//DB Query
			$this->db->select('COUNT(*) AS totalParticipants');
    		$this->db->from('participants');

		    //Execute Query
		    $query = $this->db->get();
		    $result = $query->result_array();
		 
		 	//Return Result
		    return $result[0]['totalParticipants'];
		}


		/*
		*	Function To Register A Participant
		*/
		public function registerParticipant($participantData) {
			//Insert Participants Data
			$this->db->insert('participants', $participantData);

			//Return Response
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		/*
		*	Function To Update Participant Data
		*/
		public function updateParticipant($id, $participantData) {
			//Update Participant Data
			$this->db->where('id', $id);
			$this->db->update('participants', $participantData);

			//Return Response
			return ($this->db->affected_rows() > 0) ? true : false;
		}


		/*
		*	Function To Validate Participant ID
		*/
		public function validateParticipantID($id) {
			//DB Query
			$this->db->select('COUNT(id) AS totalParticipants');
			$this->db->from('participants');
			$this->db->where('id', $id);

			//Execute Query
		    $query = $this->db->get();
		    $result = $query->result_array();
		 
		 	//Return Result
		    return ($result[0]['totalParticipants'] > 0) ? true : false;
		}
	}