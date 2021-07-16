This repository contains code for an upcoming meetup event where we need participants to RSVP so that we can prepare appropriate accommodations and transport facilities. The participants can bring up to two guests along with them.

Currently there are 3 APIs build using codeigniter framework. The API details are as mentioned below.

1. ## Register API
	##### Description: This API takes below mentioned data to register a participant and store in database.
	1. Name
	2. Age
	3. D.O.B (JS Date Obejct)
	4. Profession (Employed/Student)
	5. Locality
	6. Number Of Guests (0-2)
	7. Address (multiple input upto 50 characters)

##### API Endpoint: /participants
##### Method: POST

##### Sample API Request:

###### Headers: "content-type:application/json"

###### Request Parameters:
{"name":"Amit", "age":35, "dob": "1985-07-12", "profession":"Employed", "locality":"Kandivali","number_of_guests":1, "address":"A306 Venus Heights Kandivali Mumbai 67"}

##### Sample API Response:
{
    "status": true,
    "message": "Participant registered successfully"
}

**NOTE:**
The API parameters are validated and relevant validation message is return in API response.

2. ## List API
	##### Description: This API list all registered participants. There is even provision to paginate results to support long list.

##### API Endpoint: /participants
##### Method: GET

##### Sample API Response:
{
    "status": true,
    "message": "List of participants",
    "data": {
        "result": [
            {
                "id": "2",
                "name": "Paras",
                "age": "35",
                "dob": "1983-11-18",
                "profession": "Employed",
                "locality": "Adarsh",
                "number_of_guests": "0",
                "address": "404 Silver Croft Marve Road Malad Mumbai 400064",
                "created_at": "2021-07-16 02:17:16",
                "updated_at": "2021-07-16 02:22:40"
            },
            {
                "id": "3",
                "name": "Parth",
                "age": "33",
                "dob": "1984-02-18",
                "profession": "Student",
                "locality": "SV Road",
                "number_of_guests": "1",
                "address": "405 God Grace SV Road Kandivali Mumbai 400067",
                "created_at": "2021-07-16 02:21:42",
                "updated_at": "2021-07-16 02:21:42"
            },
            {
                "id": "1",
                "name": "Amit",
                "age": "35",
                "dob": "1985-12-07",
                "profession": "Employed",
                "locality": "Kandivali",
                "number_of_guests": "1",
                "address": "A306 Venus Heights Kandivali Mumbai 67",
                "created_at": "2021-07-16 02:14:55",
                "updated_at": "2021-07-15 22:44:55"
            }
        ],
        "total_recs": "3",
        "recs_per_page": 10,
        "current_page": 1,
        "pagination": ""
    }
}

**NOTE:**
For pagination pass page no to the API endpoint as mentione below 

##### API Endpoint: /participants/<page_no>
##### Method: GET

3. ## Update API
	##### Description: This API helps update certain data of registered participants.

##### API Endpoint: /participants
##### Method: PUT

##### Sample API Request:

###### Headers: "content-type:application/json"

###### Request Parameters:
{"id":1,"locality":"Mathuradas Road","number_of_guests":2}

##### Sample API Response:
{
    "status": true,
    "message": "Participant details updated successfully"
}

**NOTE:**
The API parameters are validated and relevant validation message is return in API response.

## Steps To Follow To Test APIs
1. Clone repository [GitHub](https://github.com/sonyamit/meetup.git)
2. Run command **composer install** to install dependencies via composer
3. Set base URL in **application/config/config.php** file
4. Import database using database dump located at path **db_scripts/meetup.sql**
5. Set your database credentials like (hostname, username, password and database) in **application/config/database.php** file

