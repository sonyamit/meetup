<?php

	/*
	*	This controller is defined participants APIs
	*/

	defined('BASEPATH') OR exit('No direct script access allowed');

	use chriskacerguis\RestServer\RestController;

	class Api extends RestController {

		public function __construct() {
			//Call Parent Class Constructor
        	parent::__construct();

        	//Load Helper
        	$this->load->helper('url');

        	//Load Pagination library
    		$this->load->library('pagination');

    		//Load Form Validation library
    		$this->load->library('form_validation');

    		//Load Model
        	$this->load->model('participants_model');
		}

	    /*
	    *	Function To Get List Of Participants 
	    *	For The Meetup Event
	    */
	    public function participants_get() {
	    	try {
	    		//Get Page No
	    		$pageNo = !is_null($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

		    	//Set Recs Per Page
		    	$recsPerPage = 10;

		    	//Calculate Offset
		    	$offset = ($pageNo - 1) * $recsPerPage;

		    	//Get Total Participants
		    	$totalParticipants = $this->participants_model->getTotalParticipants();

		    	//Get All Participants
		    	$participants = $this->participants_model->getParticipants($offset, $recsPerPage);

		    	//Pagination Configuration
			    $config['base_url'] = base_url().'api/participants/';
			    $config['use_page_numbers'] = true;
			    $config['total_rows'] = $totalParticipants;
			    $config['per_page'] = $recsPerPage;

			    //Initialize Pagination
			    $this->pagination->initialize($config);

		    	if (is_array($participants) && count($participants) > 0) {
			    	//Set Response Data
			    	$responseData['status'] = true;
			    	$responseData['message'] = 'List of participants';
			    	$responseData['data']['result'] = $participants;
			    	$responseData['data']['total_recs'] = $totalParticipants;
			    	$responseData['data']['recs_per_page'] = $recsPerPage;
			    	$responseData['data']['current_page'] = $pageNo;
			    	$responseData['data']['pagination'] = $this->pagination->create_links();

		    		//Return Response
		    		$this->response($responseData, 200);
		    	} else {
		    		//Set Response Data
		    		$responseData['status'] = true;
		    		$responseData['message'] = 'Participants data does not exists';

		    		//Return Response
		    		$this->response($responseData, 200);
		    	}
	    	} catch(Exception $e) {
	    		//Set Response Data
		    	$responseData['status'] = false;
		    	$responseData['message'] = 'Internal server error';

	    		//Return Response
	    		$this->response($responseData, 500);
	    	}
	    }


	    /*
	    *	Function To Register Participant 
	    *	For The Meetup Event
	    */
	    public function participants_post() {
	    	try {
		    	//Get JSON POST Data
		    	$jsonData = $this->input->raw_input_stream;
		    	
		    	//Decode JSON Data
		    	$jsonDecodedData = json_decode($jsonData, true);

		    	//Set Data For Validation
		    	$this->form_validation->set_data($jsonDecodedData);

		    	//Setting Validation Rules
		    	$this->form_validation->set_rules('name', 'name', 'trim|required|alpha');
		    	$this->form_validation->set_rules('age', 'age', 'trim|required|is_natural_no_zero');
		    	$this->form_validation->set_rules('dob', 'dob', 'trim|required');
		    	$this->form_validation->set_rules('profession', 'profession', 'trim|required|alpha');
		    	$this->form_validation->set_rules('locality', 'locality', 'trim|required|alpha_numeric_spaces');
		    	$this->form_validation->set_rules('number_of_guests', 'number_of_guests', 'trim|required|is_natural');
		    	$this->form_validation->set_rules('address', 'address', 'trim|required|max_length[50]|alpha_numeric_spaces');

		    	if ($this->form_validation->run() == FALSE) {
		    		//Validation Failed

		    		//Set Response Data
		    		$responseData['status'] = false;
		    		$responseData['message'] = 'Invalid API parameters';
		    		$responseData['error'] = $this->form_validation->error_array(); //Validation Error Messages

		    		//Return Response
		    		$this->response($responseData, 400);
		    	} else {
		    		//Validation Passed

		    		//Format DOB in YYYY-MM-DD
		    		if (isset($jsonDecodedData['dob']) && $jsonDecodedData['dob'] != '') {
		    			$jsonDecodedData['dob'] = date('Y-m-d', strtotime($jsonDecodedData['dob']));
		    		}

		    		//Set updated_at date
		    		$jsonDecodedData['updated_at'] = date('Y-m-d H:i:s');

		    		//Save Participant Data
		    		$insertStatus = $this->participants_model->registerParticipant($jsonDecodedData);

		    		//Set Response Data
		    		$responseData['status'] = $insertStatus;

		    		if ($insertStatus) {
		    			//Set Response Data
		    			$responseData['message'] = 'Participant registered successfully';

		    			//Return Response
		    			$this->response($responseData, 200);
		    		} else {
		    			//Set Response Data
		    			$responseData['message'] = 'Participant registration failed. Please try again later';

		    			//Return Response
		    			$this->response($responseData, 500);
		    		}
		    	}
	    	} catch(Exception $e) {
	    		//Set Response Data
		    	$responseData['status'] = false;
		    	$responseData['message'] = 'Internal server error';

	    		//Return Response
	    		$this->response($responseData, 500);
	    	}
	    }


	    /*
	    *	Function To Update Registered
	    *	Participant's Details
	    */
	    public function participants_put() {
	    	try {
	    		//Get JSON PUT Data
		    	$jsonData = $this->input->raw_input_stream;
		    	
		    	//Decode JSON Data
		    	$jsonDecodedData = json_decode($jsonData, true);

		    	//Set Data For Validation
		    	$this->form_validation->set_data($jsonDecodedData);

				//Set Validation Rule For Participant ID
				$this->form_validation->set_rules('id', 'id', 'callback_validate_participant_id');

				//Set Validation Rule For Age
				if (isset($jsonDecodedData['age']) && $jsonDecodedData['age'] != '') {
					$this->form_validation->set_rules('age', 'age', 'trim|is_natural_no_zero');
				}

				//Set Validation Rule For Profession
				if (isset($jsonDecodedData['profession']) && $jsonDecodedData['profession'] != '') {
					$this->form_validation->set_rules('profession', 'profession', 'trim|alpha');
				}

				//Set Validation Rule For Locality
				if (isset($jsonDecodedData['locality']) && $jsonDecodedData['locality'] != '') {
					$this->form_validation->set_rules('locality', 'locality', 'trim|alpha_numeric_spaces');
				}

				//Set Validation Rule For No. Of Guests
				if (isset($jsonDecodedData['number_of_guests']) && $jsonDecodedData['number_of_guests'] != '') {
					$this->form_validation->set_rules('number_of_guests', 'number_of_guests', 'trim|is_natural');
				}

				//Set Validation Rule For Address
				if (isset($jsonDecodedData['address']) && $jsonDecodedData['address'] != '') {
					$this->form_validation->set_rules('address', 'address', 'trim|max_length[50]|alpha_numeric_spaces');
				}

		    	if ($this->form_validation->run() == FALSE) {
		    		//Validation Failed

		    		//Set Response Data
		    		$responseData['status'] = false;
		    		$responseData['message'] = 'Invalid API parameters';
		    		$responseData['error'] = $this->form_validation->error_array(); //Validation Error Messages

		    		//Return Response
		    		$this->response($responseData, 400);
		    	} else {
		    		//Validation Passed
		    		
		    		//Participant ID
		    		$participantID = $jsonDecodedData['id'];
		    		unset($jsonDecodedData['id']);

		    		//Format DOB in YYYY-MM-DD
		    		if (isset($jsonDecodedData['dob']) && $jsonDecodedData['dob'] != '') {
		    			$jsonDecodedData['dob'] = date('Y-m-d', strtotime($jsonDecodedData['dob']));
		    		}

		    		//Update Participant Data
		    		$updateStatus = $this->participants_model->updateParticipant($participantID, $jsonDecodedData);

		    		//Set Response Data
		    		$responseData['status'] = $updateStatus;

		    		if ($updateStatus) {
		    			//Set Response Data
		    			$responseData['message'] = 'Participant details updated successfully';

		    			//Return Response
		    			$this->response($responseData, 200);
		    		} else {
		    			//Set Response Data
		    			$responseData['message'] = 'Participant details could not be updated. Please try again later.';

		    			//Return Response
		    			$this->response($responseData, 500);
		    		}
		    	}	
	    	} catch (Exception $e) {
	    		//Set Response Data
		    	$responseData['status'] = false;
		    	$responseData['message'] = 'Internal server error';

	    		//Return Response
	    		$this->response($responseData, 500);
	    	}
	    }


	    /*
	    *	Custom Validation For Participant ID
	    */
	    public function validate_participant_id($id) {
	    	if(trim($id) == "" || empty($id)) {
	    		//Check if id is empty
        		$this->form_validation->set_message('validate_participant_id', 'Please provided %s.');
        		return FALSE;
    		} elseif (!is_int($id)) {
    			//Check if id is an integer value
    			$this->form_validation->set_message('validate_participant_id', 'Please provided %s as an integer.');
        		return FALSE;
    		} else {
    			//Check if id exists in DB
    			$isValidId = $this->participants_model->validateParticipantID($id);

    			if (!$isValidId) {
    				$this->form_validation->set_message('validate_participant_id', 'Please provided valid %s.');
    			}

    			return $isValidId;
    		}
	    }
	}