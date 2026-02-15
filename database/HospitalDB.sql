CREATE DATABASE HospitalDB;
USE HospitalDB;

CREATE TABLE Patients (
    PatientID INT IDENTITY(1,1) PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Age INT CHECK (Age > 0),
    Gender VARCHAR(10),
    ContactNumber VARCHAR(15),
    Email VARCHAR(100) UNIQUE,
    discription TEXT,
    CreatedAt DATETIME DEFAULT GETDATE()
);

CREATE TABLE Doctors (
    DoctorID INT IDENTITY(1,1) PRIMARY KEY,
    DoctorName VARCHAR(100) NOT NULL,
    Specialization VARCHAR(100) NOT NULL,
    ContactNumber VARCHAR(15),
    Email VARCHAR(100) UNIQUE
);

CREATE TABLE DoctorSchedules (
    ScheduleID INT IDENTITY(1,1) PRIMARY KEY,
    DoctorID INT NOT NULL,
    AvailableDay VARCHAR(20),
    StartTime TIME,
    EndTime TIME,

    CONSTRAINT FK_DoctorSchedule_Doctor
    FOREIGN KEY (DoctorID)
    REFERENCES Doctors(DoctorID)
    ON DELETE CASCADE
);

CREATE TABLE Appointments (
    AppointmentID INT IDENTITY(1,1) PRIMARY KEY,
    PatientID INT NOT NULL,
    DoctorID INT NOT NULL,
    AppointmentDate DATE NOT NULL,
    AppointmentTime TIME NOT NULL,
    Status VARCHAR(20) DEFAULT 'Pending',
    Symptoms TEXT,
    BookingTime DATETIME DEFAULT GETDATE(),

    CONSTRAINT FK_Appointment_Patient
    FOREIGN KEY (PatientID)
    REFERENCES Patients(PatientID),

    CONSTRAINT FK_Appointment_Doctor
    FOREIGN KEY (DoctorID)
    REFERENCES Doctors(DoctorID)
);

CREATE UNIQUE INDEX UX_Doctor_Appointment
ON Appointments (DoctorID, AppointmentDate, AppointmentTime);

ALTER TABLE Appointments
ADD CONSTRAINT CK_Appointment_Status
CHECK (Status IN ('Pending', 'Confirmed', 'Cancelled', 'Done'));

INSERT INTO Patients (FullName, Age, Gender, ContactNumber, Email)
VALUES
('Ali Khan', 22, 'Male', '03011234567', 'ali.khan@gmail.com'),
('Sara Ahmed', 25, 'Female', '03022345678', 'sara.ahmed@gmail.com'),
('Usman Raza', 30, 'Male', '03033456789', 'usman.raza@gmail.com'),
('Ayesha Malik', 28, 'Female', '03044567890', 'ayesha.malik@gmail.com'),
('Bilal Hussain', 35, 'Male', '03055678901', 'bilal.h@gmail.com'),
('Hira Sheikh', 24, 'Female', '03066789012', 'hira.s@gmail.com'),
('Hamza Ali', 27, 'Male', '03077890123', 'hamza.ali@gmail.com'),
('Noor Fatima', 21, 'Female', '03088901234', 'noor.f@gmail.com'),
('Zain Abbas', 32, 'Male', '03099012345', 'zain.abbas@gmail.com'),
('Mariam Iqbal', 29, 'Female', '03100123456', 'mariam.i@gmail.com');

INSERT INTO Doctors (DoctorName, Specialization, ContactNumber, Email)
VALUES
('Dr. Ahmed Raza', 'Cardiologist', '03111234567', 'ahmed.raza@hospital.com'),
('Dr. Sana Ali', 'Dermatologist', '03122345678', 'sana.ali@hospital.com'),
('Dr. Imran Khan', 'Orthopedic', '03133456789', 'imran.khan@hospital.com'),
('Dr. Fatima Noor', 'Gynecologist', '03144567890', 'fatima.noor@hospital.com'),
('Dr. Salman Akhtar', 'Neurologist', '03155678901', 'salman.akhtar@hospital.com'),
('Dr. Adeel Shah', 'ENT Specialist', '03166789012', 'adeel.shah@hospital.com'),
('Dr. Bushra Amin', 'Pediatrician', '03177890123', 'bushra.amin@hospital.com'),
('Dr. Kamran Latif', 'Psychiatrist', '03188901234', 'kamran.latif@hospital.com'),
('Dr. Nadia Aslam', 'Physician', '03199012345', 'nadia.aslam@hospital.com'),
('Dr. Farooq Ahmed', 'Urologist', '03200123456', 'farooq.ahmed@hospital.com');

INSERT INTO DoctorSchedules (DoctorID, AvailableDay, StartTime, EndTime)
VALUES
(1, 'Monday', '09:00', '12:00'),
(2, 'Tuesday', '10:00', '13:00'),
(3, 'Wednesday', '09:00', '12:00'),
(4, 'Thursday', '11:00', '14:00'),
(5, 'Friday', '09:00', '12:00'),
(6, 'Monday', '14:00', '17:00'),
(7, 'Tuesday', '09:00', '12:00'),
(8, 'Wednesday', '10:00', '13:00'),
(9, 'Thursday', '09:00', '12:00'),
(10, 'Friday', '10:00', '13:00');

INSERT INTO Appointments (PatientID, DoctorID, AppointmentDate, AppointmentTime, Status)
VALUES
(1, 1, '2026-02-01', '09:00', 'Confirmed'),
(2, 2, '2026-02-01', '10:00', 'Pending'),
(3, 3, '2026-02-02', '09:00', 'Confirmed'),
(4, 4, '2026-02-02', '11:00', 'Cancelled'),
(5, 5, '2026-02-03', '09:00', 'Confirmed'),
(6, 6, '2026-02-03', '14:00', 'Pending'),
(7, 7, '2026-02-04', '09:00', 'Confirmed'),
(8, 8, '2026-02-04', '10:00', 'Pending'),
(9, 9, '2026-02-05', '09:00', 'Confirmed'),
(10, 10, '2026-02-05', '10:00', 'Confirmed');

SELECT * FROM Patients;
SELECT * FROM Doctors;
SELECT * FROM DoctorSchedules;
SELECT * FROM Appointments;
