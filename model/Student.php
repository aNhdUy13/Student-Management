<?php
class Student
{
    public $studentId;
    public $studentName;
    public $studentAge;
    public $studentClass;
    public $studentPhoneNumber;
    public $studentAddress;

    public function __construct
    ($studentId, $studentName, $studentAge,$studentClass, $studentPhoneNumber, $studentAddress)
    {
        $this->studentId = $studentId;
        $this->studentName = $studentName;
        $this->studentAge = $studentAge;
        $this->studentClass = $studentClass;
        $this->studentPhoneNumber = $studentPhoneNumber;
        $this->studentAddress = $studentAddress;
    }
}

?>