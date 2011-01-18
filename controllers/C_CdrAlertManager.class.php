<?php
/************************************************************************
                        C_CdrAlertManager.php - Copyright Ensoftek

**************************************************************************/

require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");
require_once($GLOBALS['fileroot'] ."/library/classes/CdrAlertManager.class.php");


class C_CdrAlertManager extends Controller {

        var $template_mod;
        var $pid;
        var $alert;

        function C_CdrAlertManager($template_mod = "general") {
                parent::Controller();
                $this->pid = "-1";
                $this->alert = "";
                $this->rules = array();
                $this->template_mod = $template_mod;
                $this->assign("FORM_ACTION", $GLOBALS['webroot']."/controller.php?" . $_SERVER['QUERY_STRING']);
                $this->assign("CURRENT_ACTION", $GLOBALS['webroot']."/controller.php?" . "cdr&");
                $this->assign("STYLE", $GLOBALS['style']);
                $this->assign("CSS_HEADER",  $GLOBALS['css_header'] );
                $this->assign("WEB_ROOT", $GLOBALS['webroot'] );
        }

        function default_action() {
        		$c = new CdrAlertManager();
                $this->assign("rules", $c->populate($this->pid));
        	
                if ($this->alert == "patient") {
                	$this->display($GLOBALS['template_dir'] . "cdr/" . $this->template_mod . "_patient.html");
                }
                else {
                	$this->display($GLOBALS['template_dir'] . "cdr/" . $this->template_mod . "_clinic.html");
                }
        }

        
        function edit_patient() {
			$ids = $_POST['id'];
			$pid = $_POST['pid'];
			$patient_reminders =  $_POST['onoffdef'];
			
		    //print_r($ids);
			//print_r($patient_reminders);
			
		    // Reflect the changes to the database.
            $c = new CdrAlertManager();
            $c->update($pid, $ids, $patient_reminders);
				
        }
         
        function edit_clinic() {
        	
        }
         
        
		function edit_action($id = "", $alert = "", $pid="-1") {
			    $this->pid = $pid;
			    $this->alert = $alert;
                $this->assign("pid", $pid);
                $this->assign("alert", $alert);
                $this->default_action();
		}
		
		function edit_action_process() {
       		//print_r($_POST);
			if ($_POST['process'] != "true")
				return;
				
			if ( $_POST['alert'] == "patient" ) {
				$this->edit_patient();
			}
			else {
				$this->edit_clinic();
			}
				
			$_POST['process'] = "";
			
		}
        		        
}

?>
