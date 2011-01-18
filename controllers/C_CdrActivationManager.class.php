<?php
/************************************************************************
                        C_CdrActivationManager.php - Copyright Ensoftek

**************************************************************************/

require_once ($GLOBALS['fileroot'] . "/library/classes/Controller.class.php");

class C_CdrActivationManager extends Controller {

        var $template_mod;
        var $rules;

        function C_CdrActivationManager($template_mod = "general") {
                parent::Controller();
                $this->rules = array();
                $this->template_mod = $template_mod;
                $this->assign("FORM_ACTION", $GLOBALS['webroot']."/controller.php?" . $_SERVER['QUERY_STRING']);
                $this->assign("CURRENT_ACTION", $GLOBALS['webroot']."/controller.php?" . "practice_settings&cdr_activation_manager&");
                $this->assign("STYLE", $GLOBALS['style']);
        		$this->assign("WEB_ROOT", $GLOBALS['webroot'] );
        }

        function default_action() {
                return $this->list_action();
        }


        function list_action() { 
                $c = new CdrActivationManager();
                $this->assign("rules", $c->populate());
        	
                return $this->fetch($GLOBALS['template_dir'] . "cdr/" . $this->template_mod . "_actmgr.html");
        }

		function list_action_process() {
			//print_r($_POST);
			if ($_POST['process'] != "true")
				return;
			
			$ids = $_POST['id'];
			$actives = $_POST['active'];
			$passives =  $_POST['passive'];
			$reminders =  $_POST['reminder'];
			
			// The array of check-boxes we get from the POST are only those of the checked ones with value 'on'.
			// So, we have to manually create the entitre arrays with right values.
			$actives_final = array();
			$passives_final = array();
			$reminders_final = array();
			
			$numrows = count($ids);
			for ($i = 0; $i < $numrows; ++$i) {
				
		        if ( $actives[$i] == "on") {
		        	$actives_final[] = "1";
		        }
		        else {
		        	$actives_final[] = "0";;
		        }
		        
		        if ( $passives[$i] == "on") {
		        	$passives_final[] = "1";
		        }
		        else {
		        	$passives_final[] = "0";;
		        }
		        
		        if ( $reminders[$i] == "on") {
		        	$reminders_final[] = "1";
		        }
		        else {
		        	$reminders_final[] = "0";;
		        }
		        
		        
		    }
			//print_r($actives_final);
			//print_r($passives_final);
			//print_r($reminders_final);

		    // Reflect the changes to the database.
            $c = new CdrActivationManager();
            $c->update($ids, $actives_final, $passives_final, $reminders_final);
			
			
        	$_POST['process'] = "";
			
		}
        

}

?>
