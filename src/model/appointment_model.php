<?php
class AppointmentsModel {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new appointment
    public function createAppointment($StudentID, $booking_date, $status) {
        $query = "INSERT INTO counselingsessions (StudentID, date, notes) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iss", $StudentID, $booking_date, $status);

        return $stmt->execute();
    }

    public function getAppointments($counselor_id) {
        $search = "";
        if($counselor_id != 0){
            $search = "WHERE 
            counselingsessions.CounselorID = " . $counselor_id;
        }
        $query = "
            SELECT 
            counselingsessions.SessionID, 
            counselingsessions.date, 
            counselingsessions.notes, 
            students.StudentID, 
            student_users.Username AS name, 
            student_users.Email AS student_email, 
            students.phone AS student_phone, 
            counselors.CounselorID, 
            counselor_users.Username AS counselor_name, 
            counselor_users.Email AS counselor_email
            FROM 
                counselingsessions
            INNER JOIN 
                students 
            ON 
                counselingsessions.StudentID = students.StudentID
            INNER JOIN 
                counselors 
            ON 
                counselingsessions.CounselorID = counselors.CounselorID
            INNER JOIN 
                users AS student_users 
            ON 
                students.UserID = student_users.UserID
            INNER JOIN 
                users AS counselor_users 
            ON 
                counselors.UserID = counselor_users.UserID
            ".$search." ORDER BY counselingsessions.date DESC
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
      
    // Function to update the notes of the appointment
    public function updateStatus($appointment_id, $new_status) {
        $query = "UPDATE counselingsessions SET notes = ? WHERE SessionID = ?";
        $stmt = $this->conn->prepare($query);

        if($stmt) {
            $stmt->bind_param("si", $new_status, $appointment_id); // "si" means string and integer
            return $stmt->execute(); // Return true if executed successfully
        } else {
            return false;
        }
    }

    // Read a single counselingsessions by app_id
    public function getAppointmentById($app_id) {
        $query = "SELECT * FROM counselingsessions WHERE SessionID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $app_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update an appointment
    public function updateAppointment($app_id, $StudentID, $booking_date, $status) {
        $query = "UPDATE counselingsessions SET StudentID = ?, date = ?, notes = ? WHERE SessionID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issi", $StudentID, $booking_date, $status, $app_id);

        return $stmt->execute();
    }

    // Delete an appointment
    public function deleteAppointment($app_id) {
        echo "app_id= " . $app_id;
        $query = "DELETE FROM counselingsessions WHERE SessionID =?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $app_id);

        return $stmt->execute();
    }

    public function fetchAppointments($counselor_id, $searchTerm = '', $filterStatus = 'none') {
        $query = "SELECT counselingsessions.*, users.Email AS student_email, students.phone AS student_phone, users.Username AS student_name
          FROM counselingsessions 
          INNER JOIN students ON counselingsessions.StudentID = students.StudentID 
          INNER JOIN users ON students.UserID = users.UserID
          WHERE counselingsessions.CounselorID = ?";
        
        $params = [$counselor_id];
        $types = "i"; // 'i' for integer
    
        if ($filterStatus !== 'none' && $filterStatus !== "*") {
            $query .= " AND counselingsessions.notes = ?";
            $params[] = $filterStatus;
            $types .= "s"; // 's' for string
        }
        
        if (!empty($searchTerm)) {
            $query .= " AND (users.Username LIKE ? OR users.Email LIKE ?)";
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