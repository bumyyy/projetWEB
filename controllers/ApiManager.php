<?php

class ApiManager extends Controller{

    public function login($mail, $password){

        $this->loadModel('Password');
        $this->Password->isPassword(urldecode($mail), $password);

    }

    public function user($mail){

        $this->loadModel('User');
        $this->User->getUserByMail(urldecode($mail));
        
    }

    public function combox($field, $field1 = ""){

        $this->loadModel('Combox');
        $this->Combox->$field($field1);
    
    }

    public function company($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = ""){

        $this->loadModel('Company');

        switch ($action) {

            case 'allCompany':
                $this->Company->$action();
                break;

            case 'companyBySearch':
                $this->Company->$action($field1);
                break;

            case 'selectCompany':
                $this->Company->$action($field1);
                break;

            case 'addCompany':
                $this->Company->$action($field1, $field2, $field3, $field4, $field5);
                break;

            case 'editCompany':
                $this->Company->$action($field1, $field2, $field3, $field4, $field5);
                break;

            case 'deleteCompany':
                $this->Company->$action($field1);
                break;
            
            case 'statSector':
                $this->Company->$action();
                break;

            case 'statCity':
                $this->Company->$action();
                break;

            case 'statop3':
                $this->Company->$action();
                break;

            case 'rate':
                $this->Company->$action($field1, $field2, $field3);
                break;
                
            default:
                echo "Action for 'company' not define";
                break;
        }

    }

    public function internship($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = "", $field6 = "",$field7 = "", $field8 = "", $field9 = "", $field10 = ""){

        $this->loadModel('Internship');

        switch ($action) {

            case 'allInternship':
                $this->Internship->$action();
                break;

            case 'internshipBySearch':
                $this->Internship->$action($field1);
                break;

            case 'selectInternship':
                $this->Internship->$action($field1);
                break;

            case 'addInternship':
                $this->Internship->$action($field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9);
                break;

            case 'statSkill':
                $this->Internship->$action();
                break;

            case 'statCity':
                $this->Internship->$action();
                break;

            case 'statPromo':
                $this->Internship->$action();
                break;

            case 'statDuration':
                $this->Internship->$action();
                break;

            case 'statWish':
                $this->Internship->$action();
                break;

            case 'edit':
                $this->Internship->$action($field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9, $field10);
                break;

            case 'delete':
                $this->Internship->$action($field1);
                break;
            
            default:
                echo "Action for 'internship' not define";
                break;
        }

    }

    public function pilot($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = "", $field6 = ""){

        $this->loadModel('Pilot');

        switch ($action) {

            case 'addPilot':
                $this->Pilot->$action($field1, $field2, $field3, $field4, $field5, $field6);
                break;
            case 'editPilot':
                $this->Pilot->$action($field1, $field2, $field3, $field4, $field5, $field6);
                break;
            case 'allPilot':
                $this->Pilot->$action();
                break;

            case 'pilotBySearch':
                $this->Pilot->$action($field1);
                break;

            case 'selectPilot':
                $this->Pilot->$action($field1);
                break;

            
            case 'addPilot':
                $this->Pilot->$action($field1, $field2, $field3, $field4, $field5);
                break;
            
            default:
                echo "Action for 'pilot' not define";
                break;
        }
    }

    public function student($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = "", $field6 = "", $field7 = ""){

        $this->loadModel('Student');

        switch ($action) {

            case 'allStudent':
                $this->Student->$action();
                break;

            case 'studentBySearch':
                $this->Student->$action($field1);
                break;

            case 'selectStudent':
                $this->Student->$action($field1);
                break;

            case 'addStudent':
                $this->Student->$action($field1, $field2, $field3, $field4, $field5, $field6);
                break;

            case 'deleteStudent':
                $this->Student->$action($field1);
                break;

            case 'editStudent':
                $this->Student->$action($field1, $field2, $field3, $field4, $field5, $field6);
                break;
            
            case 'statNbCandidacy':
                $this->Student->$action($field1);
                break;

            case 'statNbWaiting':
                $this->Student->$action($field1);
                break;

            case 'statNbAdmission':
                $this->Student->$action($field1);
                break;

            case 'statNbRefusal':
                $this->Student->$action($field1);
                break;

            case 'statNbLike':
                $this->Student->$action($field1);
                break;

            default:
                echo "Action for 'student' not define";
                break;
        }

    }

    public function application($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = ""){

        $this->loadModel('Application');

        switch ($action) {

            case 'allApplication':
                $this->Application->$action();
                break;

            case 'applicationBySearch':
                $this->Application->$action($field1);
                break;

            case 'selectApplication':
                $this->Application->$action($field1);
                break;

            case 'allApplicationByStudent':
                $this->Application->$action($field1);
                break;

            case 'uploadFile':
                $this->Application->$action($field1, $field2);
                break;
        
            case 'submitApplication':
                $this->Application->$action($field1, $field2, $field3);
                break;
                    
            
            default:
                echo "Action for 'application' not define";
                break;
        }
    }


    public function favorite($action, $field1 = "",  $field2 = "",  $field3 = "",  $field4 = "", $field5 = ""){

        $this->loadModel('Favorite');

        switch ($action) {

            case 'allFavorite':
                $this->Favorite->$action();
                break;

            case 'addFavorite':
                $this->Favorite->$action($field1);
                break;

            case 'deleteFavorite':
                $this->Favorite->$action($field1);
                break;
            
            default:
                echo "Action for 'favorite' not define";
                break;
        }
    }

}