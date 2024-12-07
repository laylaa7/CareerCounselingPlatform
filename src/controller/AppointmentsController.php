<?php

require_once __DIR__ . '/../config/config.php';

include_once  PROJECT_ROOT  . "/model/appointment_model.php";

require PROJECT_ROOT . "/helpers/db_connect.php";

$GLOBALS["conn"] = $conn;

class AppointmentsController {
    private $model;

    public function __construct() {
        $db = $GLOBALS["conn"];
        $this->model = new AppointmentsModel($db);
    }

    public function index(){
        include_once PROJECT_ROOT . '/view/counselor/dashboard.php';
    }

    // Handle creating a new appointment
    public function createAppointment($data) {
        $st_id = $data['st_id'];
        $booking_date = $data['booking_date'];
        $status = $data['status'];

        if ($this->model->createAppointment($st_id, $booking_date, $status)) {
            echo json_encode(['message' => 'Appointment created successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to create appointment.']);
        }
    }

    // Handle retrieving all appointments with student info
    public function getAppointments($counselor_id = 0) {
        $appointments = $this->model->getAppointments($counselor_id);
        return json_encode($appointments);
    }

    // Handle retrieving a specific appointment by ID
    public function getAppointmentById($id) {
        $appointment = $this->model->getAppointmentById($id);
        if ($appointment) {
            echo json_encode($appointment);
        } else {
            echo json_encode(['error' => 'Appointment not found.']);
        }
    }

    // Handle updating an appointment
    public function updateAppointment($data) {
        $app_id = $data['app_id'];
        $st_id = $data['st_id'];
        $booking_date = $data['booking_date'];
        $status = $data['status'];

        if ($this->model->updateAppointment($app_id, $st_id, $booking_date, $status)) {
            echo json_encode(['message' => 'Appointment updated successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to update appointment.']);
        }
    }

    // Handle deleting an appointment
    public function deleteAppointment($id) {
        if ($this->model->deleteAppointment($id)) {
            echo json_encode(['message' => 'Appointment deleted successfully.']);
        } else {
            echo json_encode(['error' => 'Failed to delete appointment.']);
        }
    }

    public function changeStatus($appointment_id, $new_status) {
        // echo $appointment_id;
        // Validate the status (approved or denied)
        if ($new_status !== 'approved' && $new_status !== 'denied') {
            return "Invalid status.";
        }

        // Call the model to update the status in the database
        $result = $this->model->updateStatus($appointment_id, $new_status);

        if ($result) {
            return json_encode(['success' => true, 'message' => 'Status updated successfully']);
        } else {
            return "Failed to update status.";
        }
    }

    public function getFilteredAppointments($searchTerm, $filterStatus, $counselor_id){
        $counselor_id = (int)$counselor_id;
        $appointments = $this->model->fetchAppointments($counselor_id, isset($searchTerm) ? $searchTerm : "", isset($filterStatus) ? $filterStatus : "*");
        return json_encode($appointments);
        
    }
}

