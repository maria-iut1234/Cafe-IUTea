
<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/maria-iut1234/Cafe-IUTea">
    <img src="code/login/images/logo.png" alt="Logo" width="60" height="70">
  </a>

  <h3 align="center">Cafe IUTea</h3>

  <p align="center">
    An order, inventory and employee management system for a café to be used by both employees and managers.
    <br>
<!--     <a href="https://innuo.netlify.app/">Innuo Website</a> -->
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary><h3>Table of Contents<h3></summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

<!-- ![image](https://github.com/Xer0Bytes/Innuo/assets/95132675/0dc4247f-0347-4f72-8c05-79d241e4cb0d) -->

(This project was created for the academic course CSE4410 - Database Management Systems II Lab).

This web application caters specifically to cafes and similar establishments, offering a comprehensive platform for managers and staff to efficiently handle and monitor orders and inventory. 

Key functionalities include robust user authentication, CRUD operations for managing employees, ingredients, and recipes. Detailed order management capabilities include automated cost calculations and real-time inventory updates. The system also features advanced search functionalities for navigating extensive ingredient lists, as well as automated alerts and removal of items nearing or past expiry dates. Additionally, users benefit from a user-friendly media upload feature for easy access to recipe contents.

The manager side ensures that managers will be able to hire employees, fire employees, approve any employee requests and edit any menu details of their respective branch shop while the employee side ensures that employees will be able to list the ordered items, check inventory status and contact their manager for any difficulties or requests.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

* ![MySQL][MySQL-url]
* ![HTML5][HTML5-url]
* ![JavaScript][Javascript-url]
* ![PHP][PHP-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![JQuery][JQuery.com]][JQuery-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

 - Download `XAMPP` software from [here](https://www.apachefriends.org/download.html) as it is required to run an Apache HTTP Server.
 - Need to install PHP 5.3 or upper version. We can download PHP from [here](https://www.php.net/downloads.php)
 - Download the MySQL database from [here](https://dev.mysql.com/downloads/file/?id=486088)
 - Download the latest version of phpMyAdmin software tool from [here](https://www.phpmyadmin.net/) 

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/maria-iut1234/Cafe-IUTea.git
   ```
2. Start the Apache HTTP server
3. Go to:
   ```sh
   http://localhost/phpmyadmin/`
   ```
4. Click on the `databases` tab and create a database named `dbms`
5. Import the `dbms_with_views.sql` from `presentation/` folder
6. From the cloned repo, copy the folder named `code` and paste it in the `htdocs` folder of where you installed `XAMPP`
7. Go to the following link to browse the locally hosted project:
   ```sh
   http://localhost/code/login/index.php
   ```


<!-- USAGE EXAMPLES -->
## Usage

**1. User Authentication System:**
  - Secure access to personalized dashboards.
  - Create, Read, Update and Delete own user profiles.

**2. Recipe, Employee & Ingredient CRUD Operations:**
  - Create, Read, Update, and Delete recipes, employees, ingredients.

**3. Detailed Recipe Information:**
  - Includes name, description, ingredients, images.

**4. Media Upload Functionality:**
  - Users can upload images for each recipe, ingredient and for their own profiles too.

**5. Order Input:**
  - Employees can input the customer's order according to any additional toppings or sizes and the total cost of the order will be shown.

**6. Revenue Calculation:**
  - Employees will be able to see the daily, monthly and yearly revenue details.

**7. Expiration Data Alerts:**
  - There are automatic database triggers which alert employees of items which are nearing their expiry dates.

**8. Inventory Management:**
  - Employees will only be able to place orders that are possible to make with current inventory items.

**9. Automatic removal of expired items:**
  - There are automatic database triggers which remove expired items from inventory and alert the employees about it.

**10. Restocking Alerts:**
  - There are automatic database triggers which alert employees of items which are low in inventory (the minimum amount can be specified by the manager).
   

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- CONTRIBUTING -->
## Contributing

Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- LICENSE -->
## License

This project is licensed under the [MIT License](LICENSE).

<!-- CONTACTS -->
## Contact:

- **Shanta Maria**
  - *GitHub:* [maria-iut1234](https://github.com/maria-iut1234)
- **M M Nazmul Hossain**
  - *GitHub:* [nazmul4532](https://www.github.com/nazmul4532)



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* [Img Shields](https://shields.io)
* [GitHub ReadMe Template](https://github.com/othneildrew/Best-README-Template/tree/master)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 

[MySQL-url]: https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white
[HTML5-url]: https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white
[Javascript-url]: https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E
[PHP-url]: https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white


[MySQL-url]: https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white
[HTML5-url]: https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white
[Javascript-url]: https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E
[PHP-url]: https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white
