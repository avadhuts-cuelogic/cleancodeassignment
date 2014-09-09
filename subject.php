<?php

require('DatabaseAdapter.php');

class Subject {	

   public function ifUserSessionUnsetLoadUserLoginPage() {	 
	    if(!isset($_SESSION["user_id"])) {
		  $this->loadUserLoginPage();
		}
	}

	function __construct() {
    	$this->ifUserSessionUnsetLoadUserLoginPage();
    	//parent::db_Connection();
    }

    public function loadUserLoginPage() {
    	header("Location:./index.php?action=login");
    }    

    public function fetchSubjectsInfoFromRecords( $AllSubjectsInfoRecords) {
         while($arrSubject = mysql_fetch_assoc( $AllSubjectsInfoRecords)) {				
		    $AllSubjectsInfo[$arrSubject['sub_id']] = $arrSubject['sub_name'];				    	
		 }
		 return $AllSubjectsInfo;
     }

    public function getAllSubjectInfoFromDatabase() {  
         $DatabaseAdapterSelect = new DatabaseAdapter(); 
  	 $AllSubjectsInfoRecords = $DatabaseAdapterSelect->SelectQueryExecution();   	
	 $AllSubjectsInfo = $this->fetchSubjectsInfoFromRecords( $AllSubjectsInfoRecords);		
	 return $AllSubjectsInfo;
     }    

    public function getAllSubjectInfo() {		
	$AllSubjectsInfo = array();	
        $AllSubjectsInfo = $this->getAllSubjectInfoFromDatabase();						
        return $AllSubjectsInfo;
    }

   public function generateHTMLForSubjectTableRecords( $AllSubjectsInfo) {
        $subjectTableRecordsHTMLCode = "";

         foreach ($AllSubjectsInfo as $subjectkey => $subjectName) {					
	    $subjectTableRecordsHTMLCode .= '
										<tr>
											<td>'.$subjectName.'</td>
											<td>
												<a href="./index.php?action=editSubject&subkey='.$subjectkey.'">editSubject</a>
											</td>
										</tr>';
	 }
        return $subjectTableRecordsHTMLCode;      
    }

    public function renderSubjectHTML( $SubjectTableRecordsHTMLCode) {					
        $SubjectHTMLCode = file_get_contents('subjectPartial1.html');
	$SubjectHTMLCode .= $SubjectTableRecordsHTMLCode;
        $SubjectHTMLCode .= file_get_contents('subjectPartial2.html');
	return $SubjectHTMLCode;
    } 

    public function getSubjectPageInfo() {
        $AllSubjectsInfo = $this->getAllSubjectInfo();
        $SubjectTableRecordsHTMLCode = $this->generateHTMLForSubjectTableRecords( $AllSubjectsInfo);
        $SubjectHtml = $this->renderSubjectHTML( $SubjectTableRecordsHTMLCode);
        return $SubjectHtml;
    }

    public function loadSubjectPage() {
        $SubjectHtmlCode = $this->getSubjectPageInfo();
        return $SubjectHtmlCode;
    } 

	public function renderEditSubjectHTML() {
       	$editSubjectHTMLCode .='<div id="detail" >
                                <fieldset>
                                    <legend>Edit Marks</legend>
                                        <form action="./index.php?action=editSubject&subkey='.$_GET['subkey'].'" method="post">  
                                        <ul>
                                            <li>
                                                <div class="field_name">Subject Name :</div>
                                                <div class="floatleft"><input type="text" name="subjectName"></div>
                                            </li>                               
                                        </ul>
                                        <ul>
                                            <li>
                                                <div class="floatleft">
                                                   <li><input type="submit" name="btnSubmit" value="Edit"></li>
                                                </div>
                                            </li>
                                        </ul>
                                     </form>    
                                </fieldset>
                            </div>';
		return $editSubjectHTMLCode;
	}

   public function getModifiedSubjectInfo() {
    	$subjectInfo = array();
        $subjectInfo['subjectname'] = $_POST['subjectName'];
		$subjectInfo['subjectid'] = $_GET['subkey'];
        print_r($subjectInfo);
		return $subjectInfo;
    }   

    public function getSubjectInfoandUpdateInDatabase() {
        $DatabaseAdapterUpdate = new DatabaseAdapter();
    	$subjectInfo = $this->getModifiedSubjectInfo();    	
        echo "Hiin database";
    	$DatabaseAdapterUpdate->UpdateQueryExecution( $subjectInfo);        	
    }        
    
    public function onSubmitEditSubjectInfo() {					
		if(isset($_POST['btnSubmit']))	{ 
		    $this->getSubjectInfoandUpdateInDatabase();	
            echo "Onsubmit";						
			//header("Location:./index.php?action=subject");           		
		}						
	}      

    public function loadEditSubjectPage() {
   	    $this->onSubmitEditSubjectInfo(); 
        $editHtmlCode = $this->renderEditSubjectHTML();            
        return  $editHtmlCode;
     } 

    public function getAndaddSubjectInDatabase() {
        $subjectName = $_POST['subjectName'];
        $DatabaseAdapterInsert = new DatabaseAdapter();
		$DatabaseAdapterInsert->InsertQueryExecution($subjectName); 
    }

    public function onSubmitaddSubject() {
        if(isset($_POST['btnSubmit'])) {	
            $this->getAndaddSubjectInDatabase();								
			header("Location:./index.php?action=subject");	
		}
    }

    public function renderAddSubjectHTML() {		
		$addSubjectHTMLCode = file_get_contents('addSubject.html');		                 
		return $addSubjectHTMLCode;
	}

    public function loadAddSubjectPage() {           
        $this->onSubmitaddSubject();
        return $this->renderAddSubjectHTML();	
    } 
}

?>
