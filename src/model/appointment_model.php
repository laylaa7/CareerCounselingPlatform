<?php
class AppointmentsModel {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new appointment
    public function createAppointment($st_id, $booking_date, $status) {
        $query = "INSERT INTO appointment (st_id, booking_date, status) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iss", $st_id, $booking_date, $status);

        return $stmt->execute();
    }

    public function getAppointments($counselor_id) {
        $search = "";
        if($counselor_id != 0){
            $search = "WHERE 
            appointment.counselor_id = " . $counselor_id;
        }
        $query = "
            SELECT 
                appointment.app_id, 
                appointment.booking_date, 
                appointment.status, 
                students.st_id, 
                students.name AS student_name, 
                students.email AS student_email, 
                students.phone AS student_phone, 
                counselor.counselor_id, 
                counselor.name AS counselor_name
            FROM 
                appointment
            INNER JOIN 
                students 
            ON 
                appointment.st_id = students.st_id
            INNER JOIN 
                counselor 
            ON 
                appointment.counselor_id = counselor.counselor_id
            ".$search."   
        ";
        
        $result = $this->conn->query($query);
    
        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }
    
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    
        return $appointments;
    }
      
    // Function to update the status of the appointment
    public function updateStatus($appointment_id, $new_status) {
        $query = "UPDATE appointment SET status = ? WHERE app_id = ?";
        $stmt = $this->conn->prepare($query);

        if($stmt) {
            $stmt->bind_param("si", $new_status, $appointment_id); // "si" means string and integer
            return $stmt->execute(); // Return true if executed successfully
        } else {
            return false;
        }
    }

    // Read a single appointment by app_id
    public function getAppointmentById($app_id) {
        $query = "SELECT * FROM appointment WHERE app_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $app_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update an appointment
    public function updateAppointment($app_id, $st_id, $booking_date, $status) {
        $query = "UPDATE appointment SET st_id = ?, booking_date = ?, status = ? WHERE app_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issi", $st_id, $booking_date, $status, $app_id);

        return $stmt->execute();
    }

    // Delete an appointment
    public function deleteAppointment($app_id) {
        $query = "DELETE FROM appointment WHERE app_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $app_id);

        return $stmt->execute();
    }

    public function fetchAppointments($counselor_id, $searchTerm = '', $filterStatus = 'none') {
        $query = "SELECT appointment.*, students.name AS student_name, students.email AS student_email 
                  FROM appointment 
                  INNER JOIN students ON appointment.st_id = students.st_id 
                  WHERE appointment.counselor_id = ?";
        
        $params = [$counselor_id];
        $types = "i"; // 'i' for integer
    
        if ($filterStatus !== 'none' && $filterStatus !== "*") {
            $query .= " AND appointment.status = ?";
            $params[] = $filterStatus;
            $types .= "s"; // 's' for string
        }
        
        if (!empty($searchTerm)) {
            $query .= " AND (students.name LIKE ? OR students.email LIKE ?)";
            $searchTerm = '%' . $searchTerm . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "ss"; // 's' for string
        }
    
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
