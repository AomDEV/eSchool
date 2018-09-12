<?php
class backend{
	private $db = null;
	private $table = "";
	private $config = array();
	private $render_options = array();
	private $readonly = array();
	private $primary_name = "";
	private $datetime = array();
	private $allow_add_button = false;
	private $dropdown = array();
	private $time = array();
	private $additionInputs = array();
	private $primaryKeyRequest = false;
	private $base64 = array();
	private $last_time = "";
	private $md5Input = array();
	private $autoFill = array();
	public function __construct($config,$database){
		$this->config = $config;
		$this->db = $database;
	}
	public function setPrimaryName($name){
		$this->primary_name = $name;
	}
	public function setTable($table_name=null){
		$this->table = $table_name;
	}
	public function setColumn($array_option=array()){
		$this->render_options = $array_option;
	}
	public function setReadonly($options=array()){
		$this->readonly = $options;
	}
	public function setDatetimeField($array=array()){
		$this->datetime = $array;
	}
	public function setTimeField($array=array()){
		$this->time = $array;
	}
	public function allowAddButton($allow){
		$this->allow_add_button = $allow;
	}
	public function setDropdown($drop=array()){
		$this->dropdown = $drop;
	}
	public function additionInput($inputs){
		$this->additionInputs = $inputs;
	}
	public function autoFill($column,$value){
		$this->autoFill[$column] = $value;
	}
	public function sendPrimaryKeyRequest($qry){
		$this->primaryKeyRequest = $qry;
	}
	public function InputBase64($a=array()){
		$this->base64=$a;
	}
	public function md5Input($input){
		$this->md5Input[] = $input;
	}
	public function setLastTime($column){
		$this->last_time = $column;
	}
	private function unescape($str){
		return $str;//urldecode($str);
	}
	private function escape($str){
		return htmlentities($str);
	}
	public function render($type,$request){
		$types = array("pure-table","form","table","only-table");
		if(in_array($type,$types)){
			if(true){//if($type=="pure-table" || $type=="table"){
				if((isset($request["edit"]) || isset($request["add"])) && $type!="only-table"){
					$priv_val = 0;
					if(isset($request["edit"])){$priv_val = $request["edit"];}
					if(isset($request["add"])){$priv_val = $request["add"];}
					$multipart = null;
					if(isset($this->additionInputs["file"])){$multipart = 'enctype="multipart/form-data"';}
					echo "<script src='../public/assets/js/semantic.min.js'></script>";
					echo "<form class='ui form' method='post' action='{$_SERVER['REQUEST_URI']}' {$multipart}>";

					if(isset($request["action"]) and $request["action"]==1){
						if(isset($request["edit"])){
							$sql = "UPDATE {$this->table} SET ";
							foreach(array_keys($this->render_options) as $link=>$row){
								if(in_array($row,$this->readonly)){continue;}
								$value = $request[$row];
								if(in_array($row,$this->datetime)){$value = strtotime($request[$row]);}
								if(in_array($row,$this->base64)){$value = $this->unescape(base64_decode($value));}
								if(in_array($row,$this->md5Input)){$value = md5($value);}
								if(isset($this->autoFill[$row])){$value = $this->autoFill[$row];}
								$sql .= $row."='".$value."'";
								if($link!=count(array_keys($this->render_options))-1){$sql.=",";}
							}
							if(isset($this->last_time) and strlen($this->last_time)>0){ $sql.=",".$this->last_time." = '".time()."' "; }
							$sql .= "WHERE {$this->primary_name}=?;";
							//echo $sql;
							$this->db->insertRow($sql,array($priv_val));
							echo "<div class='alert alert-success'><i class='icon check circle'></i> Update successful!</div>";
						} else{
							$sql = "INSERT INTO {$this->table} (";
							foreach(array_keys($this->render_options) as $link=>$row){$sql.=$row;if($link!=count(array_keys($this->render_options))-1){$sql.=",";}}
							if(isset($this->last_time) and strlen($this->last_time)>0){ $sql.=",".$this->last_time; }
							$sql .= ") VALUES (";
							foreach(array_keys($this->render_options) as $link=>$row){
								$value = isset($request[$row]) ? $request[$row] : null;
								if(in_array($row,$this->datetime)){$value = strtotime($request[$row]);}
								if(in_array($row,$this->base64)){$value = $this->unescape(base64_decode($value));}
								if(in_array($row,$this->md5Input)){$value = md5($value);}
								if(isset($this->autoFill[$row])){$value = $this->autoFill[$row];}
								$sql.="'{$value}'";
								if($link!=count(array_keys($this->render_options))-1){$sql.=",";}
							}
							if(isset($this->last_time) and strlen($this->last_time)>0){ $sql.=",".time(); }
							$sql .= ");";
							//echo $sql;
							$this->db->insertRow($sql,array($priv_val));

							$uploadOk = 1;
							if(isset($this->additionInputs["file"]) and isset($_FILES[$this->additionInputs["file"]])){
								$field_name = $this->additionInputs["file"];
								$sqlMovie = "SELECT * FROM {$this->table} WHERE ";
								foreach(array_keys($this->render_options) as $link=>$row){
									if(!isset($request[$row])){continue;}
									$value = $request[$row];
									if(in_array($row, $this->datetime)){$value = strtotime($value);}
									$sqlMovie.=$row;
									$sqlMovie.="='{$value}'";
									if($link!=count(array_keys($this->render_options))-1){$sqlMovie.=" AND ";}
								}
								$getMovie = $this->db->getRow($sqlMovie,array());
								$get_id = $getMovie["id"];

								//Upload file
								$target_dir = "../assets/images/";
								$basename = basename($_FILES[$field_name]["name"]);
								$file_name = explode(".",$basename)[0];
								$file_ext = explode(".",$basename)[1];
								$target_file = $target_dir . $basename;
								$new_filename = $target_dir.$get_id.".".$file_ext;
								$uploadOk = 1;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
								$check = getimagesize($_FILES[$field_name]["tmp_name"]);
								if($check !== false) {
									$mime = $check["mime"];
									if (move_uploaded_file($_FILES[$field_name]["tmp_name"], $new_filename)) {
										$uploadOk = 1;
									}
								} else{ // Failure
									$uploadOk = 0;
								}
								//Upload file
							}
							if($uploadOk == 1){
								echo "<div class='alert alert-success'><i class='icon check circle'></i> Create data successful!</div>";
							}
						}
					}

					$sqlAcc = "SELECT * FROM {$this->table} WHERE {$this->primary_name}=?";
					if($this->db->getNumber($sqlAcc,array($priv_val))<=0 and isset($request["edit"])){
						echo "<h2 class='alert alert-danger'>Not found data</h2>";
						echo "<div align='right'><a class='btn btn-default btn-sm' href='./?page=".$request["page"]."'><i class='icon home'></i>Home</a></div>";return;
					}
					$getInfo = $this->db->getRow($sqlAcc,array($priv_val));
					for($i=0;$i<count($this->render_options);$i++){
						$field_id = array_keys($this->render_options)[$i];
						$field_name = $this->render_options[$field_id];
						$disabled = null;
						if(in_array($field_id,$this->readonly)){$disabled = "disabled='disabled'";}
						echo "<div class='field' align='left'>";
						echo "<label>".$field_name."</label>";
						$type = "text";
						$value = $getInfo[$field_id];
						if(in_array($field_id,$this->datetime)){$type = "datetime-local";$value = date('Y-m-d H:i', $value);}
						if(in_array($field_id,$this->time)){$type = "time";$value = str_replace(".",":",$value);}
						if(in_array($field_id,$this->base64)){$value = $this->escape($value);}
						if(isset($this->autoFill[$field_id])){$value = $this->autoFill[$field_id];}
						if(isset($request["add"])){$value = null;}
						if(isset($this->dropdown[$field_id])){
							echo "<select class='ui search selection dropdown' id='{$field_id}' name='{$field_id}'>";
							foreach($this->dropdown[$field_id] as $index=>$row){
								if($value==$index){$active = "selected";}else{$active=null;}
								echo "<option value='{$index}' {$active}>{$row}</option>";
							}
							echo "</select>";
							echo "<script>$('#{$field_id}').dropdown();</script>";
						} else{
							echo "<input type='{$type}' name='".$field_id."' {$disabled} autocomplete='off' value='{$value}' required placeholder='".$field_name."'>";
						}
						echo "</div>";
					}
					if(count($this->additionInputs) > 0 && isset($request["add"])){
						foreach($this->additionInputs as $link=>$row){
							echo "<div class='field' align='left'>";
							echo "<label>".ucfirst(str_replace("_"," ",$row))."</label>";
							echo "<input type='{$link}' name='{$row}' id='{$row}' />";
							echo "</div>";
						}
					}

					echo "<input type='hidden' name='action' value='1' />";
					echo "<div align='right'>";
					echo "<button class='btn btn-success'><i class='icon check'></i> ";if(isset($request["edit"])){echo "EDIT";}else{echo "ADD";}echo "</button> ";
					echo "<a href='./?page=".$request["page"]."' class='btn btn-default'><i class='icon home'></i> Home</a> ";
					echo "</div>";
					echo "</form>";
				} else if(isset($request["delete"])){
					$this->db->insertRow("DELETE FROM {$this->table} WHERE {$this->primary_name}=?",array($request["delete"]));
					echo "<h2 class='alert alert-success'><i class='icon check'></i> Delete successful!</h2>";
					echo "<div align='right'><a href='./?page=".$request["page"]."' class='btn btn-default'><i class='icon home'></i> Home</a></div>";
				} else{
					if($type=="table" || $type=="only-table"){
						echo "<form action='".$_SERVER['PHP_SELF']."'><div align='right' style='margin-bottom:10px;'>";
						echo "<input type='hidden' name='page' value='".$request['page']."' />";
						echo "<div class='ui action input'>";
						echo "<input type='text' name='search' autocomplete='off' required value='".(isset($_GET["search"])?$_GET["search"]:null)."' placeholder='Search'>";
						echo "<button type='submit' class='ui button'><i class='icon search'></i> Search</button>";
						echo "</div>";
						if($this->allow_add_button){echo " <a href='./?page=".$request["page"]."&add=1' class='ui icon button positive'><i class='icon plus circle'></i> ADD</a>";}
						echo "</div></form>";
					}

					$sql = "SELECT * FROM {$this->table}";
					$limit = 10;
					$total_pages = ceil($this->db->getNumber($sql,array()) / $limit);
					$page = 1;
					if(isset($request["i"]) and is_numeric($request["i"])){$page = $request["i"];}
					$start_from = ($page-1) * $limit;

					if($type=="table" || $type=="only-table"){
						echo "<div class='table-responsive'>";
						echo "<table class='table table-bordered table-hover'>";
						echo "<tr class='active'>";
						for($i=0;$i<count($this->render_options);$i++){
							echo "<th><center>".$this->render_options[array_keys($this->render_options)[$i]]."</center></th>";
						}
						echo "<th width=100>Action</th>";
						echo "</tr>";
						if(($type=="table" || $type=="only-table") and isset($request["search"])){
							$sql .= " WHERE ";
							foreach(array_keys($this->render_options) as $link=>$row){
								if($this->primary_name == $row){
									$sql .= $row."='".$request["search"]."'";
								} else{
									$sql .= $row." LIKE '%".$request["search"]."%'";
								}
								if($link!=count(array_keys($this->render_options))-1){$sql.=" OR ";}
							}
						}
						$sql .=" ORDER BY {$this->primary_name} DESC LIMIT {$start_from},{$limit}";
						$getData = $this->db->getRows($sql,array());
						if(count($getData)<= 0){
							echo "<tr><td colspan='".(count($this->render_options)+1)."'><center>Not found data</center></td></tr>";
						} else{
							foreach($getData as $key=>$row){
								echo "<tr>";
								for($i=0;$i<count($this->render_options);$i++){
									$field_id = array_keys($this->render_options)[$i];
									$value = $row[$field_id];
									if(in_array($field_id,$this->datetime)){
										$value=date("d/m/Y H:i",$value);
									}

									if(strlen($value)>=20){$value = mb_substr($value, 0, 20, 'UTF-8');}
									if(in_array($field_id,$this->base64)){$value = base64_decode($value);}
									if(isset($this->dropdown[$field_id]) and isset($this->dropdown[$field_id][$value])){echo '<td><center>'.$this->dropdown[$field_id][$value].'</center></td>';} else{
										if(in_array($field_id,$this->base64)){$value = base64_encode($value);}
										echo "<td><center>".htmlentities($value)."</center></td>";
									}
								}
								echo "<td><center>";
								$add = ($this->primaryKeyRequest) ? "&".$this->primary_name."=".$row[$this->primary_name] : "&edit=".$row[$this->primary_name];
								echo "<a href='./?page=".$request['page'].$add."' class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-edit'></i></a> ";
								echo "<a onclick=\"return confirm('Sure?');\" href='./?page=".$request['page']."&delete=".$row[$this->primary_name]."' class='btn btn-danger btn-sm'>";
								echo "<i class='glyphicon glyphicon-trash'></i>";
								echo "</a> ";
								echo "</center></td>";
								echo "</tr>";
							}
						}
						echo "</table>";
						echo "</div>";

						for ($i=1; $i<=$total_pages; $i++) {
							$vars = array('page' => $request["page"], 'i' => $i);
							$btn_class = "default";
							if(!isset($request["i"]) and $i==1){$btn_class = "primary";}
							if(isset($request["i"]) and $request["i"]==$i){$btn_class = "primary";}
							echo " <a class='btn btn-{$btn_class} btn-sm' href='./?".http_build_query($vars)."'>$i</a> ";
						}

					}
				}
			}
		}
	}
}
?>