 <? 
  //PageClass is extended 
  //my-query is method from PageClass is used in DatabaseAdapter
 class DatabaseAdapter extends PageClass {
    function __construct() {
    	parent::db_Connection();
    } 

    public function SelectQueryExecution() {
    	//dbcin
        try {
             $AllSubjectsInfoRecords = $this->my_query("
								  SELECT * 
								  FROM subject ");
             return $AllSubjectsInfoRecords;  
        }
        catch (Exception $e) {
         $e->getMessage();
        }               
        
    }

    public function UpdateQueryExecution( $subjectInfo) {
        echo "in update";
    	$subjectName = $subjectInfo['subjectname'];
    	$subjectid = $subjectInfo['subjectid'];   
        try {   

             $this->my_query( " UPDATE subject set sub_name = '$subjectName'
				        WHERE sub_id = $subjectid ");
          }
          catch (Exception $e) {
           $e->getMessage();
         }
    }

    public function InsertQueryExecution( $subjectName) {   
        try { 	
		     $this->my_query("insert into subject values( NULL ,'$subjectName')");	
        }
        catch (Exception $e) {
          $e->getMessage();
        }
    }
  }

 ?>