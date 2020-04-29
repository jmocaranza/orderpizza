**Oreder Retrieve**
----
  Returns json data about a single Order.

* **URL**

  /api/v1/order/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **code:** 201 <br />
    **error:** false <br />
    **data:** `{
        "id": 14,
        "date_entered": "2020-04-29T05:46:33+00:00",
        "status": "t",
        "pizzas": [
            {
                "id": 25,
                "size": "M",
                "toppings": [
                    {
                        "id": 55,
                        "name": "Green peppers"
                    },
                    {
                        "id": 56,
                        "name": "Black olives"
                    },
                    {
                        "id": 57,
                        "name": "Extra cheese"
                    }
                ]
            },
            {
                "id": 26,
                "size": "M",
                "toppings": [
                    {
                        "id": 58,
                        "name": "Mushrooms"
                    },
                    {
                        "id": 59,
                        "name": "Pepperoni"
                    }
                ]
            }
        ]
    }`
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** ``

  * **Code:** 500 Internal server error <br />
    **Content:** ``    

**Order Add**
----
  Create a order and Returns json data about the created order

* **URL**

  /api/v1/order

* **Method:**

  `POST`
  
*  **URL Params**

   **Required:**

    none

* **Data Params**
    {
        "status": "t",
        "pizzas": [
            { "size":"M", "toppings":[ "Green peppers", "Black olives", "Extra cheese" ] },
            { "size":"M", "toppings":[ "Mushrooms", "Pepperoni" ] }
            ]
    }

* **Success Response:**

  * **Code:** 201 <br />
    **error:** false <br />
    **Content:** `{
            "code": 201,
            "error": false,
            "data": {
                "id": 15,
                "date_entered": "2020-04-29T06:33:40+00:00",
                "status": "t",
                "pizzas": [
                    {
                        "id": 27,
                        "size": "M",
                        "toppings": [
                            {
                                "id": 60,
                                "name": "Green peppers"
                            },
                            {
                                "id": 61,
                                "name": "Black olives"
                            },
                            {
                                "id": 62,
                                "name": "Extra cheese"
                            }
                        ]
                    },
                    {
                        "id": 28,
                        "size": "M",
                        "toppings": [
                            {
                                "id": 63,
                                "name": "Mushrooms"
                            },
                            {
                                "id": 64,
                                "name": "Pepperoni"
                            }
                        ]
                    }
                ]
            }
        }`
 
* **Error Response:**

  * **Code:** 400 Data error <br />
    **Content:** ``

    **Code:** 500 Internal server error <br />
    **Content:** ``

 **Order Update**
----
  Update a order 

* **URL**

  /api/v1/order/:id

* **Method:**

  `PUT`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**
    {
        "status": "d",
        "pizzas": [
            { "size":"S", "toppings":[ "Spinach", "Sausage", "Onions" ] },
            { "size":"L", "toppings":[ "Chicken", "Ham" ] }
            ]
    }

* **Success Response:**

  * **Code:** 200 <br />
    **error:** false <br />
    **Content:** `{
            "code": 200,
            "error": false,
            "data": {
                "id": 10,
                "date_entered": "2020-04-29T04:23:36+00:00",
                "status": "d",
                "pizzas": [
                    {
                        "id": 17,
                        "size": "S",
                        "toppings": [
                            {
                                "id": 36,
                                "name": "Spinach"
                            },
                            {
                                "id": 37,
                                "name": "Sausage"
                            },
                            {
                                "id": 38,
                                "name": "Onions"
                            }
                        ]
                    },
                    {
                        "id": 18,
                        "size": "L",
                        "toppings": [
                            {
                                "id": 39,
                                "name": "Chicken"
                            },
                            {
                                "id": 40,
                                "name": "Ham"
                            }
                        ]
                    }
                ]
            }
        }`
 
* **Error Response:**

  * **Code:** 400 Data error <br />
    **Content:** ``

    **Code:** 500 Internal server error <br />
    **Content:** ``