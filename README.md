# Patient Management System

## Overview

The Patient Management System is a comprehensive web application designed to streamline the management of patient information, appointments, billing, and prescriptions. The system also integrates AI capabilities for disease prediction, enhancing the diagnostic process for healthcare providers.

## Features

### 1. Appointment Management

- **Doctor's Acknowledgment**: Doctors can accept or reject appointments, providing immediate feedback to patients about the status of their appointment.
  
### 2. User Registration

- **Unique Email Validation**: The system ensures that each user registers with a unique email ID. If a user attempts to register with an already registered email, the system will prompt an error and prevent registration.
  
### 3. Secure Password Handling

- **Password Encryption**: User passwords are encrypted before being stored in the database to ensure security.
- **Hidden Password Field**: The password field is hidden in the admin panel to prevent unauthorized access.

### 4. Pagination

- **List View Pagination**: All list views across the application implement pagination to enhance usability and performance, allowing users to navigate through records easily.

### 5. Bug Fixes

- **Bill Payment Receipt**: The system now ensures that the bill payment receipt does not contain multiple records for the same doctor if the patient has visited multiple times.

### 6. Enhanced Prescription Details

- **Specific Prescriptions**: Additional fields have been added to the prescription statement, making it more detailed and specific to the patient's condition and treatment plan.

### 7. Detailed Payment Records

- **Payment Details**: The payment module now includes comprehensive details such as the date of payment, amount paid, and other relevant information.

### 8. Data Export

- **Export to Excel**: An export button has been added to the admin module, allowing administrators to export all patient, appointment, and billing details to an Excel sheet for easy analysis and record-keeping.

## AI Capabilities

### Disease Prediction

The system integrates AI capabilities to predict possible diseases based on symptoms provided by the patient. This feature leverages a Flask-based machine learning model to enhance the diagnostic process.

#### How It Works

1. **Symptom Input**: Patients enter their symptoms into the system.
2. **AI Analysis**: The system sends the symptoms to the Flask server, which processes the data using the trained AI model.
3. **Prediction**: The AI model returns a disease prediction along with relevant information such as description, precautions, medications, diets, and recommendations.
4. **Display Results**: The system displays the prediction results to the patient.

## Developer Guide

### Prerequisites

- PHP (version 7.4 or higher)
- MySQL
- Composer
- Flask (Python environment)

### Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-repo/patient-management-system.git
   cd patient-management-system
   ```

3. **Set Up the Database**

   - Create a MySQL database named `patient_management`.
   - Import the provided SQL file to set up the database schema.

### Flask AI Integration

1. **Set Up Flask Environment**

   - Create a virtual environment for Flask.

   ```bash
   python3 -m venv venv
   source venv/bin/activate
   ```

   - Install Flask and other dependencies.

   ```bash
   pip install flask
   ```

2. **Run the Flask Server**

   Navigate to the `flask` directory and start the Flask server.

   ```bash
   cd flask
   python main.py
   ```

3. **Update Flask Server URL**

   Ensure the Flask server URL in `disease-predict.php` is set to `http://localhost:5000/predict`.

### Usage

1. **Register and Log In**

   - Users can register and log in using unique email IDs.
   - Passwords are securely encrypted.

2. **Manage Appointments**

   - Patients can book appointments with doctors.
   - Doctors can accept or reject appointments.

3. **View and Export Data**

   - Admins can view patient, appointment, and billing details.
   - Data can be exported to an Excel sheet for further analysis.

4. **AI-Based Disease Prediction**

   - Patients can enter symptoms to get AI-based disease predictions.
   - Detailed results are displayed, including disease description, precautions, medications, diets, and recommendations.

## Conclusion

The Patient Management System provides a robust platform for managing patient information and appointments, enhancing the healthcare process with AI-based disease prediction capabilities. By following this guide, developers can set up and run the system on their machines, ensuring a seamless experience for both healthcare providers and patients.
