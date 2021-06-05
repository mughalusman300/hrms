<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Payroll extends BaseConfig
{
    public $employeeattendance = array(
    'present' => 1,
    'half_day' => 4,
    'late' => 2,
    'absent' => 3,
    'holiday' => 5
     );
}



