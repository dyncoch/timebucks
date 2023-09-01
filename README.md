# Timebucks - Assignment - Lucas Fonseca Martins

This project was developed based on a given assignment to showcase the integration of backend, frontend, and database systems. It retrieves, encrypts, stores, and displays data using the technology stack mentioned below.

## Technology Stack

- **Backend**: Cakephp 3.0+
- **Frontend**: Jquery Datatables, Bootstrap
- **Database**: MySQL

## Local Enviroment
- **PHP**: 7.4.33
- **MySQL**: 5.7.39
- **WebServer**: MAMP PRO

## Features

### 1. Data Fetching and Storing:
- A cron job/command has been implemented to fetch data from the provided API.
- The fetched data is encrypted and stored in a MySQL database table.

### 2. Data Display:
- A web page retrieves the stored data, decrypts it, and displays it using Jquery DataTables.
- The table contains columns for the name, requirements, description, ecpc (displayed as double), and a clickable URL (click_url).

### 3. Functionalities:
- Only the ECPC column is sortable.
- A search box at the top allows searching by the "name". AutuSuggest functionality is added for better user experience.
- The application is a single-page app without any login/signup mechanism.

## Setup

### Database:

- A DDL.sql file is included in the root directory to set up the necessary database and tables with some sample data.

### Running the Cron:

- You can set up the cron job by following the instructions provided in the setup_cron.sh file.

1. Open the setup_cron.sh file.
2. Change the PROJECT_PATH variable to match the path of your project directory: PROJECT_PATH="/path-to-your-project".
3. ./setup_cron.sh

### Deployment
- Clone the repository and set it up on your local machine or server. Ensure the database configurations are correctly set in your CakePHP configuration.

### Encryption
Utilizes the AES-256-CBC encryption algorithm to encrypt the provided data using a specified key. The function then combines the initialization vector (IV) and the encrypted data, encoding them using Base64, and returns the combined string.

#### Location
The encryption key used for data encryption and decryption is located in the app.php configuration file of the CakePHP application.
Specifically, it is stored with the key name `encryptionKey`.

In future iterations, I would consider leveraging the env() function to ensure the key's safety and confidentiality. I think this approach is out of the assigment scope.


### Duration

**Total Time Spent**: Approximately 8 hours

#### Breakdown:

- **Environment Setup (4 hours)**: I opted not to use Docker due to my laptop's performance constraints. This decision led me to downgrade my PHP version from 8.x to 7.4.33. Subsequently, I utilized Composer to install CakePHP. Given my unfamiliarity with CakePHP, I had to dedicate a substantial amount of time to peruse its documentation.

- **Data Fetching & Database Design (30 minutes)**: I allocated half an hour to retrieve data from the provided API and design the database schema.

- **Troubleshooting (2 hours)**: Encountered challenges with CakePHP's beforeSave method, which took around two hours to resolve.

- **Encryption Implementation (10 minutes)**: I dedicated a short duration to craft my encryption class.

- **Frontend & Documentation (1 hour)**: The final stages involved frontend development and drafting documentation, which cumulatively took an hour.
