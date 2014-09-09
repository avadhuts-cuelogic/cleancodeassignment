	<?php


	class SubjectClass extends PageClass {
		
		public function checkSession(){
	 
		if(!isset($_SESSION["user_id"])){
			header("Location:./index.php?action=login");

			}
		}
		
		public function subjectHTML(){

			$this->checkSession();

			$this->checkSession();
				$strSubjectHTML = '
					<div id="detail" >
						<fieldset>
							<legend>Filter By Name</legend>
								<form action="./index.php?action=subject" method="post">
									<ul>
											

								<div>
								<br> ';

				$arrUserInfo = $this->getSubjectInfo();
				//echo "<pre>";print_r($arrUserInfo);die;
				$strSubjectHTML .= '
								<table border=1>
								<tr>
									
									<th>Subject Name</th>
									<th>Edit_Subject</th>
									
								</tr>';
								
									foreach ($arrUserInfo as $key => $value) {
								
					$strSubjectHTML .= '
									<tr>
										<td>'.$value.'</td>
										<td>
											<a href="./index.php?action=editSubject&subkey='.$key.'">editSubject</a>
										</td>
									</tr>';
									}
								
					$strSubjectHTML .= '
									
												
											</table>
											<a href="./index.php?action=addSubject" style="text-decoration:none;"><input type="button" name="add" value="Add Subject"></a>
											<a href="./index.php?action=subject"><input type="button" name="reset" value="Reset"></a>
										</fieldset>
										</div>
									</ul>
								</form>	
						</fieldset>
					</div>';



			return $strSubjectHTML;

		}

		public function getSubjectInfo(){
			
			$this->checkSession();
			parent::db_Connection();
			$arrSubjectInfo = array();
			$strSubInfo = parent::my_query("
								SELECT * 
								FROM subject ");
							//$result = mysql_query('select * from stud_info',$link);
							
							if(!$strSubInfo)
								die('Invalid Query'.mysql_error());
							//$rowCount = mysql_num_rows($strStudName);
							//echo "No. of records in table".$rowCount;

							while ($arrSubject = mysql_fetch_assoc($strSubInfo)) {

								//print_r($arrSubject['sub_id']);
									
								$arrSubjectInfo[$arrSubject['sub_id']] = $arrSubject['sub_name'];
								
								
								//echo "<pre>";print_r($arrSubjectInfo);
								
									    	
							}
							//echo "<pre>";print_r($arrSubjectInfo);
							//die;
						return $arrSubjectInfo;




		}

		public function editSubjectHTML(){

			$this->checkSession();
			$strEditSubjectHTML .='
							<div id="detail" >
								<fieldset>
									<legend>Edit Marks</legend>
										<form action="./index.php?action=editSubject&subkey='.$_GET['subkey'].'"method="post">
										<ul>
											<li>
												<div class="field_name">Subject Name :</div>
												<div class="floatleft"><input type="text" name="subjectName"></div>
											</li>	
							
										</ul>		
										';
			$this->setSubjectInfo();			

			$strEditSubjectHTML .= '
									<li>
										<div class="floatleft">
										<li><input type="submit" name="btnSubmit" value="Edit"></li>
										
										</div>
									</li>
								</ul>
							</form>	
						</fieldset>
						</div>';										



						return $strEditSubjectHTML;
		}


		/*
		*set subject info
		*/
		public function setSubjectInfo(){

						$subid = $_GET['subkey'];
						parent::db_Connection();

						//print_r($_POST);
						//die;
						if(isset($_POST['btnSubmit']))
						{	
							$sub_Name = $_POST['subjectName'];
							parent::my_query("
								UPDATE subject set sub_name = '$sub_Name'
								WHERE sub_id = $subid " 
								);
						
							//echo "Information Updated successfully";
							header("Location:./index.php?action=subject");
										
								
						}
						
		}//End of setEditProfileHTML

		public function addSubjectHTML(){
			$this->checkSession();
			$strEditSubjectHTML .='
							<div id="detail" >
								<fieldset>
									<legend>Edit Marks</legend>
										<form action="./index.php?action=addSubject" method="post">
										<ul>
											<li>
												<div class="field_name">Subject Name :</div>
												<div class="floatleft"><input type="text" name="subjectName"></div>
											</li>	
							
										</ul>		
										';
			$this->addSubject();			

			$strEditSubjectHTML .= '
									<li>
										<div class="floatleft">
										<li><input type="submit" name="btnSubmit" value="Add"></li>
										</div>
									</li>
								</ul>
							</form>	
						</fieldset>
						</div>';										



						return $strEditSubjectHTML;

		}


	public function addSubject(){
						parent::db_Connection();

						//print_r($_POST);
						//die;
						if(isset($_POST['btnSubmit']))
						{	
							$sub_Name = $_POST['subjectName'];
							parent::my_query("
								insert into subject values( NULL ,'$sub_Name') 
 								"
								);
						
							//echo "Information Updated successfully";
							header("Location:./index.php?action=subject");
										
								
						}
		

	}

}

	?>